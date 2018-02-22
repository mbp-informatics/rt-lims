<?php
namespace App\Model\Table;

use App\Model\Entity\Phenotype;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Phenotypes Model
 *
 * @property \Cake\ORM\Association\HasMany $Projects
 */
class PhenotypesTable extends Table
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

        $this->table('phenotypes');
        $this->displayField('type');
        $this->primaryKey('id');

        $this->hasMany('Projects', [
            'foreignKey' => 'phenotype_id'
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
            ->allowEmpty('type');

        return $validator;
    }
}
