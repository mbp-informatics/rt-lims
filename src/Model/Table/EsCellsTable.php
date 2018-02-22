<?php
namespace App\Model\Table;

use App\Model\Entity\EsCell;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * EsCells Model
 *
 * @property \Cake\ORM\Association\BelongsTo $InventoryVials
 * @property \Cake\ORM\Association\BelongsTo $ParentEsCells
 * @property \Cake\ORM\Association\BelongsTo $Projects
 * @property \Cake\ORM\Association\BelongsTo $Items
 * @property \Cake\ORM\Association\BelongsTo $Users
 * @property \Cake\ORM\Association\HasMany $ChildEsCells
 */
class EsCellsTable extends Table
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

        $this->table('es_cells');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasOne('InventoryVials', [
            'foreignKey' => 'es_cell_id',
            // 'joinType' => 'INNER'
        ]);
        $this->belongsTo('ParentEsCells', [
            'className' => 'EsCells',
            'foreignKey' => 'parent_id'
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id'
        ]);
        $this->hasMany('ChildEsCells', [
            'className' => 'EsCells',
            'foreignKey' => 'parent_id'
        ]);
        // $this->belongsTo('KompClonesDump', [
        //     'foreignKey' => 'komp_clones_dump_id'
        // ]);
        $this->hasOne('QualityControls', [
            'foreignKey' => 'es_cell_id',
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
            ->add('dna', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('dna');

        $validator
            ->add('frozen_date', 'valid', ['rule' => 'date'])
            ->allowEmpty('frozen_date');

        $validator
            ->add('frozen_by', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('frozen_by');

        $validator
            ->add('passage', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('passage');

        $validator
            ->add('status', 'valid', ['rule' => 'boolean'])
            ->allowEmpty('status');

        $validator
            ->add('mra_treated', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('mra_treated');

        $validator
            ->add('myco_pos', 'valid', ['rule' => 'boolean'])
            ->allowEmpty('myco_pos');

        $validator
            ->allowEmpty('changed');

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
        $rules->add($rules->existsIn(['inventory_vial_id'], 'InventoryVials'));
        $rules->add($rules->existsIn(['parent_id'], 'ParentEsCells'));
        $rules->add($rules->existsIn(['user_id'], 'Users'));
        return $rules;
    }
}
