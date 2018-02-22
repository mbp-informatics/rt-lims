<?php
namespace App\Model\Table;

use App\Model\Entity\Ivf;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Ivfs Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Jobs
 * @property \Cake\ORM\Association\BelongsTo $SpermCryos
 * @property \Cake\ORM\Association\HasMany $EmbryoCryos
 * @property \Cake\ORM\Association\HasMany $Transfers
 */
class IvfsTable extends Table
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

        $this->table('ivfs');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Jobs', [
            'foreignKey' => 'job_id'
        ]);
        $this->belongsTo('SpermCryos', [
            'foreignKey' => 'sperm_cryo_id'
        ]);
        $this->hasMany('EmbryoCryos', [
            'foreignKey' => 'ivf_id'
        ]);
        $this->hasMany('IvfDishes', [
            'foreignKey' => 'ivf_id'
        ]);
        $this->hasMany('EmbryoTransfers', [
            'foreignKey' => 'ivf_id'
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
            ->add('ivf_date', 'valid', ['rule' => 'date'])
            ->allowEmpty('ivf_date');

        $validator
            ->allowEmpty('background');

        $validator
            ->allowEmpty('purpose');

        $validator
            ->allowEmpty('membership');

        $validator
            ->allowEmpty('sperm_info_donor_strain');

        $validator
            ->allowEmpty('fresh_frozen');

        $validator
            ->allowEmpty('sample_type');

        $validator
            ->allowEmpty('straw_vial_no');

        $validator
            ->add('cpa_lot_no', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('cpa_lot_no');

        $validator
            ->allowEmpty('centrifuge_force');

        $validator
            ->add('centrifuge_time', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('centrifuge_time');

        $validator
            ->add('collect_thaw_time', 'valid', ['rule' => 'time'])
            ->allowEmpty('collect_thaw_time');

        $validator
            ->add('time_in_mbcd', 'valid', ['rule' => 'time'])
            ->allowEmpty('time_in_mbcd');

        $validator
            ->allowEmpty('stud_id_no');

        $validator
            ->add('stud_dob', 'valid', ['rule' => 'date'])
            ->allowEmpty('stud_dob');

        $validator
            ->allowEmpty('abnormal_heads');

        $validator
            ->allowEmpty('abnormal_tails');

        $validator
            ->add('cpa_fresh_sperm_conc', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('cpa_fresh_sperm_conc');

        $validator
            ->add('cpa_fresh_total_motility', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('cpa_fresh_total_motility');

        $validator
            ->add('cpa_fresh_rapid_motility', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('cpa_fresh_rapid_motility');

        $validator
            ->add('cpa_fresh_prog_motality', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('cpa_fresh_prog_motality');

        $validator
            ->add('mbcd_sperm_conc', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('mbcd_sperm_conc');

        $validator
            ->add('mbcd_total_motality', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('mbcd_total_motality');

        $validator
            ->add('mbcd_rapid_motality', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('mbcd_rapid_motality');

        $validator
            ->add('mbcd_prog_motality', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('mbcd_prog_motality');

        $validator
            ->allowEmpty('sperm_analyzer');

        $validator
            ->add('epi_storage_tank', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('epi_storage_tank');

        $validator
            ->add('epi_storage_rack', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('epi_storage_rack');

        $validator
            ->add('epi_storage_box', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('epi_storage_box');

        $validator
            ->add('epi_storage_space', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('epi_storage_space');

        $validator
            ->allowEmpty('epi_storage_vial_id_no');

        $validator
            ->allowEmpty('epi_storage_code');

        $validator
            ->add('male_genotype_confirmed', 'valid', ['rule' => 'boolean'])
            ->allowEmpty('male_genotype_confirmed');

        $validator
            ->add('geno_date', 'valid', ['rule' => 'date'])
            ->allowEmpty('geno_date');

        $validator
            ->allowEmpty('genotyped_by');

        $validator
            ->allowEmpty('sperm_info_comments');

        $validator
            ->allowEmpty('eggs_info_donor_strain');

        $validator
            ->allowEmpty('eggs_info_genotype');

        $validator
            ->add('eggs_info_donor_dob', 'valid', ['rule' => 'date'])
            ->allowEmpty('eggs_info_donor_dob');

        $validator
            ->allowEmpty('eggs_info_donor_age');

        $validator
            ->allowEmpty('eggs_info_comments');

        $validator
            ->add('females_ordered_no', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('females_ordered_no');

        $validator
            ->add('females_out_no', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('females_out_no');

        $validator
            ->add('unsuperovulated_no', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('unsuperovulated_no');

        $validator
            ->add('pmsg_time', 'valid', ['rule' => 'time'])
            ->allowEmpty('pmsg_time');

        $validator
            ->add('hcg_time', 'valid', ['rule' => 'time'])
            ->allowEmpty('hcg_time');

        $validator
            ->allowEmpty('pmsg_hcg_by');

        $validator
            ->add('icsi', 'valid', ['rule' => 'boolean'])
            ->allowEmpty('icsi');

        $validator
            ->allowEmpty('ivf_method');

        $validator
            ->allowEmpty('laser_system');

        $validator
            ->add('pulse_duration', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('pulse_duration');

        $validator
            ->add('laser_power', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('laser_power');

        $validator
            ->add('co_culture_hrs', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('co_culture_hrs');

        $validator
            ->allowEmpty('incubator_id_no');

        $validator
            ->add('two_cell_score_time', 'valid', ['rule' => 'time'])
            ->allowEmpty('two_cell_score_time');

        $validator
            ->allowEmpty('ivf_icsi_by');

        $validator
            ->allowEmpty('ivf_icsi_info_comment');

        $validator
            ->add('egg_collection_time', 'valid', ['rule' => 'time'])
            ->allowEmpty('egg_collection_time');

        $validator
            ->add('icsi_end_time', 'valid', ['rule' => 'time'])
            ->allowEmpty('icsi_end_time');

        $validator
            ->add('eggs_injected_no', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('eggs_injected_no');

        $validator
            ->add('eggs_survived_no', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('eggs_survived_no');

        $validator
            ->add('survival_rate', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('survival_rate');

        $validator
            ->allowEmpty('more_icsi_info_comments');

        $validator
            ->allowEmpty('ivf_medium');

        $validator
            ->allowEmpty('ivf_medium_lot');

        $validator
            ->allowEmpty('ivf_medium_vendor');

        $validator
            ->allowEmpty('oil_vendor');

        $validator
            ->allowEmpty('oil_lot');

        $validator
            ->add('fmp_id_no', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('fmp_id_no');

        $validator
            ->add('fmp_job_id_no', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('fmp_job_id_no');

        $validator
            ->add('fmp_sc_id_no', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('fmp_sc_id_no');

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
        $rules->add($rules->existsIn(['sperm_cryo_id'], 'SpermCryos'));
        return $rules;
    }
}
