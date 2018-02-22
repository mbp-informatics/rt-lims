<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ImitsDumpMiAttempts Model
 *
 * @property \Cake\ORM\Association\BelongsTo $ImitsMiAttempts
 * @property \Cake\ORM\Association\BelongsTo $ImitsMiPlans
 * @property \Cake\ORM\Association\BelongsTo $Users
 *
 * @method \App\Model\Entity\ImitsDumpMiAttempt get($primaryKey, $options = [])
 * @method \App\Model\Entity\ImitsDumpMiAttempt newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ImitsDumpMiAttempt[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ImitsDumpMiAttempt|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ImitsDumpMiAttempt patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ImitsDumpMiAttempt[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ImitsDumpMiAttempt findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ImitsDumpMiAttemptsTable extends Table
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

        $this->table('imits_dump_mi_attempts');
        $this->displayField('id');
        $this->primaryKey('imits_mi_attempt_id');

        $this->addBehavior('Timestamp');

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
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->requirePresence('mi_attempt_json', 'create')
            ->notEmpty('mi_attempt_json');

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
