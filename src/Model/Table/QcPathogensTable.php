<?php
namespace App\Model\Table;

use App\Model\Entity\QcPathogen;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * QcPathogens Model
 *
 * @property \Cake\ORM\Association\BelongsTo $InventoryVials
 * @property \Cake\ORM\Association\BelongsTo $Users
 * @property \Cake\ORM\Association\BelongsTo $QualityControls
 */
class QcPathogensTable extends Table
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

        $this->table('qc_pathogens');
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
            ->allowEmpty('mycoplasma');

        $validator
            ->allowEmpty('parvovirus');

        $validator
            ->allowEmpty('other');

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
