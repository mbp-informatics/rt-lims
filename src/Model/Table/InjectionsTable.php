<?php
namespace App\Model\Table;

use App\Model\Entity\Injection;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

use Cake\Event\Event;
use ArrayObject;
use Cake\Datasource\EntityInterface;
use Cake\ORM\TableRegistry;

/**
 * Injections Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Users
 * @property \Cake\ORM\Association\BelongsTo $Colonies
 * @property \Cake\ORM\Association\BelongsTo $Projects
 * @property \Cake\ORM\Association\BelongsTo $MiPlans
 * @property \Cake\ORM\Association\BelongsTo $MiAttempts
 * @property \Cake\ORM\Association\BelongsTo $Clones
 * @property \Cake\ORM\Association\BelongsTo $ColonyQcs
 * @property \Cake\ORM\Association\HasMany $Transfers
 */
class InjectionsTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('injections');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id'
        ]);

        $this->belongsTo('Jobs', [
            'foreignKey' => 'job_id'
        ]);

        $this->hasMany('EmbryoTransfers', [
            'foreignKey' => 'injection_id'
        ]);
         $this->belongsTo('InventoryVials', [
            'foreignKey' => 'inventory_vial_id'
        ]);

        $this->belongsToMany('Projects', [
            'joinTable' => 'projects_injections',
            'through' => 'ProjectsInjections',
            'foreignKey' => 'injection_id',
            'targetForeignKey' => 'project_id',
        ]);
        $this->hasMany('Colonies', [
            'foreignKey' => 'injection_id'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->add('id', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('id', 'create');

        $validator
            ->allowEmpty('qc_state');

        $validator
            ->allowEmpty('recharge');

        $validator
            ->add('injection_date', 'valid', ['rule' => 'date'])
            ->requirePresence('injection_date', 'create')
            ->notEmpty('injection_date');

        $validator
            ->allowEmpty('membership');

        $validator
            ->allowEmpty('donor_strain');

        $validator
            ->add('donor_date_of_birth', 'valid', ['rule' => 'date'])
            ->allowEmpty('donor_date_of_birth');

        $validator
            // ->add('stud_ids', 'validFormat', ['rule' => array('custom', '/^[0-9, ]+$/'), 'message'=>'Please only list the IDs' ])
            ->allowEmpty('stud_ids');

        $validator
            ->add('pmsg_time', 'valid', ['rule' => 'time'])
            ->allowEmpty('pmsg_time');

        $validator
            ->add('hcg_time', 'valid', ['rule' => 'time'])
            ->allowEmpty('hcg_time');

        $validator
            ->add('number_mated', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('number_mated');

        $validator
            ->add('number_plugged', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('number_plugged');

        $validator
            ->add('total_eggs_collected', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('total_eggs_collected');

        $validator
            ->allowEmpty('fresh_or_frozen');

        $validator
            ->allowEmpty('injection_method');

        $validator
            ->add('number_injected', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('number_injected');

        $validator
            ->add('number_survived', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('number_survived');

        $validator
            ->add('number_transferred', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('number_transferred');

        $validator
            ->allowEmpty('comments');

        $validator
            ->allowEmpty('investigator');

        $validator
            ->allowEmpty('es_cell_source');

        $validator
            ->allowEmpty('parental_esc_line');

        $validator
            ->allowEmpty('coat_color');

        $validator
            ->allowEmpty('es_cell_clone');

        $validator
            ->allowEmpty('esc_morphology');

        $validator
            ->allowEmpty('embryos_collected_by');

        $validator
            ->allowEmpty('injection_type');

        $validator
            ->allowEmpty('et_by');

        $validator
            ->add('total_embryos', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('total_embryos');

        $validator
            ->add('total_zygotes', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('total_zygotes');

        $validator
            ->allowEmpty('pts_ko_mo');

        $validator
            ->allowEmpty('injected_by');

        $validator
            ->add('number_two_cell', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('number_two_cell');

        $validator
            ->add('number_zygotes_injected', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('number_zygotes_injected');

        $validator
            ->requirePresence('project_id', 'create')
            ->notEmpty('project_id');

        $validator
            ->add('bl_eight_cell', 'valid', ['rule' => 'boolean'])
            ->allowEmpty('bl_eight_cell');

        $validator
            ->add('cr_electroporation', 'valid', ['rule' => 'boolean'])
            ->allowEmpty('cr_electroporation');

        $validator
            ->add('fmp_id_no', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('fmp_id_no');
        
        $validator
            ->allowEmpty('do_imits_update');

        $validator
            ->add('imits_mi_attempt_id', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('imits_mi_attempt_id');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['user_id'], 'Users'));
        return $rules;
    }

    //Returns total transfered recipients of associated with a given injection
    private function getNumberTransfered($injectionId)
    {
        $injection = $this->get($injectionId, [
            'contain' => ['EmbryoTransfers.Recipients']
        ]);
        $totalTransferred = 0;
        foreach ($injection['embryo_transfers'] as $et) {
            foreach ($et['recipients'] as $rep) {
                $totalTransferred += $rep['total_tx'];
            }

        }
        return $totalTransferred;
    }

    //Updates number_transfered field
    public function updateNumberTransfered($injectionId)
    {
        $injection = $this->get($injectionId, ['contain' => ['EmbryoTransfers.Recipients']]);
        $numberTransferred = $this->getNumberTransfered($injectionId);
        if (empty($numberTransferred)) { $numberTransferred = null; } 
        $injection = $this->patchEntity($injection, ['number_transferred' => $numberTransferred]);
        $injResult = $this->save($injection);
        return $injResult;
    }

    //update 'injections.number_transfered' field whenever entry is added/updated
    public function afterSave(Event $event, EntityInterface $entity, ArrayObject $options)
    {
        if (isset($entity['id'])) {
            $injections = TableRegistry::get('Injections');
            $injections->updateNumberTransfered($entity['id']);    
        }
    }

}
