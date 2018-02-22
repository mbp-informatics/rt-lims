<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * KompGenesDump Model
 *
 * @method \App\Model\Entity\KompGenesDump get($primaryKey, $options = [])
 * @method \App\Model\Entity\KompGenesDump newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\KompGenesDump[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\KompGenesDump|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\KompGenesDump patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\KompGenesDump[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\KompGenesDump findOrCreate($search, callable $callback = null, $options = [])
 */
class KompGenesDumpTable extends Table
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

        $this->table('komp_genes_dump');
        $this->displayField('ID');
        $this->primaryKey('ID');
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
            ->integer('ID')
            ->allowEmpty('ID', 'create');

        $validator
            ->integer('MGI_Number')
            ->allowEmpty('MGI_Number')
            ->add('MGI_Number', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->allowEmpty('Chr');

        $validator
            ->allowEmpty('cM');

        $validator
            ->allowEmpty('Symbol');

        $validator
            ->allowEmpty('Status');

        $validator
            ->allowEmpty('Name');

        $validator
            ->integer('MGI_type')
            ->allowEmpty('MGI_type');

        $validator
            ->integer('available')
            ->allowEmpty('available');

        $validator
            ->integer('ensembl')
            ->allowEmpty('ensembl');

        $validator
            ->integer('vega')
            ->allowEmpty('vega');

        $validator
            ->integer('Regeneron')
            ->allowEmpty('Regeneron');

        $validator
            ->integer('CSD')
            ->allowEmpty('CSD');

        $validator
            ->integer('EUCOMM')
            ->allowEmpty('EUCOMM');

        $validator
            ->integer('IGTC')
            ->allowEmpty('IGTC');

        $validator
            ->integer('Targeted')
            ->allowEmpty('Targeted');

        $validator
            ->integer('Other_Mutants')
            ->allowEmpty('Other_Mutants');

        $validator
            ->integer('Sanger')
            ->allowEmpty('Sanger');

        $validator
            ->allowEmpty('komptarget');

        $validator
            ->date('kompgenesversion')
            ->allowEmpty('kompgenesversion');

        $validator
            ->integer('start')
            ->allowEmpty('start');

        $validator
            ->integer('end')
            ->allowEmpty('end');

        $validator
            ->allowEmpty('strand');

        $validator
            ->integer('IMSR')
            ->allowEmpty('IMSR');

        $validator
            ->allowEmpty('vectorAvailable');

        $validator
            ->allowEmpty('miceAvailable');

        $validator
            ->integer('NorCOMM')
            ->allowEmpty('NorCOMM');

        $validator
            ->allowEmpty('TIGM');

        $validator
            ->integer('spermAvailable')
            ->allowEmpty('spermAvailable');

        $validator
            ->integer('embryoAvailable')
            ->allowEmpty('embryoAvailable');

        $validator
            ->date('MGIupdate')
            ->allowEmpty('MGIupdate');

        $validator
            ->allowEmpty('comment');

        $validator
            ->integer('GXD')
            ->allowEmpty('GXD');

        $validator
            ->integer('synonym_of')
            ->allowEmpty('synonym_of');

        $validator
            ->integer('hasBeenOrdered')
            ->allowEmpty('hasBeenOrdered');

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
