<?php
namespace App\Model\Table;

use App\Model\Entity\InventoryShippedVial;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * InventoryShippedVials Model
 *
 */
class InventoryShippedVialsTable extends Table
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

        $this->table('inventory_shipped_vials');
        $this->displayField('id');
        $this->primaryKey('id');
        
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
            ->allowEmpty('label');

        $validator
            ->allowEmpty('volume');

        $validator
            ->allowEmpty('comments');

        $validator
            ->add('tissue', 'valid', ['rule' => 'boolean'])
            ->allowEmpty('tissue');

        $validator
            ->add('original_vial_id_no', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('original_vial_id_no');

        $validator
            ->add('original_location_id_no', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('original_location_id_no');

        $validator
            ->add('original_vial_type_id_no', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('original_vial_type_id_no');

        $validator
            ->add('original_created', 'valid', ['rule' => 'datetime'])
            ->allowEmpty('original_created');

        $validator
            ->add('original_modified', 'valid', ['rule' => 'datetime'])
            ->allowEmpty('original_modified');

        $validator
            ->allowEmpty('order_no');
            // ->requirePresence('order_no', 'create')
            // ->notEmpty('order_no');

        $validator
            ->requirePresence('ship_thaw_reason', 'create')
            ->notEmpty('ship_thaw_reason');

        $validator
            ->add('ship_thaw_date', 'valid', ['rule' => 'date'])
            ->allowEmpty('ship_thaw_date');

        return $validator;
    }
}
