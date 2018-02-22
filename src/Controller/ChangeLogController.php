<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * ChangeLog Controller
 *
 * @property \App\Model\Table\ChangeLogTable $ChangeLog
 */
class ChangeLogController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index($tableAlias=null, $entityId=null)
    {

        $query = $this->ChangeLog->find('all');

        if ($entityId) {
            $query->where(['entity_id' => $entityId]);
        }
        if ($tableAlias) {
            $query->where(['table_alias' => $tableAlias]);
        }

        $query->order(['change_date' => 'DESC']);
        $this->set('changeLog', $query);
        $this->set('tableAlias', $tableAlias);
        $this->set('_serialize', ['changeLog']);
    }

    /**
     * View method
     *
     * @param string|null $id Change Log id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $changeLog = $this->ChangeLog->get($id, [
            'contain' => []
        ]);
        $this->set('changeLog', $changeLog);
        $this->set('_serialize', ['changeLog']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $changeLog = $this->ChangeLog->newEntity();
        if ($this->request->is('post')) {
            $changeLog = $this->ChangeLog->patchEntity($changeLog, $this->request->data);
            if ($this->ChangeLog->save($changeLog)) {
                $this->Flash->success(__('The change log has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The change log could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('changeLog'));
        $this->set('_serialize', ['changeLog']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Change Log id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $changeLog = $this->ChangeLog->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $changeLog = $this->ChangeLog->patchEntity($changeLog, $this->request->data);
            if ($this->ChangeLog->save($changeLog)) {
                $this->Flash->success(__('The change log has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The change log could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('changeLog'));
        $this->set('_serialize', ['changeLog']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Change Log id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $changeLog = $this->ChangeLog->get($id);
        if ($this->ChangeLog->delete($changeLog)) {
            $this->Flash->success(__('The change log has been deleted.'));
        } else {
            $this->Flash->error(__('The change log could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
