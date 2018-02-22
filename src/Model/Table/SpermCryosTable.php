<?php
namespace App\Model\Table;

use App\Model\Entity\SpermCryo;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * SpermCryos Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Users
 * @property \Cake\ORM\Association\BelongsTo $Jobs
 */
class SpermCryosTable extends Table
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

        $this->table('sperm_cryos');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id'
        ]);
        $this->belongsTo('Jobs', [
            'foreignKey' => 'job_id'
        ]);
        $this->hasMany('InventoryVials', [
        'foreignKey' => 'sperm_cryo_id'
        ]);
        $this->hasMany('Ivfs', [
            'foreignKey' => 'sperm_cryo_id'
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
            ->add('cryo_date', 'valid', ['rule' => 'date'])
            ->allowEmpty('cryo_date');

        $validator
            ->allowEmpty('pi_first_name');

        $validator
            ->allowEmpty('pi_last_name');

        $validator
            ->allowEmpty('donor_genotype');

        $validator
            ->allowEmpty('donor_id_no');

        $validator
            ->add('donor_dob', 'valid', ['rule' => 'date'])
            ->allowEmpty('donor_dob');

        $validator
            ->allowEmpty('donor_age');

        $validator
            ->allowEmpty('cryo_sample_type');

        $validator
            ->allowEmpty('cryo_method');

        $validator
            ->allowEmpty('cryo_caps_label_color');

        $validator
            ->allowEmpty('cryo_medium');

        $validator
            ->allowEmpty('cryo_cpm_lot_no');

        $validator
            ->add('cryo_mosm', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('cryo_mosm');

        $validator
            ->add('cryo_sperm_conc', 'valid', ['rule' => 'decimal'])
            ->allowEmpty('cryo_sperm_conc');

        $validator
            ->add('cryo_total_motility', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('cryo_total_motility');

        $validator
            ->add('cryo_rapid_motility', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('cryo_rapid_motility');

        $validator
            ->add('cryo_prog_motility', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('cryo_prog_motility');

        $validator
            ->allowEmpty('cryo_sperm_analyser');

        $validator
            ->add('cryo_abnormal_heads', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('cryo_abnormal_heads');

        $validator
            ->add('cryo_abnormal_tails', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('cryo_abnormal_tails');

        $validator
            ->allowEmpty('cryo_scored_by');

        $validator
            ->allowEmpty('cryo_collected_by');

        $validator
            ->allowEmpty('cryo_sc_performed_by');

        $validator
            ->allowEmpty('cryo_comments');

        $validator
            ->allowEmpty('donor_comments');

        $validator
            ->allowEmpty('donor_genotype_confirmed');

        $validator
            ->allowEmpty('sperm_taqman');

        $validator
            ->allowEmpty('taqman_date');

        $validator
            ->allowEmpty('taqman_by');

        $validator
            ->allowEmpty('geno_date');

        $validator
            ->allowEmpty('geno_by');

        $validator
            ->allowEmpty('targeted_status');

        $validator
            ->allowEmpty('targeted_confirmed_date');

        $validator
            ->allowEmpty('targeting_confirmed_by');

        $validator
            ->add('post_sperm_conc', 'valid', ['rule' => 'decimal'])
            ->allowEmpty('post_sperm_conc');

        $validator
            ->add('post_total_motility', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('post_total_motility');

        $validator
            ->add('post_rapid_motility', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('post_rapid_motility');

        $validator
            ->add('post_prog_motility', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('post_prog_motility');

        $validator
            ->add('fmp_id_no', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('fmp_id_no');

        $validator
            ->add('fmp_job_id_no', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('fmp_job_id_no');

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
        $rules->add($rules->existsIn(['job_id'], 'Jobs'));
        return $rules;
    }
}
