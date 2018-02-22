<?php
namespace App\Model\Table;

use App\Model\Entity\CrisprDesign;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CrisprDesigns Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Genes
 * @property \Cake\ORM\Association\BelongsTo $Projects
 * @property \Cake\ORM\Association\BelongsTo $BatchUploads
 * @property \Cake\ORM\Association\HasMany $CrisprAttributes
 * @property \Cake\ORM\Association\HasMany $CrisprDesignAttributes
 * @property \Cake\ORM\Association\HasMany $CrisprDesignPrimers
 * @property \Cake\ORM\Association\HasMany $CrisprPrimers
 * @property \Cake\ORM\Association\HasMany $Injections
 */
class CrisprDesignsTable extends Table
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

        $this->table('crispr_designs');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Projects', [
            'foreignKey' => 'project_id'
        ]);
        $this->hasMany('CrisprAttributes', [
            'foreignKey' => 'crispr_design_id'
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
            ->add('id', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('id', 'create');

        $validator
            ->allowEmpty('comments');

        $validator
            ->allowEmpty('vector_name');

        $validator
            ->allowEmpty('nuclease');

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
        return $rules;
    }
}
