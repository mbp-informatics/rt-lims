<?php
namespace App\Model\Table;

use App\Model\Entity\ContactsJob;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ContactsJobs Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Jobs
 * @property \Cake\ORM\Association\BelongsTo $Contacts
 */
class ContactsJobsTable extends Table
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

        $this->table('contacts_jobs');
        $this->displayField('id');
        $this->primaryKey('id');
        $this->addBehavior('Timestamp');
        $this->belongsTo('Jobs', [
            'foreignKey' => 'job_id'
        ]);
        $this->belongsTo('Contacts', [
            'foreignKey' => 'contact_id'
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
        $rules->add($rules->existsIn(['contact_id'], 'Contacts'));
        $rules->add($rules->isUnique(['job_id', 'contact_id']));
        return $rules;
    }
}
