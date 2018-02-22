<?php
namespace App\Model\Table;

use App\Model\Entity\QcCustomerInvivo;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * QcCustomerInvivos Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Users
 * @property \Cake\ORM\Association\BelongsTo $QualityControls
 */
class QcCustomerInvivosTable extends Table
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

        $this->table('qc_customer_invivos');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('KompClonesDump', [
            'foreignKey' => 'komp_clones_dump_id'
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
            ->allowEmpty('starting_product');

        $validator
            ->allowEmpty('injection_outcome');

        $validator
            ->allowEmpty('germline_outcome');

        $validator
            ->allowEmpty('notes');

        $validator
            ->add('injection_date', 'valid', ['rule' => 'date'])
            ->allowEmpty('injection_date');

        $validator
            ->add('germline_date', 'valid', ['rule' => 'date'])
            ->allowEmpty('germline_date');

        $validator
            ->add('added_by', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('added_by');

        $validator
            ->add('updated_by', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('updated_by');

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
        $rules->add($rules->existsIn(['komp_clones_dump_id'], 'KompClonesDump'));
        $rules->add($rules->existsIn(['user_id'], 'Users'));
        $rules->add($rules->existsIn(['quality_control_id'], 'QualityControls'));
        return $rules;
    }
}
