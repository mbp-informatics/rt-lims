<?php
namespace App\Model\Table;

use App\Model\Entity\QcGenotype;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * QcGenotypes Model
 *
 * @property \Cake\ORM\Association\BelongsTo $InventoryVials
 * @property \Cake\ORM\Association\BelongsTo $Users
 * @property \Cake\ORM\Association\BelongsTo $QualityControls
 */
class QcGenotypesTable extends Table
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

        $this->table('qc_genotypes');
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
            ->allowEmpty('test5');

        $validator
            ->allowEmpty('test3');

        $validator
            ->allowEmpty('testcopy1');

        $validator
            ->allowEmpty('testcopy1value');

        $validator
            ->allowEmpty('testLRPCR5');

        $validator
            ->allowEmpty('test_integrity5');

        $validator
            ->add('date5', 'valid', ['rule' => 'date'])
            ->allowEmpty('date5');

        $validator
            ->add('date3', 'valid', ['rule' => 'date'])
            ->allowEmpty('date3');

        $validator
            ->add('date_copy', 'valid', ['rule' => 'date'])
            ->allowEmpty('date_copy');

        $validator
            ->add('dateLRPCR5', 'valid', ['rule' => 'date'])
            ->allowEmpty('dateLRPCR5');

        $validator
            ->add('date_integrity5', 'valid', ['rule' => 'date'])
            ->allowEmpty('date_integrity5');

        $validator
            ->allowEmpty('test_genome');

        $validator
            ->add('date_genome', 'valid', ['rule' => 'date'])
            ->allowEmpty('date_genome');

        $validator
            ->allowEmpty('lost_y');

        $validator
            ->add('date_y', 'valid', ['rule' => 'date'])
            ->allowEmpty('date_y');

        $validator
            ->allowEmpty('positive_control');

        $validator
            ->allowEmpty('test_identity');

        $validator
            ->allowEmpty('last_changed');

        $validator
            ->allowEmpty('testLRPCR3');

        $validator
            ->add('dateLRPCR3', 'valid', ['rule' => 'date'])
            ->allowEmpty('dateLRPCR3');

        $validator
            ->allowEmpty('test_loxp');

        $validator
            ->add('date_loxp', 'valid', ['rule' => 'date'])
            ->allowEmpty('date_loxp');

        $validator
            ->allowEmpty('loxp_result');

        $validator
            ->add('date_loxp_result', 'valid', ['rule' => 'date'])
            ->allowEmpty('date_loxp_result');

        $validator
            ->allowEmpty('prime3_loxp_result');

        $validator
            ->add('date_3prime_loxp_result', 'valid', ['rule' => 'date'])
            ->allowEmpty('date_3prime_loxp_result');

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
