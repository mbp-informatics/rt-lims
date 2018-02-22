<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\Network\Exception\ForbiddenException;
use Cake\ORM\TableRegistry;
use Cake\Core\Configure;
use Cake\Datasource\ConnectionManager;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link http://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{
   //see https://github.com/elboletaire/twbs-cake-plugin
    public $helpers = [
        'Less.Less', // required for parsing less files
        'BootstrapUI.Form',
        'BootstrapUI.Html',
        'BootstrapUI.Flash',
        'BootstrapUI.Paginator'
    ];

    //Global pagination settings
    public $paginate = [
        'limit' => 10,
        'order' => [
            'id' => 'desc'
        ]
    ];

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('Security');`
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');
        $this->loadComponent('Helper');
        $this->loadComponent('AppErrors');
        $this->loadComponent('Search');

        /**
         * Set auth object to the API user if it's an API request.
         * Tomek 2/22/2017
         */
        if (isset($_SERVER['HTTP_X_API_KEY']) && $_SERVER['HTTP_X_API_KEY'] == Configure::read('x-api-key')) {
            $apiUserData['id'] = Configure::read('id');
            $apiUserData['role']['name'] = Configure::read('name');
            $apiUserData['username'] = Configure::read('username');
            $apiUserData['email'] = Configure::read('email');
            define('APIREQUEST', True);
            $this->loadComponent('Auth');
            $this->Auth->setUser($apiUserData);
            return;
        }
        
        //otherwise load Auth component normally
        $auth = $this->loadComponent('Auth', [
            'authenticate' => [
                'CasAuth.Cas' => [
                    'hostname' => 'cas.ucdavis.edu',
                    'uri' => '/cas',
                    'port' => 443,
                    'cert_path' => '/usr/share/ca-certificates/mozilla/AddTrust_External_Root.crt'
                ]
            ]
        ]);
    }

    public function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        //Authenticate via CAS only if it's not API request
        if (!defined('APIREQUEST')) {
            //if user role isn't set it means we're only authenticated via CAS, need to update with local 
            if(is_null($this->Auth->user("role"))){
                //search local users CAS/kerberos username should match, should be no duplicates
                $cas_username = $this->Auth->user("username");
                $this->loadModel('Users');
                $query = $this->Users->findByUsername($cas_username);
                $query->contain(['Roles']);
                if($query->count() === 1){
                    //if found, overwrite CAS user with the local user record for querying role-based access & authorization later on
                    $result = $query->first();
                    $this->Auth->setUser($result->toArray());
                } 
            }
            //Check if CAS username is in users table in cake and logout if not
            $cas_username = isset($_SESSION['phpCAS']['user']) ? $_SESSION['phpCAS']['user'] : false;
            $this->loadModel('Users');
            $query = $this->Users->findByUsername($cas_username);
            if ($query->count() !== 1) {
                $this->Auth->logout();
            }
        } //end if APIREQUEST
    }

    public function isAdmin(){
        return $this->Auth->user("role")["name"] === "admin";
    }
    
    /**
     * Before render callback.
     *
     * @param \Cake\Event\Event $event The beforeRender event.
     * @return void
     */
    public function beforeRender(Event $event)
    {
        if (!array_key_exists('_serialize', $this->viewVars) &&
            in_array($this->response->type(), ['application/json', 'application/xml'])
        ) {
            $this->set('_serialize', true);
        }

        /* Serve print view if the url contains '?print' parameter */
        if (isset($this->request->query['print'])) {
            $this->viewBuilder()->layout('default-minimal');
        }
        
        /** Check if the last function parameter is 'downmark',
         *  if so, serve downmark view i.e. get rid of the layout (skip header, footer, navbar)
         */
        if ( end($this->request->params['pass']) == 'downmark' )  {
            $this->viewBuilder()->layout('');
        }

        /** Set userData variable to be available in all views and layouts */
        $this->set('userData', $this->Auth->user());

        /** Set debug variable to be available in all views and layouts */
        $this->set('debug', Configure::read('debug'));        
        
        /** Make sure that only users with is_active=1 flag can log in
         * but do this only for non-api user.
         */
        if (!defined('APIREQUEST')) {
            if (!isset($this->Auth->user()['is_active'])) {
                return $this->redirect($_SERVER['REQUEST_URI']);
            }
            if ($this->Auth->user()) {
                if (@$this->Auth->user()['is_active'] != 1) {
                    die("You don't have permission to access this site.");
                }
            }
        } //end if !defined
    }
}
