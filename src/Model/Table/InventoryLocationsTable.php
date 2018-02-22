<?php
namespace App\Model\Table;

use App\Model\Entity\InventoryLocation;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * InventoryLocations Model
 *
 * @property \Cake\ORM\Association\BelongsTo $InventoryBoxes
 * @property \Cake\ORM\Association\HasMany $InventoryShippings
 * @property \Cake\ORM\Association\HasMany $InventoryVials
 */
class InventoryLocationsTable extends Table
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

        $this->table('inventory_locations');
        $this->displayField('cell');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('InventoryBoxes', [
            'foreignKey' => 'inventory_box_id',
            'joinType' => 'LEFT'
        ]);
        $this->hasMany('InventoryShippings', [
            'foreignKey' => 'inventory_location_id'
        ]);
        $this->hasOne('InventoryVials', [
            'foreignKey' => 'inventory_location_id',
            'joinType' => 'LEFT'
        ]);
        $this->hasMany('Genotypings', [
            'foreignKey' => 'inventory_location_id'
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
            ->add('cell', 'valid', ['rule' => 'numeric'])
            ->requirePresence('cell', 'create')
            ->notEmpty('cell');

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
        $rules->add($rules->existsIn(['inventory_box_id'], 'InventoryBoxes'));
        return $rules;
    }
}
