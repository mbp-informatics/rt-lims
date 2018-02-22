<?php
namespace App\Model\Table;

use App\Model\Entity\CrisprAttribute;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CrisprAttributes Model
 *
 * @property \Cake\ORM\Association\HasMany $CrisprDesignAttributes
 */
class CrisprAttributesTable extends Table
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

        $this->table('crispr_attributes');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->hasMany('CrisprAttributes', [
            'foreignKey' => 'crispr_attribute_id'
        ]);

        $this->belongsTo('CrisprDesigns', [
            'foreignKey' => 'crispr_design_id'
        ]);

        $this->addBehavior('Timestamp');
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
            ->allowEmpty('sequence');

        $validator
            ->allowEmpty('chromosome');

        $validator
            ->add('chr_start', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('chr_start');

        $validator
            ->add('chr_end', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('chr_end');

        return $validator;
    }
}
