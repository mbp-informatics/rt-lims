<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Mailer\MailerAwareTrait; 
use Cake\Core\Exception\Exception;
use Cake\Core\Configure;

/**
 * PseudopregnantRecipientOrders Controller
 *
 * @property \App\Model\Table\PseudopregnantRecipientOrdersTable $PseudopregnantRecipientOrders
 */
class PseudopregnantRecipientOrdersController extends AppController
{
    use MailerAwareTrait;

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $pro = $this->PseudopregnantRecipientOrders->find('all')->contain(['Users', 'PseudopregnantRecipientOrderEntries']);
        
        //In-house B6NCR orders
        if (isset($this->request->query['in_house'])) {
            $this->set('in_house', $this->request->query['in_house']);    
            $pro->matching('PseudopregnantRecipientOrderEntries', function ($q) {
                return $q->where(['PseudopregnantRecipientOrderEntries.type' => 'in-house B6NCRL']);
            });
        } else {
            //Pseudopregnant Recipient orders
            $pro->notMatching('PseudopregnantRecipientOrderEntries', function ($q) {
                return $q->where(['PseudopregnantRecipientOrderEntries.type' => 'in-house B6NCRL']);
            });
        }

        $this->set('pseudopregnantRecipientOrders', $pro->distinct('PseudopregnantRecipientOrders.id'));
        $this->set('_serialize', ['pseudopregnantRecipientOrders']);
    }

    /**
     * View method
     *
     * @param string|null $id Pseudopregnant Recipient Order id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {        
        $pseudopregnantRecipientOrder = $this->PseudopregnantRecipientOrders->get($id, [
            'contain' => ['Users', 'PseudopregnantRecipientOrderEntries']
        ]);

        if (isset($pseudopregnantRecipientOrder->pseudopregnant_recipient_order_entries[0])) {
            $type = isset($pseudopregnantRecipientOrder->pseudopregnant_recipient_order_entries[0]->type) ? $pseudopregnantRecipientOrder->pseudopregnant_recipient_order_entries[0]->type : 'Recipient';
            $this->set('type', $type);
        }
        
        if (isset($this->request->query['in_house'])) {
            $this->set('in_house', $this->request->query['in_house']);  
        }

        $this->set('pseudopregnantRecipientOrder', $pseudopregnantRecipientOrder);
        $this->set('_serialize', ['pseudopregnantRecipientOrder']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $pseudopregnantRecipientOrder = $this->PseudopregnantRecipientOrders->newEntity();
        if ($this->request->is('post')) {
            $pseudopregnantRecipientOrder = $this->PseudopregnantRecipientOrders->patchEntity($pseudopregnantRecipientOrder, $this->request->data);
            if ($order = $this->PseudopregnantRecipientOrders->save($pseudopregnantRecipientOrder)) {
                $this->Flash->warning(__('Your order is NOT READY yyy yet. Scroll down the page and add entries to your order.'));
                $redirParams = ['action' => 'view', $order['id']];
                $redirParams['in_house'] = isset($this->request->query['in_house']) ? '1' : null;
                return $this->redirect($redirParams);
            } else {
                $this->Flash->error(__('Your order could not be saved. Please, try again.'));
            }
        }

        if (isset($this->request->query['in_house'])) {
            $this->set('in_house', $this->request->query['in_house']);  
        }

        $users = $this->PseudopregnantRecipientOrders->Users->find('list', ['limit' => 200]);
        $this->set(compact('pseudopregnantRecipientOrder', 'users'));
        $this->set('_serialize', ['pseudopregnantRecipientOrder']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Pseudopregnant Recipient Order id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $pseudopregnantRecipientOrder = $this->PseudopregnantRecipientOrders->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $pseudopregnantRecipientOrder = $this->PseudopregnantRecipientOrders->patchEntity($pseudopregnantRecipientOrder, $this->request->data);
            if ($this->PseudopregnantRecipientOrders->save($pseudopregnantRecipientOrder)) {
                $this->Flash->success(__('The order has been saved.'));
                return $this->redirect(['action' => 'view', $id]);
            } else {
                $this->Flash->error(__('The pseudopregnant recipient order could not be saved. Please, try again.'));
            }
        }
        $users = $this->PseudopregnantRecipientOrders->Users->find('list', ['limit' => 200]);
        $this->set(compact('pseudopregnantRecipientOrder', 'users'));
        $this->set('_serialize', ['pseudopregnantRecipientOrder']);
    }

    /**
     * Finalize method
     *
     * @param string|null $id Pseudopregnant Recipient Order id.
     * @return void Redirects on successful finalization, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function finalize($id = null)
    {
        if (Configure::read('debug') === false ) { //send only if in production mode
            $emails = [
            'mvp@ucdavis.edu',
            'micl@ucdavis.edu',
            'mvp-m3@ucdavis.edu',
            'dlyoung@ucdavis.edu',
            'kmjager@ucdavis.edu',
            ];
        }

        //get order and associated entries and user info
        $ordersTable = TableRegistry::get('pseudopregnantRecipientOrders');
        $order = $ordersTable->get($id, [
            'contain' => ['Users', 'PseudopregnantRecipientOrderEntries']
        ]);
        $order->status = 'finalized'; 
        $order->finalize_date = date('Y-m-d H:i:s');
            if ($ordersTable->save($order)) {
                try {
                    if (isset($emails)) {
                        foreach ($emails as $email) {
                            /* The line below sends notification email from UserMailer
                             * It is wrapped in a loop to deliver to each recipient individually
                             * This is because it wasn't possible to deliver to MICL and MVP
                             * distribution lists using just one outgoing message
                             */
                            $this->getMailer('User')->send('finalize', [$order, $email]); 
                        }
                    } else {
                        $this->getMailer('User')->send('finalize', [$order, null]);     
                    }
                } catch (\Exception $e){
                    $this->AppErrors->saveError('email', "PseudoPregnantRecipient Order email notification couldn't be sent", $order->id);
                    $this->Flash->error(__('Email notification error: '. $e->getMessage()));    
                }
                $this->Flash->success(__('The order has been successfully finalized and sent for processing.'));
                return $this->redirect(['action' => 'view', $id]);
            } else {
                $this->Flash->error(__('The order could not be finalizezd. Please, try again.'));
            }        
    }

    /**
     * Delete method
     *
     * @param string|null $id Pseudopregnant Recipient Order id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $pseudopregnantRecipientOrder = $this->PseudopregnantRecipientOrders->get($id);
        if ($this->PseudopregnantRecipientOrders->delete($pseudopregnantRecipientOrder)) {
            $this->Flash->success(__('The order has been deleted.'));
        } else {
            $this->Flash->error(__('The pseudopregnant recipient order could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
