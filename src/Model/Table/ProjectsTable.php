<?php
namespace App\Model\Table;

use App\Model\Entity\Project;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Projects Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Genes
 * @property \Cake\ORM\Association\BelongsTo $ProjectTypes
 * @property \Cake\ORM\Association\BelongsTo $ProjectStatuses
 * @property \Cake\ORM\Association\BelongsTo $Mutations
 * @property \Cake\ORM\Association\HasMany $Injections
 * @property \Cake\ORM\Association\HasMany $ProjectMilestones
 */
class ProjectsTable extends Table
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

        $this->table('projects');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('ProjectTypes', [
            'foreignKey' => 'project_type_id'
        ]);
        $this->belongsTo('ProjectStatuses', [
            'foreignKey' => 'project_status_id'
        ]);
        $this->belongsTo('Mutations', [
            'foreignKey' => 'mutation_id'
        ]);

        $this->hasMany('ProjectMilestones', [
            'foreignKey' => 'project_id'
        ]);

        $this->hasMany('Colonies', [
            'foreignKey' => 'project_id'
        ]);

        $this->belongsTo('Phenotypes', [
            'foreignKey' => 'phenotype_id'
        ]);

        $this->belongsToMany('MgiGenesDump', [
            'joinTable' => 'projects_genes',
            'through' => 'ProjectsGenes',
            'foreignKey' => 'project_id',
            'targetForeignKey' => 'mgi_accession_id',
        ]);

        $this->belongsToMany('Injections', [
            'joinTable' => 'projects_injections',
            'through' => 'ProjectsInjections',
            'foreignKey' => 'project_id',
            'targetForeignKey' => 'injection_id',
        ]);

        $this->hasMany('CrisprDesigns', [
            'foreignKey' => 'project_id'
        ]);

        $this->hasMany('Jobs', [
            'foreignKey' => 'project_id'
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
            ->add('project_type_id', 'valid', ['rule' => 'numeric'])
            ->requirePresence('project_type_id')
            ->notEmpty('project_type_id');

        $validator
            ->add('project_status_id', 'valid', ['rule' => 'numeric'])
            ->requirePresence('project_status_id')
            ->notEmpty('project_status_id', 'create');

        $validator
            ->add('mutation_id', 'valid', ['rule' => 'numeric'])
            ->requirePresence('mutation_id')
            ->notEmpty('mutation_id', 'create');

        $validator
            ->add('phenotype_id', 'valid', ['rule' => 'numeric'])
            ->requirePresence('phenotype_id')
            ->notEmpty('phenotype_id', 'create');

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
        // $rules->add($rules->existsIn(['project_type_id'], 'ProjectTypes'));
        // $rules->add($rules->existsIn(['project_status_id'], 'ProjectStatuses'));
        // $rules->add($rules->existsIn(['mutation_id'], 'Mutations'));
        return $rules;
    }
}
