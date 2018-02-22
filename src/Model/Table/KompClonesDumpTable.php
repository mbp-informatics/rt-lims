<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * KompClonesDump Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Users
 * @property \Cake\ORM\Association\BelongsTo $Genes
 *
 * @method \App\Model\Entity\KompClonesDump get($primaryKey, $options = [])
 * @method \App\Model\Entity\KompClonesDump newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\KompClonesDump[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\KompClonesDump|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\KompClonesDump patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\KompClonesDump[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\KompClonesDump findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class KompClonesDumpTable extends Table
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

        $this->table('komp_clones_dump');
        $this->displayField('id');
        $this->primaryKey('id');
        $this->addBehavior('Timestamp');
        $this->hasMany('EsCells', [
            'foreignKey' => 'komp_clones_dump_id'
        ]);
        $this->hasMany('QcCustomerInvivos', [
            'foreignKey' => 'komp_clones_dump_id'
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
            ->allowEmpty('clone_number');

        $validator
            ->integer('receiving')
            ->allowEmpty('receiving');

        $validator
            ->allowEmpty('fp_plate');

        $validator
            ->allowEmpty('fp_well');

        $validator
            ->allowEmpty('epd');

        $validator
            ->allowEmpty('epd_pass');

        $validator
            ->allowEmpty('epd_pass_score');

        $validator
            ->allowEmpty('epd_distribute');

        $validator
            ->integer('mutation_type')
            ->allowEmpty('mutation_type');

        $validator
            ->allowEmpty('mutation_id_no');

        $validator
            ->allowEmpty('pg');

        $validator
            ->allowEmpty('pgs_plate');

        $validator
            ->allowEmpty('pgs_well');

        $validator
            ->integer('pgs_well_id_no')
            ->allowEmpty('pgs_well_id_no');

        $validator
            ->allowEmpty('pgs_pass');

        $validator
            ->allowEmpty('pgs_pass_score');

        $validator
            ->allowEmpty('pgs_distribute');

        $validator
            ->allowEmpty('pc');

        $validator
            ->allowEmpty('pcs_plate');

        $validator
            ->allowEmpty('pcs_well');

        $validator
            ->allowEmpty('pcs_pass');

        $validator
            ->allowEmpty('pcs_pass_score');

        $validator
            ->allowEmpty('pcs_distribute');

        $validator
            ->allowEmpty('dp');

        $validator
            ->integer('design_id_no')
            ->allowEmpty('design_id_no');

        $validator
            ->integer('design_instance_id_no')
            ->allowEmpty('design_instance_id_no');

        $validator
            ->allowEmpty('project_id_no');

        $validator
            ->integer('cassette')
            ->allowEmpty('cassette');

        $validator
            ->integer('backbone')
            ->allowEmpty('backbone');

        $validator
            ->integer('cell_line')
            ->allowEmpty('cell_line');

        $validator
            ->integer('passage')
            ->allowEmpty('passage');

        $validator
            ->integer('design')
            ->allowEmpty('design');

        $validator
            ->allowEmpty('available');

        $validator
            ->integer('qc_result')
            ->allowEmpty('qc_result');

        $validator
            ->integer('sanger_project')
            ->allowEmpty('sanger_project');

        $validator
            ->integer('facility')
            ->allowEmpty('facility');

        $validator
            ->allowEmpty('maid');

        $validator
            ->allowEmpty('mice_available');

        $validator
            ->allowEmpty('sperm_available');

        $validator
            ->allowEmpty('sperm_recovery_available');

        $validator
            ->allowEmpty('embryo_available');

        $validator
            ->allowEmpty('embryo_recovery_available');

        $validator
            ->integer('pass5arm')
            ->allowEmpty('pass5arm');

        $validator
            ->integer('passloxp')
            ->allowEmpty('passloxp');

        $validator
            ->integer('pass3arm')
            ->allowEmpty('pass3arm');

        $validator
            ->allowEmpty('mice_rederivation_available');

        $validator
            ->allowEmpty('mice_toronto_available');

        $validator
            ->allowEmpty('mice_available_conventional');

        $validator
            ->dateTime('mice_status_update_date')
            ->allowEmpty('mice_status_update_date');

        $validator
            ->dateTime('cryo_status_update_date')
            ->allowEmpty('cryo_status_update_date');

        $validator
            ->allowEmpty('is_mouse_clone');

        $validator
            ->boolean('is_crispr')
            ->allowEmpty('is_crispr');

        $validator
            ->allowEmpty('mutation');

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
        $rules->add($rules->existsIn(['user_id'], 'Users'));
        return $rules;
    }
}
