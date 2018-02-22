<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * PseudopregnantRecipientOrderEntries Controller
 *
 * @property \App\Model\Table\PseudopregnantRecipientOrderEntriesTable $PseudopregnantRecipientOrderEntries
 */
class PseudopregnantRecipientOrderEntriesController extends AppController
{

    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('Entries'); //make Controller->Component->EntriesComponent.php available
    }

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['PseudopregnantRecipientOrders']
        ];
        $this->set('pseudopregnantRecipientOrderEntries', $this->paginate($this->PseudopregnantRecipientOrderEntries));
        $this->set('_serialize', ['pseudopregnantRecipientOrderEntries']);
    }

    /**
     * View method
     *
     * @param string|null $id Pseudopregnant Recipient Order Entry id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $pseudopregnantRecipientOrderEntry = $this->PseudopregnantRecipientOrderEntries->get($id, [
            'contain' => ['PseudopregnantRecipientOrders']
        ]);
        $this->set('pseudopregnantRecipientOrderEntry', $pseudopregnantRecipientOrderEntry);
        $this->set('_serialize', ['pseudopregnantRecipientOrderEntry']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add($orderId = null, $is_recipient = null)
    {
        $pseudopregnantRecipientOrderEntry = $this->PseudopregnantRecipientOrderEntries->newEntity();
        $this->set('currentOrderId', [$orderId]);
        if ($this->request->is('post')) {
            $pseudopregnantRecipientOrderEntry = $this->PseudopregnantRecipientOrderEntries->patchEntity($pseudopregnantRecipientOrderEntry, $this->request->data);
            if ($this->PseudopregnantRecipientOrderEntries->save($pseudopregnantRecipientOrderEntry)) {
                
                //Add up quantity of all entries and save as order->total plugs
                $total_plugs = $this->Entries->sumTotalPlugs($orderId); 
                $this->Entries->saveTotalPlugsInOrder($orderId, $total_plugs);

                $this->Flash->success(__('Order entry has been saved. Scroll down to see it. You can now finalize your order or add more entries.'));
                return $this->redirect(['controller' => 'PseudopregnantRecipientOrders','action' => 'view', $orderId]);
            } else {
                $this->Flash->error(__('The pseudopregnant recipient order entry could not be saved. Please, try again.'));
            }
        }
        $pseudopregnantRecipientOrders = $this->PseudopregnantRecipientOrderEntries->PseudopregnantRecipientOrders->find('list', ['limit' => 200]);
        $this->set(compact('pseudopregnantRecipientOrderEntry', 'pseudopregnantRecipientOrders'));

        if (isset($is_recipient)) {
            $this->set('recipients', true);
        }
        $this->set('_serialize', ['pseudopregnantRecipientOrderEntry']);        
    }

    /**
     * Edit method
     *
     * @param string|null $id Pseudopregnant Recipient Order Entry id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $pseudopregnantRecipientOrderEntry = $this->PseudopregnantRecipientOrderEntries->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $pseudopregnantRecipientOrderEntry = $this->PseudopregnantRecipientOrderEntries->patchEntity($pseudopregnantRecipientOrderEntry, $this->request->data);
            if ($this->PseudopregnantRecipientOrderEntries->save($pseudopregnantRecipientOrderEntry)) {

                //Add up quantity of all entries and save as order->total plugs
                $orderId = $pseudopregnantRecipientOrderEntry->pseudopregnant_recipient_order_id;
                $total_plugs = $this->Entries->sumTotalPlugs($orderId); 
                $this->Entries->saveTotalPlugsInOrder($orderId, $total_plugs);

                $this->Flash->success(__('Order entry has been saved. Scroll down to see it.'));
                return $this->redirect(['controller' => 'PseudopregnantRecipientOrders' ,'action' => 'view', $pseudopregnantRecipientOrderEntry['pseudopregnant_recipient_order_id']]);
            } else {
                $this->Flash->error(__('The pseudopregnant recipient order entry could not be saved. Please, try again.'));
            }
        }
        $pseudopregnantRecipientOrders = $this->PseudopregnantRecipientOrderEntries->PseudopregnantRecipientOrders->find('list', ['limit' => 200]);

        if ($pseudopregnantRecipientOrderEntry->type == 'Recipient') {
            $this->set($recipients, true);    
        }

        $this->set(compact('pseudopregnantRecipientOrderEntry', 'pseudopregnantRecipientOrders'));
        $this->set('_serialize', ['pseudopregnantRecipientOrderEntry']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Pseudopregnant Recipient Order Entry id.
     * @return void Redirects to Recipient Order view.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $pseudopregnantRecipientOrderEntry = $this->PseudopregnantRecipientOrderEntries->get($id);
        if ($this->PseudopregnantRecipientOrderEntries->delete($pseudopregnantRecipientOrderEntry)) {

            //Add up quantity of all entries and save as order->total plugs
            $orderId = $pseudopregnantRecipientOrderEntry->pseudopregnant_recipient_order_id;
            $total_plugs = $this->Entries->sumTotalPlugs($orderId); 
            $this->Entries->saveTotalPlugsInOrder($orderId, $total_plugs);            

            $this->Flash->success(__('The entry has been deleted.'));
        } else {
            $this->Flash->error(__('The pseudopregnant recipient order entry could not be deleted. Please, try again.'));
        }
        return $this->redirect(['controller' => 'PseudopregnantRecipientOrders' ,'action' => 'view', $pseudopregnantRecipientOrderEntry['pseudopregnant_recipient_order_id']]);
    }
}