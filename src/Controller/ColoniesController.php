<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Colonies Controller
 *
 * @property \App\Model\Table\ColoniesTable $Colonies
 */
class ColoniesController extends AppController
{
     public $paginate = [
        'maxLimit' => 1000000, //a million should be enough, huh?
        'order' => [
            'Colonies.id' => 'asc'
        ]
    ];

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $colonies = $this->Colonies->find('all')->contain(['MgiGenesDump', 'Projects.ProjectTypes', 'Projects.ProjectStatuses', 'Projects.Mutations', 'Projects.Phenotypes', 'Projects.Injections']);
        $this->set('colonies', $this->paginate($colonies));
        $this->set('_serialize', ['colonies']);
    }

    /**
     * View method
     *
     * @param string|null $id Colony id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $colony = $this->Colonies->get($id);
        $this->set('colony', $colony);
        $this->set('_serialize', ['colony']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $colony = $this->Colonies->newEntity();
        if ($this->request->is('post')) {
            $colony = $this->Colonies->patchEntity($colony, $this->request->data);
            if ($this->Colonies->save($colony)) {
                $this->Flash->success(__('The colony has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The colony could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('colony'));
        $this->set('_serialize', ['colony']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Colony id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $colony = $this->Colonies->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $colony = $this->Colonies->patchEntity($colony, $this->request->data);
            if ($this->Colonies->save($colony)) {
                $this->Flash->success(__('The colony has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The colony could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('colony'));
        $this->set('_serialize', ['colony']);
    }

    /**
     * Match multiple colonies to genes
     *
     * @param int|null $injectionId :Injection id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function matchCrmColonies($injectionId)
    {
        $colonies = $this->Colonies->find('all')->where(['injection_id =' => $injectionId])->contain(['MgiGenesDump', 'Projects.MgiGenesDump']);
        if ($this->request->is(['patch', 'post', 'put'])) {
            //Update multiple colonies
            foreach ($this->request->data['colony_id'] as $id => $row) {
                $colony = $this->Colonies->get($id);
                $colony = $this->Colonies->patchEntity($colony, $row);
                if ($res = $this->Colonies->save($colony)) {
                    $this->Flash->success(__("The colony {$res->id} info has been saved."));
                } else {
                    $this->Flash->error(__("The colony {$res->id} info could not be saved. Please, try again."));
                }
            }
        return $this->redirect(['controller' => 'injections', 'action' => 'view', $injectionId]);    
        }
        //Dropdown for the genes
        $genes = [];
        foreach ($colonies->toArray() as $c) {
            if (!isset($c->project->mgi_genes_dump)) {
                continue;
            }            
            foreach ($c->project->mgi_genes_dump as $g) {
                $genes[$g->mgi_accession_id] = $g->marker_symbol;
            }    
        }
        $this->set(compact('colonies', 'genes', 'injectionId'));
        $this->set('_serialize', ['colony']);
    }


    /**
     * Delete method
     *
     * @param string|null $id Colony id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $colony = $this->Colonies->get($id);
        if ($this->Colonies->delete($colony)) {
            $this->Flash->success(__('The colony has been deleted.'));
        } else {
            $this->Flash->error(__('The colony could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
