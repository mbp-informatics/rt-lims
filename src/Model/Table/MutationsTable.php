<?php
namespace App\Model\Table;

use App\Model\Entity\Mutation;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Mutations Model
 *
 * @property \Cake\ORM\Association\HasMany $Projects
 */
class MutationsTable extends Table
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

        $this->table('mutations');
        $this->displayField('type');
        $this->hasMany('Projects', [
            'foreignKey' => 'mutation_id'
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
            ->allowEmpty('id');

        $validator
            ->allowEmpty('type');

        return $validator;
    }
}
