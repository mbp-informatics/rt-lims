<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * CrisprAttributes Controller
 *
 * @property \App\Model\Table\CrisprAttributesTable $CrisprAttributes
 */
class CrisprAttributesController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['CrisprDesigns']
        ];
        $this->set('crisprAttributes', $this->paginate($this->CrisprAttributes));
        $this->set('_serialize', ['crisprAttributes']);
    }

    /**
     * View method
     *
     * @param string|null $id Crispr Attribute id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $crisprAttribute = $this->CrisprAttributes->get($id, [
            'contain' => ['CrisprDesigns']
        ]);
        $this->set('crisprAttribute', $crisprAttribute);
        $this->set('_serialize', ['crisprAttribute']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add($CrisprDesignId = null, $attrData = null)
    {
        $crisprAttribute = $this->CrisprAttributes->newEntity();
        $this->set('currentCrisprDesignId', [$CrisprDesignId]);
        if ($this->request->is('post') || $attrData) {
            if ($attrData) {
                $data = $attrData;
            } else {
                $data = $this->request->data;
            } 
            $crisprAttribute = $this->CrisprAttributes->patchEntity($crisprAttribute, $data);
            if ($this->CrisprAttributes->save($crisprAttribute)) {
                if (isset($data['batch_upload_uid'])) { //hide flash messages when bulk upload
                return $this->redirect(['controller' => 'CrisprDesigns','action' => 'view', $CrisprDesignId]);
                }
                $this->Flash->success(__('The crispr attribute has been saved.'));
                return $this->redirect(['controller' => 'CrisprDesigns','action' => 'view', $CrisprDesignId]);
            } else {
                $this->Flash->error(__('The crispr attribute could not be saved. Please, try again.'));
            }
        }
        $crisprDesigns = $this->CrisprAttributes->CrisprDesigns->find('list', ['limit' => 200]);
        $this->set(compact('crisprAttribute', 'crisprDesigns'));
        $this->set('_serialize', ['crisprAttribute']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Crispr Attribute id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $crisprAttribute = $this->CrisprAttributes->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $crisprAttribute = $this->CrisprAttributes->patchEntity($crisprAttribute, $this->request->data);
            if ($this->CrisprAttributes->save($crisprAttribute)) {
                $this->Flash->success(__('The crispr attribute has been saved.'));
                return $this->redirect(['controller' => 'crisprDesigns' ,'action' => 'view', $crisprAttribute['crispr_design_id']]);
            } else {
                $this->Flash->error(__('The crispr attribute could not be saved. Please, try again.'));
            }
        }
        $crisprDesigns = $this->CrisprAttributes->CrisprDesigns->find('list', ['limit' => 200]);
        $this->set(compact('crisprAttribute', 'crisprDesigns'));
        $this->set('_serialize', ['crisprAttribute']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Crispr Attribute id.
     * @return void Redirects to Crispr Design view.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $crisprAttribute = $this->CrisprAttributes->get($id);
        if ($this->CrisprAttributes->delete($crisprAttribute)) {
            $this->Flash->success(__('The Crispr attribute has been deleted.'));
        } else {
            $this->Flash->error(__('The Crispr attribute could not be deleted. Please, try again.'));
        }
        return $this->redirect(['controller' => 'CrisprDesigns' ,'action' => 'view', $crisprAttribute['crispr_design_id']]);
    }
}
