<?php
namespace App\Model\Table;

use App\Model\Entity\JobType;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * JobTypes Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Jobs
 * @property \Cake\ORM\Association\BelongsTo $JobTypeNames
 * @property \Cake\ORM\Association\BelongsTo $Users
 */
class JobTypesTable extends Table
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

        $this->table('job_types');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Jobs', [
            'foreignKey' => 'job_id'
        ]);
        $this->belongsTo('JobTypeNames', [
            'foreignKey' => 'job_type_name_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id'
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
            ->add('scheduled_date1', 'valid', ['rule' => 'date'])
            ->allowEmpty('scheduled_date1');
        
        $validator
            ->add('scheduled_date2', 'valid', ['rule' => 'date'])
            ->allowEmpty('scheduled_date2');

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
        $rules->add($rules->existsIn(['job_id'], 'Jobs'));
        $rules->add($rules->existsIn(['job_type_name_id'], 'JobTypeNames'));
        $rules->add($rules->existsIn(['user_id'], 'Users'));
        return $rules;
    }
}
