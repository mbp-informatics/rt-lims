<?php
namespace App\Model\Table;

use App\Model\Entity\EmbryoTransfer;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

use Cake\Event\Event;
use ArrayObject;
use Cake\Datasource\EntityInterface;
use Cake\ORM\TableRegistry;




/**
 * EmbryoTransfers Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Jobs
 * @property \Cake\ORM\Association\BelongsTo $EmbryoResus
 * @property \Cake\ORM\Association\BelongsTo $Ivfs
 * @property \Cake\ORM\Association\BelongsTo $Users
 * @property \Cake\ORM\Association\HasMany $Recipients
 */
class EmbryoTransfersTable extends Table
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

        $this->table('embryo_transfers');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Jobs', [
            'foreignKey' => 'job_id'
        ]);
        $this->belongsTo('EmbryoResus', [
            'foreignKey' => 'embryo_resus_id'
        ]);
        $this->belongsTo('EmbryoCryos', [
            'foreignKey' => 'embryo_cryo_id'
        ]);
        $this->belongsTo('Ivfs', [
            'foreignKey' => 'ivf_id'
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id'
        ]);
        $this->hasMany('Recipients', [
            'foreignKey' => 'embryo_transfer_id'
        ]);
        $this->belongsTo('Injections', [
            'foreignKey' => 'injection_id'
        ]);
        // $this->belongsTo('InventoryVials', [
        //     'foreignKey' => 'straw_no'
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
            ->allowEmpty('job_id');

        $validator
            ->allowEmpty('mmrrc_no');

        $validator
            ->add('bl_no', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('bl_no');

        $validator
            ->allowEmpty('pn_cr_no');

        $validator
            ->allowEmpty('membership');

        $validator
            ->add('crispr', 'valid', ['rule' => 'boolean'])
            ->allowEmpty('crispr');

        $validator
            ->allowEmpty('strain_name');

        $validator
            ->allowEmpty('et_purpose');

        $validator
            ->allowEmpty('investigator');

        $validator
            ->allowEmpty('lab_contact');

        $validator
            ->allowEmpty('background');

        $validator
            ->allowEmpty('komp_clone');

        $validator
            ->add('et_date', 'valid', ['rule' => 'date'])
            ->allowEmpty('et_date');

        $validator
            ->allowEmpty('et_lab');

        $validator
            ->add('et_time', 'valid', ['rule' => 'time'])
            ->allowEmpty('et_time');

        $validator
            ->add('expected_dob', 'valid', ['rule' => 'date'])
            ->allowEmpty('expected_dob');

        $validator
            ->allowEmpty('et_by');

        $validator
            ->allowEmpty('et_location');

        $validator
            ->allowEmpty('fresh_frozen');

        $validator
            ->add('icsi_embryos', 'valid', ['rule' => 'boolean'])
            ->allowEmpty('icsi_embryos');

        $validator
            ->allowEmpty('assisted_ivf_embryos');

        $validator
            ->add('save_pups', 'valid', ['rule' => 'boolean'])
            ->allowEmpty('save_pups');

        $validator
            ->allowEmpty('send_tails_to');

        $validator
            ->add('embryo_cryo_id', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('embryo_cryo_id');

        $validator
            ->allowEmpty('recipient_strain');

        $validator
            ->allowEmpty('anesthetic');

        $validator
            ->allowEmpty('anesthetic_lot_no');

        $validator
            ->allowEmpty('analgesic');

        $validator
            ->allowEmpty('analgesic_lot_no');

        $validator
            ->allowEmpty('comments');

        $validator
            ->allowEmpty('maternity_updated_by');

        $validator
            ->allowEmpty('pup_genotype_updated_by');

        $validator
            ->add('total_embryos_tx', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('total_embryos_tx');

        $validator
            ->add('total_pups_born', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('total_pups_born');

        $validator
            ->add('et_birth_rate', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('et_birth_rate');

        $validator
            ->add('total_male_pups', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('total_male_pups');

        $validator
            ->add('total_female_pups', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('total_female_pups');

        $validator
            ->add('total_mut_males', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('total_mut_males');

        $validator
            ->add('total_mut_females', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('total_mut_females');

        $validator
            ->add('et_total_mut_mice', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('et_total_mut_mice');

        $validator
            ->add('no_recipients', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('no_recipients');

        $validator
            ->add('no_litters', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('no_litters');

        $validator
            ->add('litter_rate', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('litter_rate');

        $validator
            ->allowEmpty('search');

        $validator
            ->allowEmpty('primary_recharge');

        $validator
            ->allowEmpty('secondary_recharge');

        $validator
            ->add('no_total_chimeras', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('no_total_chimeras');

        $validator
            ->add('no_total_male_chimeras', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('no_total_male_chimeras');

        $validator
            ->add('no_total_female_chimeras', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('no_total_female_chimeras');

        $validator
            ->add('chimeras_greater_than_fifty', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('chimeras_greater_than_fifty');

        $validator
            ->add('chimera_bl_no', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('chimera_bl_no');

        $validator
            ->add('chimera_pn_no', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('chimera_pn_no');

        $validator
            ->add('chimera_crispr', 'valid', ['rule' => 'boolean'])
            ->allowEmpty('chimera_crispr');

        $validator
            ->allowEmpty('analgesic_dose');

        $validator
            ->allowEmpty('analgesic_method');

        $validator
            ->allowEmpty('anesthetic_dose');

        $validator
            ->allowEmpty('anesthetic_method');

        $validator
            ->allowEmpty('injection_id');

        $validator
            ->allowEmpty('pups');

        $validator
            ->add('fmp_id_no', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('fmp_id_no');

        $validator
            ->add('fmp_job_id_no', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('fmp_job_id_no');

        $validator
            ->add('fmp_ivf_id_no', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('fmp_ivf_id_no');

        $validator
            ->add('fmp_rs_id_no', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('fmp_rs_id_no');

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
        $rules->add($rules->existsIn(['embryo_resus_id'], 'EmbryoResus'));
        $rules->add($rules->existsIn(['ivf_id'], 'Ivfs'));
        $rules->add($rules->existsIn(['user_id'], 'Users'));
        $rules->add($rules->existsIn(['injection_id'], 'Injections'));
        $rules->add($rules->existsIn(['embryo_cryo_id'], 'EmbryoCryos'));
        return $rules;
    }

    //update 'injections.number_transfered' field whenever et entry is added/updated
    public function afterSave(Event $event, EntityInterface $entity, ArrayObject $options)
    {
        $this->doNumberTransferredUpdate($entity);
    }

    public function afterDelete(Event $event, EntityInterface $entity, ArrayObject $options)
    {
        $this->doNumberTransferredUpdate($entity);
    }     

    //A little helper
    private function doNumberTransferredUpdate($entity) {
        if (isset($entity['injection_id'])) {
            $injections = TableRegistry::get('Injections');
            $injections->updateNumberTransfered($entity['injection_id']);    
        }
    }

}
