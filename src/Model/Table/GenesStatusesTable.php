<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * GenesStatuses Model
 *
 * @property \Cake\ORM\Association\BelongsTo $MgiAccessions
 * @property \Cake\ORM\Association\BelongsTo $GeneStatuses
 * @property \Cake\ORM\Association\BelongsTo $Users
 *
 * @method \App\Model\Entity\GenesStatus get($primaryKey, $options = [])
 * @method \App\Model\Entity\GenesStatus newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\GenesStatus[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\GenesStatus|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\GenesStatus patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\GenesStatus[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\GenesStatus findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class GenesStatusesTable extends Table
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

        $this->table('genes_statuses');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('MgiGenesDump', [
            'foreignKey' => 'mgi_accession_id',
        ]);
        $this->belongsTo('GeneStatuses', [
            'foreignKey' => 'gene_status_id',
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id'
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
            ->allowEmpty('comment');

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
        $rules->add($rules->existsIn(['gene_status_id'], 'GeneStatuses'));
        return $rules;
    }
}
