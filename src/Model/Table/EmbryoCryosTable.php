<?php
namespace App\Model\Table;

use App\Model\Entity\EmbryoCryo;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * EmbryoCryos Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Jobs
 * @property \Cake\ORM\Association\BelongsTo $Ivfs
 * @property \Cake\ORM\Association\BelongsTo $Users
 * @property \Cake\ORM\Association\HasMany $EmbryoResus
 */
class EmbryoCryosTable extends Table
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

        $this->table('embryo_cryos');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Jobs', [
            'foreignKey' => 'job_id'
        ]);
        $this->belongsTo('Ivfs', [
            'foreignKey' => 'ivf_id'
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id'
        ]);
        $this->hasMany('EmbryoResus', [
            'foreignKey' => 'embryo_cryo_id'
        ]);
        $this->hasMany('EmbryoTransfers', [
            'foreignKey' => 'embryo_cryo_id'
        ]);
        $this->hasMany('InventoryVials', [
            'foreignKey' => 'embryo_cryo_id'
        ]);
        // $this->belongsTo('InventoryVials', [
        //     'foreignKey' => 'straw_id_no'
        // ]);
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
            ->add('receiving_date', 'valid', ['rule' => 'date'])
            ->allowEmpty('receiving_date');

        $validator
            ->allowEmpty('pi_or_mmrrc');

        $validator
            ->allowEmpty('search');

        $validator
            ->allowEmpty('background');

        $validator
            ->allowEmpty('stud_strain');

        $validator
            ->allowEmpty('stud_id_no');

        $validator
            ->add('stud_dob', 'valid', ['rule' => 'date'])
            ->allowEmpty('stud_dob');

        $validator
            ->allowEmpty('male_genotype');

        $validator
            ->allowEmpty('female_strain_name');

        $validator
            ->allowEmpty('no_females_used');

        $validator
            ->allowEmpty('female_age');

        $validator
            ->allowEmpty('female_genotype');

        $validator
            ->add('genotype_confirmed', 'valid', ['rule' => 'boolean'])
            ->allowEmpty('genotype_confirmed');

        $validator
            ->allowEmpty('donor_genotyped_by');

        $validator
            ->add('donor_genotyping_date', 'valid', ['rule' => 'date'])
            ->allowEmpty('donor_genotyping_date');

        $validator
            ->allowEmpty('donor_genotype_comments');

        $validator
            ->allowEmpty('fert_method');

        $validator
            ->allowEmpty('ec_method');

        $validator
            ->allowEmpty('ivf_by');

        $validator
            ->allowEmpty('ec_by');

        $validator
            ->allowEmpty('cryo_embryo_stage');

        $validator
            ->allowEmpty('ec_media_lot');

        $validator
            ->allowEmpty('label_color');

        $validator
            ->add('biocool_id_no', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('biocool_id_no');

        $validator
            ->add('proh_time_min', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('proh_time_min');

        $validator
            ->allowEmpty('start_temp');

        $validator
            ->add('start_time', 'valid', ['rule' => 'time'])
            ->allowEmpty('start_time');

        $validator
            ->allowEmpty('end_temp');

        $validator
            ->add('end_time', 'valid', ['rule' => 'time'])
            ->allowEmpty('end_time');

        $validator
            ->add('time_hold_at_end_temp', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('time_hold_at_end_temp');

        $validator
            ->allowEmpty('cryo_info_comments');

        $validator
            ->allowEmpty('blast_genotype');

        $validator
            ->add('embryogeno_confirmed', 'valid', ['rule' => 'boolean'])
            ->allowEmpty('embryogeno_confirmed');

        $validator
            ->allowEmpty('ec_test_genotyped_by');

        $validator
            ->add('embryo_geno_date', 'valid', ['rule' => 'date'])
            ->allowEmpty('embryo_geno_date');

        $validator
            ->allowEmpty('embryo_genotype_notes');

        $validator
            ->add('thawing_date', 'valid', ['rule' => 'date'])
            ->allowEmpty('thawing_date');

        $validator
            ->allowEmpty('straw_id_no');

        $validator
            ->add('recovered_no', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('recovered_no');

        $validator
            ->add('intact_no', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('intact_no');

        $validator
            ->add('cultured_no', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('cultured_no');

        $validator
            ->add('blasts_no', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('blasts_no');

        $validator
            ->allowEmpty('culture_medium');

        $validator
            ->allowEmpty('culture_medium_lot');

        $validator
            ->allowEmpty('cultured_by');
            
        $validator
            ->allowEmpty('incubator_no');

        $validator
            ->allowEmpty('ec_test_thaw_comments');

        $validator
            ->add('fmp_id_no', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('fmp_id_no');

        $validator
            ->add('fmp_ivf_id_no', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('fmp_ivf_id_no');

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
        $rules->add($rules->existsIn(['job_id'], 'Jobs'));
        $rules->add($rules->existsIn(['ivf_id'], 'Ivfs'));
        $rules->add($rules->existsIn(['user_id'], 'Users'));
        return $rules;
    }
}
