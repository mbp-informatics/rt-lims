<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\TableRegistry;

/**
 * KompVialsDump Model
 *
 * @property \Cake\ORM\Association\BelongsTo $KompGenes
 * @property \Cake\ORM\Association\BelongsTo $MouseClones
 * @property \Cake\ORM\Association\BelongsTo $MgiAccessions
 * @property \Cake\ORM\Association\BelongsTo $KompVials
 *
 * @method \App\Model\Entity\KompVialsDump get($primaryKey, $options = [])
 * @method \App\Model\Entity\KompVialsDump newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\KompVialsDump[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\KompVialsDump|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\KompVialsDump patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\KompVialsDump[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\KompVialsDump findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class KompVialsDumpTable extends Table
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

        $this->table('komp_vials_dump');
        $this->displayField('id');
        $this->primaryKey('komp_vial_id');
        $this->addBehavior('Timestamp');
        $this->belongsToMany('Jobs', [
            'foreignKey' => 'komp_vial_id',
            'targetForeignKey' => 'job_id',
            'joinTable' => 'kompvials_jobs'
        ]);
        // $this->hasOne('InventoryVials', [
        //     'foreignKey' => 'kompvialid'
        // ]);
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
            ->allowEmpty('id', 'create')
            ->add('id', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

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
        $rules->add($rules->isUnique(['id']));
        $rules->add($rules->existsIn(['komp_gene_id'], 'KompGenes'));
        $rules->add($rules->existsIn(['mouse_clone_id'], 'MouseClones'));
        $rules->add($rules->existsIn(['mgi_accession_id'], 'MgiAccessions'));
        $rules->add($rules->existsIn(['komp_vial_id'], 'KompVials'));
        return $rules;
    }

    /* Returns komp vials associated with a given job via jobId*/        
    function findKompVials($job) {
        $kv = TableRegistry::get('KompvialsJobs');
        $j = TableRegistry::get('Jobs');
        $job = $j->get($job, ['contain' => 'KompVialsDump']);
        $vialsJobs = $kv->find('all')->where(['job_id' => $job->id])->toArray();
        $kompOrderIds = [];
        foreach ($vialsJobs as $vj) {
            $kompOrderIds[$vj['komp_vial_id']] = $vj['komp_order_id'];
        }
        
        $kompVials = [];
        foreach ($job['komp_vials_dump'] as $k => $kv) {
            if ($kv['_joinData']['komp_order_id'] == $job['komp_vials_dump'][$k]['komp_order_id']) {
                $kompVials[] = $job['komp_vials_dump'][$k];
            } else {
                unset($job['komp_vials_dump'][$k]);
            }

        }
        return $kompVials;
    }

}