<?php
namespace App\Model\Table;

use App\Model\Entity\QcCreflip;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * QcCreflips Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Vials
 * @property \Cake\ORM\Association\BelongsTo $Users
 */
class QcCreflipsTable extends Table
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

        $this->table('qc_creflips');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

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
            ->add('started_by', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('started_by');

        $validator
            ->add('finished_by', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('finished_by');

        $validator
            ->add('pass', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('pass');

        $validator
            ->allowEmpty('comment');

        $validator
            ->add('pcr1', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('pcr1');

        $validator
            ->add('southern1', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('southern1');

        $validator
            ->add('northern1', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('northern1');

        $validator
            ->add('electroporation1', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('electroporation1');

        $validator
            ->add('pcr2', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('pcr2');

        $validator
            ->add('southern2', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('southern2');

        $validator
            ->add('northern2', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('northern2');

        $validator
            ->add('electroporation2', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('electroporation2');

        $validator
            ->add('pcr3', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('pcr3');

        $validator
            ->add('southern3', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('southern3');

        $validator
            ->add('northern3', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('northern3');

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
}
