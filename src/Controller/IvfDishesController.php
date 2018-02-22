<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * IvfDishes Controller
 *
 * @property \App\Model\Table\IvfDishesTable $IvfDishes
 */
class IvfDishesController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        if ($this->request->is('json')) {

            $contain = ['Ivfs'];
            if (isset($this->request->query['search']['value']) && strstr($this->request->query['search']['value'], 'advs|') ) {
                $resp = $this->Search->getDataTablesResultSetForAdvancedSearch($this->request, 'IvfDishes', $contain);
            } else {
                @$resp = $this->Search->getDataTablesResultSet($this->request, 'IvfDishes', $contain);
            }

            foreach ($resp['data'] as $k=>$ivfDish) {
                if ($ivfDish->ivf) {
                    $resp['data'][$k]['ivf_id'] = "<a href='/ivfs/view/{$ivfDish->ivf->id}'>{$ivfDish->ivf->id}</a>";
                } else {
                    $resp['data'][$k]['ivf_id'] = '-';
                }
            }
            $this->set('resp', $resp);
            $this->set('_serialize', 'resp');
        }
    }

    /**
     * View method
     *
     * @param string|null $id Ivf Dish id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $ivfDish = $this->IvfDishes->get($id, [
            'contain' => ['Ivfs']
        ]);
        $this->set('ivfDish', $ivfDish);
        $this->set('_serialize', ['ivfDish']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add($ivf_id=null)
    {
        $ivfDish = $this->IvfDishes->newEntity();
        if ($this->request->is('post')) {
            $ivfDish = $this->IvfDishes->patchEntity($ivfDish, $this->request->data);
            if ($this->IvfDishes->save($ivfDish)) {
                $this->Flash->success(__('The ivf dish has been saved.'));
                return $this->redirect(['action' => 'view', 'controller' => 'ivfs', $ivf_id, '#' => 'ivf-dishes']);
            } else {
                $this->Flash->error(__('The ivf dish could not be saved. Please, try again.'));
            }
        }
        $ivfs = $this->IvfDishes->Ivfs->find('list');
        $this->set(compact('ivfDish', 'ivfs', 'ivf_id'));
        $this->set('_serialize', ['ivfDish']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Ivf Dish id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $ivfDish = $this->IvfDishes->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $ivfDish = $this->IvfDishes->patchEntity($ivfDish, $this->request->data);
            if ($this->IvfDishes->save($ivfDish)) {
                $this->Flash->success(__('The ivf dish has been saved.'));
				return $this->redirect(['action' => 'view', 'controller' => 'ivfs', $ivfDish->ivf_id, '#' => 'ivf-dishes']);
            } else {
                $this->Flash->error(__('The ivf dish could not be saved. Please, try again.'));
            }
        }
        $ivfs = $this->IvfDishes->Ivfs->find('list');
        $this->set(compact('ivfDish', 'ivfs'));
        $this->set('_serialize', ['ivfDish']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Ivf Dish id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $ivfDish = $this->IvfDishes->get($id);
        if ($this->IvfDishes->delete($ivfDish)) {
            $this->Flash->success(__('The ivf dish has been deleted.'));
        } else {
            $this->Flash->error(__('The ivf dish could not be deleted. Please, try again.'));
        }
		return $this->redirect(['action' => 'view', 'controller' => 'ivfs', $ivfDish->ivf_id, '#' => 'ivf-dishes']);
    }
}
