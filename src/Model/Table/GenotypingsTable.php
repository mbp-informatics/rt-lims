<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Genotypings Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Ivfs
 * @property \Cake\ORM\Association\BelongsTo $SpermCryos
 * @property \Cake\ORM\Association\BelongsTo $EmbryoCryos
 * @property \Cake\ORM\Association\BelongsTo $GenotypeRequests
 *
 * @method \App\Model\Entity\Genotyping get($primaryKey, $options = [])
 * @method \App\Model\Entity\Genotyping newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Genotyping[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Genotyping|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Genotyping patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Genotyping[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Genotyping findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class GenotypingsTable extends Table
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

        $this->table('genotypings');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Ivfs', [
            'foreignKey' => 'ivf_id'
        ]);
        $this->belongsTo('SpermCryos', [
            'foreignKey' => 'sperm_cryo_id'
        ]);
        $this->belongsTo('EmbryoCryos', [
            'foreignKey' => 'embryo_cryo_id'
        ]);
        $this->belongsTo('GenotypeRequests', [
            'foreignKey' => 'genotype_request_id'
        ]);
        $this->belongsTo('InventoryLocations', [
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
            ->integer('id')
            ->allowEmpty('id', 'create')
            ->add('id', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->allowEmpty('source');

        $validator
            ->allowEmpty('male_id_no');

        $validator
            ->allowEmpty('genotype');

        $validator
            ->allowEmpty('note');

        $validator
            ->integer('embryo_count')
            ->allowEmpty('embryo_count');

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
        $rules->add($rules->isUnique(['id']));
        $rules->add($rules->existsIn(['ivf_id'], 'Ivfs'));
        $rules->add($rules->existsIn(['sperm_cryo_id'], 'SpermCryos'));
        $rules->add($rules->existsIn(['embryo_cryo_id'], 'EmbryoCryos'));
        $rules->add($rules->existsIn(['genotype_request_id'], 'GenotypeRequests'));

        return $rules;
    }
}
