<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\ORM\TableRegistry;
use Cake\Datasource\ConnectionManager;

class InjectionComponent extends Component
{
    protected $conn;
    public $imitsInjCutoffNo = 7742; //upload MI Attempts to iMits starting with injection id 7743 = CR10000
	public function __construct($id = false, $table = null, $ds = null) {
	    parent::__construct($id, $table, $ds);
        $this->conn = ConnectionManager::get('default');
    }

    /**
     * Set the 'injections.do_imits_update' flag to 1.
     * This will be periodically checked by the API-NS middleware, and if
     * the flag is set, the middleware will create/update mi_attempt in
     * iMits accordingly.
     * Tomek, 8/3/2017
     * @return true || false
     */
    public function setImitsUpdateFlag($injection_id) {
        $injectionsTable = TableRegistry::get('Injections');
        $inj = $injectionsTable->get($injection_id);
            $inj = $injectionsTable->patchEntity($inj,
                ['do_imits_update' => 1]
            );
            if (!$injectionsTable->save($inj)) {
                return false; //something went wrong when saving
            }
            return true; // all OK, the flag has been set
    }

    /**
     * Set the 'injections.do_imits_update' flag to null.
     * @return true || false
     */
    public function clearImitsUpdateFlag($injection_id) {
        $injectionsTable = TableRegistry::get('Injections');
        $inj = $injectionsTable->get($injection_id);
            $inj = $injectionsTable->patchEntity($inj,
                ['do_imits_update' => null]
            );
            if (!$injectionsTable->save($inj)) {
                return false; //something went wrong when saving
            }
            return true; // all OK, the flag has been set
    }

    /**
     * Check conditions to see if injection should be pushed to iMits.
     * Tomek, 9/8/2017
     * @return null || true
     */
    public function isImitsUpdateNeeded($injection_id) {
        $injectionsTable = TableRegistry::get('Injections');
        $injection = $injectionsTable->get($injection_id, [
            'contain' => ['Users', 'Projects'=>['ProjectTypes', 'Mutations', 'Phenotypes', 'MgiGenesDump'], 'EmbryoTransfers']
        ]);

        /** 
         * Always update injections that have already been pushed to iMits.
        *  This allows to delete the data from iMits 
        */
        if (isset($injection->imits_mi_attempt_id)) {
            return true;
        }

        if (!isset($injection->projects[0])) {
            return null; //nope sir, conditions not met
         }
        if (
            ($injection_id > $this->imitsInjCutoffNo) && 
            isset($injection->embryo_transfers[0]) && 
            !defined('APIREQUEST') &&
            strtoupper($injection->recharge) == 'KL77' &&
            $injection->projects[0]->project_type->type == 'KOMP2' &&
            strtoupper($injection->injection_type) == 'CR'
        ) {
            return true; //yes sir, iMits push is needed
        }
        return null; //nope sir, conditions not met
    }
}