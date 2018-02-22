<?php
namespace App\Model\Table;

use App\Model\Entity\QualityControl;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * QualityControls Model
 *
 * @property \Cake\ORM\Association\BelongsTo $InventoryVials
 * @property \Cake\ORM\Association\BelongsTo $Users
 * @property \Cake\ORM\Association\HasMany $QualityControlSubtests
 */
class QualityControlsTable extends Table
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

        $this->table('quality_controls');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('EsCells', [
            'foreignKey' => 'es_cell_id'
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id'
        ]);
        $this->hasMany('QcCreflips', [
            'foreignKey' => 'quality_control_id'
        ]);
        $this->hasMany('QcCustomerInvivos', [
            'foreignKey' => 'quality_control_id'
        ]);
        $this->hasMany('QcGenotypes', [
            'foreignKey' => 'quality_control_id'
        ]);
        $this->hasMany('QcGermlines', [
            'foreignKey' => 'quality_control_id'
        ]);
        $this->hasMany('QcGrowths', [
            'foreignKey' => 'quality_control_id'
        ]);
        $this->hasMany('QcKaryotypes', [
            'foreignKey' => 'quality_control_id'
        ]);        
        $this->hasMany('QcMicroinjections', [
            'foreignKey' => 'quality_control_id'
        ]);
        $this->hasMany('QcPathogens', [
            'foreignKey' => 'quality_control_id'
        ]);
        $this->hasMany('QcResequencings', [
            'foreignKey' => 'quality_control_id'
        ]);
        $this->hasMany('QcTmks', [
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
            ->add('started_by', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('started_by');

        $validator
            ->add('finished_by', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('finished_by');

        $validator
            ->add('pass', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('pass');

        $validator
            ->add('assigned_qc', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('assigned_qc');

        $validator
            ->add('purpose', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('purpose');

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
        // $rules->add($rules->existsIn(['inventory_vial_id'], 'InventoryVials'));
        $rules->add($rules->existsIn(['user_id'], 'Users'));
        return $rules;
    }
}
