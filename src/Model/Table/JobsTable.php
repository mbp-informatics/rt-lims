<?php
namespace App\Model\Table;

use App\Model\Entity\Job;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Jobs Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Users
 * @property \Cake\ORM\Association\BelongsTo $JobAstatuses
 * @property \Cake\ORM\Association\BelongsTo $JobBstatuses
 * @property \Cake\ORM\Association\HasMany $EmbryoCryos
 * @property \Cake\ORM\Association\HasMany $EmbryoResus
 * @property \Cake\ORM\Association\HasMany $Ivfs
 * @property \Cake\ORM\Association\HasMany $JobComments
 * @property \Cake\ORM\Association\HasMany $JobTypes
 * @property \Cake\ORM\Association\HasMany $SpermCryos
 * @property \Cake\ORM\Association\HasMany $Transfers
 * @property \Cake\ORM\Association\BelongsToMany $Contacts
 */
class JobsTable extends Table
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

        $this->table('jobs');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id'
        ]);
        $this->belongsTo('JobAstatuses', [
            'foreignKey' => 'job_astatus_id'
        ]);
        $this->belongsTo('JobBstatuses', [
            'foreignKey' => 'job_bstatus_id'
        ]);
        $this->hasMany('EmbryoCryos', [
            'foreignKey' => 'job_id'
        ]);
        $this->hasMany('Injections', [
            'foreignKey' => 'job_id'
        ]);
        $this->hasMany('EmbryoResus', [
            'foreignKey' => 'job_id'
        ]);
        $this->hasMany('Ivfs', [
            'foreignKey' => 'job_id'
        ]);
        $this->hasMany('JobComments', [
            'foreignKey' => 'job_id'
        ]);
        $this->hasMany('JobTypes', [
            'foreignKey' => 'job_id'
        ]);
        $this->hasMany('SpermCryos', [
            'foreignKey' => 'job_id'
        ]);
        $this->hasMany('EmbryoTransfers', [
            'foreignKey' => 'job_id'
        ]);
        $this->hasMany('ContactsJobs', [
            'foreignKey' => 'job_id'
        ]);
        $this->belongsToMany('Contacts', [
            'foreignKey' => 'job_id',
            'targetForeignKey' => 'contact_id',
            'joinTable' => 'contacts_jobs'
        ]);
        $this->belongsToMany('KompVialsDump', [
            'foreignKey' => 'job_id',
            'targetForeignKey' => 'komp_vial_id',
            'joinTable' => 'kompvials_jobs'
        ]);
        $this->hasMany('KompvialsJobs', [
            'foreignKey' => 'job_id'
        ]);
        $this->belongsTo('Projects', [
            'foreignKey' => 'project_id'
        ]);
        $this->belongsTo('MgiGenesDump', [
            'foreignKey' => 'mgi_accession_id'
        ]);
        $this->hasMany('GenotypeRequests', [
            'foreignKey' => 'job_id'
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
            ->notEmpty('job_status');

        $validator
            ->allowEmpty('mcrl_note');

        $validator
            ->add('sc_tt_batch_no', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('sc_tt_batch_no');

        $validator
            ->allowEmpty('membership');

        $validator
            ->allowEmpty('komp_source');

        $validator
            ->allowEmpty('mosaic_id_no');

        $validator
            ->add('request_date', 'valid', ['rule' => 'date'])
            ->allowEmpty('request_date');

        $validator
            ->add('reopened_date', 'valid', ['rule' => 'date'])
            ->allowEmpty('reopened_date');

        $validator
            ->add('closed_date', 'valid', ['rule' => 'date'])
            ->allowEmpty('closed_date');

        $validator
            ->allowEmpty('strain_note');

        $validator
            ->allowEmpty('strain_name');

        $validator
            ->allowEmpty('mmrrc_no');

        $validator
            ->add('bl_no', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('bl_no');

        $validator
            ->add('pn_cr_no', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('pn_cr_no');

        $validator
            ->allowEmpty('esc_clone_id_no');

        $validator
            ->allowEmpty('esc_line');

        $validator
            ->allowEmpty('genotype');

        $validator
            ->notEmpty('sexlinked');

        $validator
            ->allowEmpty('background');

        $validator
            ->allowEmpty('previous_name');

        $validator
            ->allowEmpty('method_note');

        $validator
            ->allowEmpty('egg_donors');

        $validator
            ->allowEmpty('housing');

        $validator
            ->add('males_no', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('males_no');

        $validator
            ->allowEmpty('males_id_dob');

        $validator
            ->add('females_no', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('females_no');

        $validator
            ->allowEmpty('females_id_dob');

        $validator
            ->allowEmpty('chimeras');

        $validator
            ->allowEmpty('chimera_fertility');

        $validator
            ->add('targeting_conf', 'valid', ['rule' => 'boolean']);
            // ->requirePresence('targeting_conf', 'create')
            // ->notEmpty('targeting_conf');

        $validator
            ->allowEmpty('where_geno');

        $validator
            ->add('billed', 'valid', ['rule' => 'boolean'])
            ->allowEmpty('billed');

        $validator
            ->add('billing_id_no', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('billing_id_no');

        $validator
            ->allowEmpty('order_no');

        $validator
            ->allowEmpty('mcrl_recharge');

        $validator
            ->allowEmpty('mvp_recharge');

        $validator
            ->allowEmpty('mgel_recharge');

        $validator
            ->allowEmpty('et_location');

        $validator
            ->add('recipient_no', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('recipient_no');

        $validator
            ->add('donor_genotyping', 'valid', ['rule' => 'boolean'])
            ->notEmpty('donor_genotyping');

        $validator
            ->add('muga_sample', 'valid', ['rule' => 'boolean'])
            ->notEmpty('muga_sample');

        $validator
            ->add('fmp_id_no', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('fmp_id_no');

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
        $rules->add($rules->existsIn(['job_astatus_id'], 'JobAstatuses'));
        $rules->add($rules->existsIn(['job_bstatus_id'], 'JobBstatuses'));
        return $rules;
    }

    public function getInvestigatorName($jobId) {
        $job = $this->get($jobId, [
            'contain' => [
                'Contacts']
            ]);
        foreach ($job->contacts as $ct) {
            if ($ct->contact_type_id = '1') { //principal investigator
                return $ct->first_name.' '.$ct->last_name;
            }
        }
        return null;
    }
}
