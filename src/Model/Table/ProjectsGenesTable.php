<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ProjectsGenes Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Projects
 * @property \Cake\ORM\Association\BelongsTo $MgiAccessions
 * @property \Cake\ORM\Association\BelongsTo $Users
 *
 * @method \App\Model\Entity\ProjectsGene get($primaryKey, $options = [])
 * @method \App\Model\Entity\ProjectsGene newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ProjectsGene[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ProjectsGene|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ProjectsGene patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ProjectsGene[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ProjectsGene findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ProjectsGenesTable extends Table
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

        $this->table('projects_genes');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id'
        ]);

        $this->belongsTo('Projects');
        $this->belongsTo('MgiGenesDump', [
            'foreignKey' => 'mgi_accession_id',
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
        $rules->add($rules->existsIn(['project_id'], 'Projects'));
        $rules->add($rules->existsIn(['mgi_accession_id'], 'MgiGenesDump'));
        $rules->add($rules->existsIn(['user_id'], 'Users'));

        return $rules;
    }
}
