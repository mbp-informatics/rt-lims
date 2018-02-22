<?php
namespace App\Model\Table;

use App\Model\Entity\PseudopregnantRecipientOrderEntry;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * PseudopregnantRecipientOrderEntries Model
 *
 * @property \Cake\ORM\Association\BelongsTo $PseudopregnantRecipientOrders
 */
class PseudopregnantRecipientOrderEntriesTable extends Table
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

        $this->table('pseudopregnant_recipient_order_entries');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('PseudopregnantRecipientOrders', [
            'foreignKey' => 'pseudopregnant_recipient_order_id'
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
            ->add('id', 'valid', ['rule' => 'numeric']);

        $validator
            ->add('date_plugged', 'valid', ['rule' => 'date'])
            ->requirePresence('date_plugged', 'true');

        $validator
            ->add('date_needed', 'valid', ['rule' => 'date'])
            ->requirePresence('date_needed', 'true');

        $validator
            ->allowEmpty('pseudo_state');

        $validator
            ->add('quantity', 'valid', ['rule' => 'numeric'])
            ->requirePresence('quantity', 'true');

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
        $rules->add($rules->existsIn(['pseudopregnant_recipient_order_id'], 'PseudopregnantRecipientOrders'));
        return $rules;
    }
}
