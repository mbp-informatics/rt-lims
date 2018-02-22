<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Datasource\ConnectionManager;

/**
 * Recipients Controller
 *
 * @property \App\Model\Table\RecipientsTable $Recipients
 */
class RecipientsController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        if ($param = isset($this->request->query['s']) ? $this->request->query['s'] : Null ) {
            $cond = $this->getSearchConditions($param, $this);
            $data = $this->Recipients->find('all', $cond)->contain(['EmbryoTransfers', 'Users']);
        } else {
            $data = $this->Recipients->find('all')->contain(['EmbryoTransfers', 'Users']);
        }

        $this->set('recipients', $this->paginate($data));
        $this->set('_serialize', ['recipients']);
    }

    /**
     * View method
     *
     * @param string|null $id Recipient id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $recipient = $this->Recipients->get($id, [
            'contain' => ['EmbryoTransfers', 'Users']
        ]);
        $this->set('recipient', $recipient);
        $this->set('_serialize', ['recipient']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function addSingle($embryo_transfer_id, $source=null)
    {
        $recipient = $this->Recipients->newEntity();
        if ($this->request->is('post')) {
            $recipient = $this->Recipients->patchEntity($recipient, $this->request->data);
            if ($this->Recipients->save($recipient)) {
                $this->Flash->success(__('The recipient has been saved.'));
                if ($source = 'mtgl'){
                    return $this->redirect(['controller'=> 'EmbryoTransfers', 'action' => 'view', '#' => 'related-recipients', $embryo_transfer_id, 'mtgl']);
                } else {
                    return $this->redirect(['controller'=> 'EmbryoTransfers', 'action' => 'view', '#' => 'related-recipients', $embryo_transfer_id]);
                }
            } else {
                $this->Flash->error(__('The recipient could not be saved. Please, try again.'));
            }
        }
        $this->set('embryo_transfer_id', [$embryo_transfer_id]);
        $embryoTransfers = $this->Recipients->EmbryoTransfers->find('list');
        $users = $this->Recipients->Users->find('list', ['limit' => 200]);
        $this->set(compact('recipient', 'embryoTransfers', 'users', 'source'));
        $this->set('_serialize', ['recipient']);
    }

    /**
     * Add multiple recipients method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add($etId, $source=null)
    {
        $recipient = $this->Recipients->newEntity();
        
        /* SAVE ENTRY TO DB */
        if ($this->request->is('post')) {
            /* Patch request data with $cryoId */
            foreach ($this->request->data as $key => $rec) {
               $this->request->data[$key]['embryo_transfer_id'] = $etId;
               $this->request->data[$key]['pups_born'] = 2;
            }  

            /* Save multiple vials */ 
            $recipients = TableRegistry::get('Recipients');
            $entities = $recipients->newEntities($this->request->data());
            // debug($entities);
            // exit;
            foreach ($entities as $entity) {
                $res = $recipients->save($entity);
                if ($res) {
                    $this->Flash->success(__('The recipient id:'.$res['id'].' has been saved.'));
                } else {
                    $this->Flash->error(__('The recipient could not be saved. Please, try again.'));
                }
            }

            if ($source == 'mtgl'){
                return $this->redirect(['controller'=> 'EmbryoTransfers', 'action' => 'view', '#' => 'related-recipients', $etId, 'mtgl']);
            } else {
                return $this->redirect(['controller'=> 'EmbryoTransfers', 'action' => 'view', '#' => 'related-recipients', $etId]);
            }

        } //end SAVE ENTRY TO DB
        
        $this->set([
            'recipient' => $recipient,
            'etId' => $etId,
            'source' => $source
            ]);
        $this->set('_serialize', ['recipient']);
    }


    /**
     * Edit method
     *
     * @param string|null $id Recipient id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null, $source=null)
    {
        $recipient = $this->Recipients->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $recipient = $this->Recipients->patchEntity($recipient, $this->request->data);
            if ($this->Recipients->save($recipient)) {
                $etId = $recipient->embryo_transfer_id;
                $this->Flash->success(__('The recipient has been saved.'));
                if ($source = 'mtgl'){
                    return $this->redirect(['controller'=> 'EmbryoTransfers', 'action' => 'view', $etId, '#' => 'related-recipients', 'mtgl']);
                } else {
                    return $this->redirect(['controller'=> 'EmbryoTransfers', 'action' => 'view', $etId, '#' => 'related-recipients']);
                }
            } else {
                $this->Flash->error(__('The recipient could not be saved. Please, try again.'));
            }
        }
        // $embryoTransfers = $this->Recipients->EmbryoTransfers->find('list');
        $users = $this->Recipients->Users->find('list', ['limit' => 200]);
        $this->set(compact('recipient', 'users', 'source'));
        $this->set('_serialize', ['recipient']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Recipient id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $recipient = $this->Recipients->get($id);
        if ($this->Recipients->delete($recipient)) {
            $this->Flash->success(__('The recipient has been deleted.'));
        } else {
            $this->Flash->error(__('The recipient could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
