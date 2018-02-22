<?php
namespace App\Model\Table;

use App\Model\Entity\QcMicroinjection;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * QcMicroinjections Model
 *
 * @property \Cake\ORM\Association\BelongsTo $InventoryVials
 * @property \Cake\ORM\Association\BelongsTo $Users
 * @property \Cake\ORM\Association\BelongsTo $QualityControls
 */
class QcMicroinjectionsTable extends Table
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

        $this->table('qc_microinjections');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('InventoryVials', [
            'foreignKey' => 'inventory_vial_id'
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id'
        ]);
        $this->belongsTo('QualityControls', [
            'foreignKey' => 'quality_control_id'
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
            ->add('started', 'valid', ['rule' => 'date'])
            ->allowEmpty('started');

        $validator
            ->add('finished', 'valid', ['rule' => 'date'])
            ->allowEmpty('finished');

        $validator
            ->allowEmpty('started_by');

        $validator
            ->allowEmpty('finished_by');

        $validator
            ->allowEmpty('pass');

        $validator
            ->allowEmpty('comment');

        $validator
            ->add('birthdate', 'valid', ['rule' => 'date'])
            ->allowEmpty('birthdate');

        $validator
            ->add('npups', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('npups');

        $validator
            ->add('nmale', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('nmale');

        $validator
            ->add('chimerism', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('chimerism');

        $validator
            ->add('max_chimerism', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('max_chimerism');

        $validator
            ->add('number_injected', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('number_injected');

        $validator
            ->allowEmpty('bl');

        $validator
            ->add('parent_strain', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('parent_strain');

        $validator
            ->add('number_pups_born', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('number_pups_born');

        $validator
            ->add('injection_type', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('injection_type');

        $validator
            ->add('number_recipients', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('number_recipients');

        $validator
            ->add('number_litters', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('number_litters');

        $validator
            ->add('kompvialid', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('kompvialid');

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
        $rules->add($rules->existsIn(['inventory_vial_id'], 'InventoryVials'));
        $rules->add($rules->existsIn(['user_id'], 'Users'));
        $rules->add($rules->existsIn(['quality_control_id'], 'QualityControls'));
        return $rules;
    }
}
