<?php
namespace App\Model\Table;

use App\Model\Entity\PseudopregnantRecipientOrder;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * PseudopregnantRecipientOrders Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Users
 * @property \Cake\ORM\Association\HasMany $PseudopregnantRecipientOrderEntries
 */
class PseudopregnantRecipientOrdersTable extends Table
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

        $this->table('pseudopregnant_recipient_orders');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id'
        ]);
        $this->hasMany('PseudopregnantRecipientOrderEntries', [
            'foreignKey' => 'pseudopregnant_recipient_order_id',
            'dependent' => true //Tells Cake to cascade on delete
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
            ->add('protocol', 'valid', ['rule' => 'numeric']);
            //->requirePresence('protocol', 'true');

        $validator
            ->add('protocol_expiration', 'valid', ['rule' => 'date'])
            ->requirePresence('protocol_expiration', 'true');

        $validator
            ->requirePresence('protocol_Investigator', 'true'); //note the capital "I"nvestigator!

        $validator
            ->requirePresence('user_id', 'true'); //Requested By field

        $validator
            ->allowEmpty('note');

        $validator
            ->add('time_period_start', 'valid', ['rule' => 'date'])
            ->requirePresence('time_period_start', 'true');

        $validator
            ->add('time_period_end', 'valid', ['rule' => 'date'])
            ->requirePresence('time_period_end', 'true');

        $validator
            ->add('total_plugs', 'valid', ['rule' => 'numeric'])
            ->requirePresence('total_plugs', 'true');

        //$validator->requirePresence('status', 'true');

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
