<?php
namespace App\Model\Table;

use App\Model\Entity\Recipient;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

use Cake\Event\Event;
use ArrayObject;
use Cake\Datasource\EntityInterface;
use Cake\ORM\TableRegistry;


/**
 * Recipients Model
 *
 * @property \Cake\ORM\Association\BelongsTo $EmbryoTransfers
 * @property \Cake\ORM\Association\BelongsTo $Users
 */
class RecipientsTable extends Table
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

        $this->table('recipients');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('EmbryoTransfers', [
            'foreignKey' => 'embryo_transfer_id'
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
            ->allowEmpty('ear_mark');

        $validator
            ->add('weight', 'valid', ['rule' => 'decimal'])
            ->allowEmpty('weight');

        $validator
            ->add('dob', 'valid', ['rule' => 'date'])
            ->allowEmpty('dob');

        $validator
            ->allowEmpty('embryo_stage');

        $validator
            ->add('anesthetic_vol', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('anesthetic_vol');

        $validator
            ->add('analgesic_vol', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('analgesic_vol');

        $validator
            ->add('cl', 'valid', ['rule' => 'boolean'])
            ->allowEmpty('cl');

        $validator
            ->add('amp', 'valid', ['rule' => 'boolean'])
            ->allowEmpty('amp');

        $validator
            ->add('tx_l', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('tx_l');

        $validator
            ->add('tx_r', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('tx_r');

        $validator
            ->add('total_tx', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('total_tx');

        $validator
            ->add('male_pups', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('male_pups');

        $validator
            ->add('female_pups', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('female_pups');

        $validator
            ->add('total_pups', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('total_pups');

        $validator
            ->add('male_mut', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('male_mut');

        $validator
            ->add('female_mut', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('female_mut');

        $validator
            ->allowEmpty('pups_born');

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
        $rules->add($rules->existsIn(['embryo_transfer_id'], 'EmbryoTransfers'));
        $rules->add($rules->existsIn(['user_id'], 'Users'));
        return $rules;
    }
    //update 'injections.number_transfered' field whenever recipients entry is added/updated
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
        //First find injection id
        if (isset($entity['embryo_transfer_id'])) {
            $ets = TableRegistry::get('EmbryoTransfers');
            $injectionId = $ets->get($entity['embryo_transfer_id'])->injection_id;
        }
        // then update injections table
        if (isset($injectionId) && !empty($injectionId)) {
            $injections = TableRegistry::get('Injections');
            $injections->updateNumberTransfered($injectionId);
        }
    }

}
