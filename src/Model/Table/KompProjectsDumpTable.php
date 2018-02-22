<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * KompProjectsDump Model
 *
 * @property \Cake\ORM\Association\BelongsTo $KompGenes
 * @property \Cake\ORM\Association\BelongsTo $MouseClones
 *
 * @method \App\Model\Entity\KompProjectsDump get($primaryKey, $options = [])
 * @method \App\Model\Entity\KompProjectsDump newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\KompProjectsDump[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\KompProjectsDump|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\KompProjectsDump patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\KompProjectsDump[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\KompProjectsDump findOrCreate($search, callable $callback = null, $options = [])
 */
class KompProjectsDumpTable extends Table
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

        $this->table('komp_projects_dump');
        $this->displayField('id');
        $this->primaryKey('id');
        $this->addBehavior('Timestamp');
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
            ->allowEmpty('colony_name');

        $validator
            ->allowEmpty('gene');

        $validator
            ->allowEmpty('clone_name');

        $validator
            ->allowEmpty('clone_nickname');

        $validator
            ->allowEmpty('mutation');

        $validator
            ->allowEmpty('mutation_id_no');

        $validator
            ->allowEmpty('cell_line');

        $validator
            ->integer('mgi_number')
            ->allowEmpty('mgi_number');

        $validator
            ->allowEmpty('epd');

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
        return $rules;
    }
}
