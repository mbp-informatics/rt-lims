<?php
namespace App\Model\Table;

use App\Model\Entity\InventoryVial;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * InventoryVials Model
 *
 * @property \Cake\ORM\Association\BelongsTo $InventorySamples
 * @property \Cake\ORM\Association\BelongsTo $InventoryLocations
 * @property \Cake\ORM\Association\BelongsTo $InventoryVialTypes
 * @property \Cake\ORM\Association\HasMany $InventoryShippings
 */
class InventoryVialsTable extends Table
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

        $this->table('inventory_vials');
        $this->displayField('label');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('SpermCryos', [
            'foreignKey' => 'sperm_cryo_id',
            'joinType' => 'LEFT'
        ]);
        $this->belongsTo('EmbryoCryos', [
            'foreignKey' => 'embryo_cryo_id',
            'joinType' => 'LEFT'
        ]);
        $this->belongsTo('KompClonesDump', [
            'foreignKey' => 'komp_clone_id',
            'joinType' => 'LEFT'
        ]);
        $this->belongsTo('InventoryVialTypes', [
            'foreignKey' => 'inventory_vial_type_id',
            'joinType' => 'LEFT'
        ]);
        // $this->hasMany('InventoryShippings', [
        //     'foreignKey' => 'inventory_vial_id',
        //     'joinType' => 'LEFT'
        // ]);
        $this->belongsTo('InventoryLocations', [
            'foreignKey' => 'inventory_location_id'
        ]);
        // $this->hasOne('EmbryoCryos', [
        //     'foreignKey' => 'straw_id_no'
        // ]);
        $this->hasMany('Injections', [
            'foreignKey' => 'inventory_vial_id'
        ]);
        $this->belongsTo('EsCells', [
            'foreignKey' => 'es_cell_id',
            // 'joinType' => 'LEFT'
        ]);
        $this->belongsTo('KompVialsDump', [
            'foreignKey' => 'kompvialid',
            'joinType' => 'LEFT'
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
            ->requirePresence('label', 'create')
            ->notEmpty('label');

        $validator
            ->requirePresence('volume', 'create')
            ->notEmpty('volume');

        $validator
            ->allowEmpty('comments');

        $validator
            ->add('tissue', 'valid', ['rule' => 'boolean'])
            ->requirePresence('tissue', 'create')
            ->notEmpty('tissue');

        $validator
            ->requirePresence('inventory_vial_type_id', 'create')
            ->notEmpty('inventory_vial_type_id');

        $validator
            ->allowEmpty('sperm_cryo_id');

        $validator
            ->allowEmpty('embryo_cryo_id');

        $validator
            ->allowEmpty('qc_pass');

        $validator
            ->allowEmpty('pups');

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
        $rules->add($rules->existsIn(['inventory_vial_type_id'], 'InventoryVialTypes'));
        $rules->add($rules->isUnique(['inventory_location_id']));
        return $rules;
    }
}
