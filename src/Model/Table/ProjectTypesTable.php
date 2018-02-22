<?php
namespace App\Model\Table;

use App\Model\Entity\ProjectType;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ProjectTypes Model
 *
 * @property \Cake\ORM\Association\HasMany $Projects
 */
class ProjectTypesTable extends Table
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

        $this->table('project_types');
        $this->displayField('type');
        $this->primaryKey('id');

        $this->hasMany('ProjectTypesGenes', [
            'foreignKey' => 'project_type_id'
        ]);
        
        $this->hasMany('Projects', [
            'foreignKey' => 'project_type_id'
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
