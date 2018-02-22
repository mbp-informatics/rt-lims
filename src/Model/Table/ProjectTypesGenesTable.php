<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ProjectTypesGenes Model
 *
 * @property \Cake\ORM\Association\BelongsTo $ProjectTypes
 * @property \Cake\ORM\Association\BelongsTo $MgiAccessions
 *
 * @method \App\Model\Entity\ProjectTypesGene get($primaryKey, $options = [])
 * @method \App\Model\Entity\ProjectTypesGene newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ProjectTypesGene[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ProjectTypesGene|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ProjectTypesGene patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ProjectTypesGene[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ProjectTypesGene findOrCreate($search, callable $callback = null, $options = [])
 */
class ProjectTypesGenesTable extends Table
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

        $this->table('project_types_genes');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->belongsTo('ProjectTypes', [
            'foreignKey' => 'project_type_id'
        ]);
        $this->belongsTo('MgiGenesDump', [
            'foreignKey' => 'mgi_accession_id'
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
        $rules->add($rules->existsIn(['project_type_id'], 'ProjectTypes'));
        $rules->add($rules->existsIn(['mgi_accession_id'], 'MgiGenesDump'));

        return $rules;
    }

/**
 * This method adds a new gene to project_types_genes table 
 * for all project types defined. E.g. At the time of writing, 
 * there are 2 project types defined: KOMP@
 */
// public function enrollGene($mgiAccessionId) {
//     $this->loadModel('ProjectTypesGenes');
//     foreach ($this->projectTypes as $projectTypeId => $projName) {
//         $projectTypeGene = $this->ProjectTypesGenes->newEntity();
//         $projectTypeGene = $this->ProjectTypesGenes->patchEntity($projectTypeGene, [
//                 'mgi_accession_id' => $this->request->data['mgi_accession_id'],
//                 'project_type_id' => $projectTypeId
//         ]);
//         if (!$this->ProjectTypesGenes->save($projectTypeGene)) {
//             throw new \Exception("Rolling back the transaction. The genes status could not be saved. Please, try again.");                
//         }
//     }
// }
}
