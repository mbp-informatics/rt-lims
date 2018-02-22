<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * KompvialsJobs Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Jobs
 * @property \Cake\ORM\Association\BelongsTo $KompVials
 * @property \Cake\ORM\Association\BelongsTo $Users
 *
 * @method \App\Model\Entity\KompvialsJob get($primaryKey, $options = [])
 * @method \App\Model\Entity\KompvialsJob newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\KompvialsJob[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\KompvialsJob|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\KompvialsJob patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\KompvialsJob[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\KompvialsJob findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class KompvialsJobsTable extends Table
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

        $this->table('kompvials_jobs');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id'
        ]);

        $this->belongsTo('Jobs', [
            'foreignKey' => 'job_id'
        ]);
        $this->belongsTo('KompVialsDump', [
            'foreignKey' => 'komp_vial_id'
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
            ->integer('id')
            ->allowEmpty('id', 'create');

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
        $rules->add($rules->existsIn(['user_id'], 'Users'));

        return $rules;
    }
}
