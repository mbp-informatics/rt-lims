<?php
namespace App\Model\Table;

use App\Model\Entity\EmbryoResus;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * EmbryoResus Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Jobs
 * @property \Cake\ORM\Association\BelongsTo $EmbryoCryos
 */
class EmbryoResusTable extends Table
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

        $this->table('embryo_resus');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Jobs', [
            'foreignKey' => 'job_id'
        ]);
        $this->belongsTo('EmbryoCryos', [
            'foreignKey' => 'embryo_cryo_id'
        ]);
        $this->hasMany('EmbryoTransfers', [
            'foreignKey' => 'embryo_resus_id'
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
            ->allowEmpty('investigator');

        $validator
            ->allowEmpty('membership');

        $validator
            ->allowEmpty('strain');

        $validator
            ->allowEmpty('purpose');

        $validator
            ->allowEmpty('freezing_medium_lot');

        $validator
            ->allowEmpty('thawing_medium_lot');

        $validator
            ->add('thawing_date', 'valid', ['rule' => 'date'])
            ->allowEmpty('thawing_date');

        $validator
            ->add('thawing_time', 'valid', ['rule' => 'time'])
            ->allowEmpty('thawing_time');

        $validator
            ->allowEmpty('tank');

        $validator
            ->allowEmpty('rack');

        $validator
            ->allowEmpty('box');

        $validator
            ->allowEmpty('space');

        $validator
            ->allowEmpty('thawed_by');

        $validator
            ->allowEmpty('embryo_stage');

        $validator
            ->allowEmpty('straw_no');

        $validator
            ->add('embryos_no', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('embryos_no');

        $validator
            ->add('recovered_no', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('recovered_no');

        $validator
            ->add('intact_no', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('intact_no');

        $validator
            ->add('bad_lysed_no', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('bad_lysed_no');

        $validator
            ->add('cultured_no', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('cultured_no');

        $validator
            ->add('morulae_no', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('morulae_no');

        $validator
            ->add('blastocysts_no', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('blastocysts_no');

        $validator
            ->add('blastocyst_rate', 'valid', ['rule' => 'decimal'])
            ->allowEmpty('blastocyst_rate');

        $validator
            ->allowEmpty('comments');

        $validator
            ->add('fmp_id_no', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('fmp_id_no');

        $validator
            ->add('fmp_ec_id_no', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('fmp_ec_id_no');

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
        $rules->add($rules->existsIn(['embryo_cryo_id'], 'EmbryoCryos'));
        return $rules;
    }
}
