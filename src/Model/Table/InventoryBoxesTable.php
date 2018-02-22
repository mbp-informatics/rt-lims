<?php
namespace App\Model\Table;

use App\Model\Entity\InventoryBox;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * InventoryBoxes Model
 *
 * @property \Cake\ORM\Association\BelongsTo $InventoryContainers
 * @property \Cake\ORM\Association\BelongsTo $InventoryBoxTypes
 * @property \Cake\ORM\Association\HasMany $InventoryLocations
 */
class InventoryBoxesTable extends Table
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

        $this->table('inventory_boxes');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('InventoryContainers', [
            'foreignKey' => 'inventory_container_id',
            'joinType' => 'LEFT'
        ]);
        $this->belongsTo('InventoryBoxTypes', [
            'foreignKey' => 'inventory_box_type_id',
            'joinType' => 'LEFT'
        ]);
        $this->hasMany('InventoryLocations', [
            'foreignKey' => 'inventory_box_id'
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
            ->requirePresence('name', 'create')
            ->notEmpty('name');

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
        $rules->add($rules->existsIn(['inventory_container_id'], 'InventoryContainers'));
        $rules->add($rules->existsIn(['inventory_box_type_id'], 'InventoryBoxTypes'));
        return $rules;
    }
}
