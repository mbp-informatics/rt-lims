<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Errors Controller
 *
 * @property \App\Model\Table\ErrorsTable $Errors
 */
class ErrorsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $errors = $this->Errors->find('all')->contain('Users');

        $this->set(compact('errors'));
        $this->set('_serialize', ['errors']);
    }

    /**
     * View method
     *
     * @param string|null $id Error id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $error = $this->Errors->get($id, [
            'contain' => ['Users']
        ]);

        $this->set('error', $error);
        $this->set('_serialize', ['error']);
    }

}
