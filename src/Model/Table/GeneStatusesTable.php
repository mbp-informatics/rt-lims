<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * GeneStatuses Model
 *
 * @property \Cake\ORM\Association\HasMany $GenesStatuses
 *
 * @method \App\Model\Entity\GeneStatus get($primaryKey, $options = [])
 * @method \App\Model\Entity\GeneStatus newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\GeneStatus[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\GeneStatus|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\GeneStatus patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\GeneStatus[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\GeneStatus findOrCreate($search, callable $callback = null, $options = [])
 */
class GeneStatusesTable extends Table
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

        $this->table('gene_statuses');
        $this->displayField('gene_status');
        $this->primaryKey('id');
        $this->hasMany('GenesStatuses', [
            'foreignKey' => 'gene_status_id'
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
            ->allowEmpty('id', 'create');

        $validator
            ->requirePresence('gene_status', 'create')
            ->notEmpty('gene_status');

        return $validator;
    }
}
