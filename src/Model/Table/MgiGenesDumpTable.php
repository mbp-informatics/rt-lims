<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * MgiGenesDump Model
 *
 * @property \Cake\ORM\Association\BelongsTo $MgiAccessions
 *
 * @method \App\Model\Entity\MgiGenesDump get($primaryKey, $options = [])
 * @method \App\Model\Entity\MgiGenesDump newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\MgiGenesDump[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\MgiGenesDump|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\MgiGenesDump patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\MgiGenesDump[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\MgiGenesDump findOrCreate($search, callable $callback = null, $options = [])
 */
class MgiGenesDumpTable extends Table
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

        $this->table('mgi_genes_dump');
        $this->displayField('marker_symbol');
        $this->primaryKey('mgi_accession_id');
        
        $this->belongsToMany('Projects', [
            'joinTable' => 'projects_genes',
            'through' => 'ProjectsGenes',
            'foreignKey' => 'mgi_accession_id',
            'targetForeignKey' => 'project_id',
        ]);
        $this->hasMany('ImitsDumpMiAttempts', [
            'foreignKey' => 'mgi_accession_id'
        ]);
        $this->hasOne('ImitsDumpMiPlans', [
            'foreignKey' => 'mgi_accession_id'
        ]);
        $this->hasMany('ImitsDumpPhenotypeAttempts', [
            'foreignKey' => 'mgi_accession_id'
        ]);
        $this->hasMany('KompProjectsDump', [
            'foreignKey' => 'mgi_accession_id'
        ]);
        $this->hasMany('GenesStatuses', [
            'foreignKey' => 'mgi_accession_id'
        ]);
        $this->hasMany('Colonies', [
            'foreignKey' => 'mgi_accession_id'
        ]);
        $this->hasMany('Jobs', [
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

        $validator
            ->allowEmpty('chr');

        $validator
            ->allowEmpty('cm_position');

        $validator
            ->integer('genome_coord_start')
            ->allowEmpty('genome_coord_start');

        $validator
            ->integer('genome_coord_end')
            ->allowEmpty('genome_coord_end');

        $validator
            ->allowEmpty('strand');

        $validator
            ->allowEmpty('marker_symbol');

        $validator
            ->allowEmpty('status');

        $validator
            ->allowEmpty('marker_name');

        $validator
            ->allowEmpty('marker_type');

        $validator
            ->allowEmpty('feature_type');

        $validator
            ->allowEmpty('marker_synonyms');

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
        // $rules->add($rules->existsIn(['mgi_accession_id'], 'MgiGenesDump'));

        return $rules;
    }
}
