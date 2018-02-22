<?php
namespace App\Model\Table;

use App\Model\Entity\IvfDish;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * IvfDishes Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Ivfs
 */
class IvfDishesTable extends Table
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

        $this->table('ivf_dishes');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Ivfs', [
            'foreignKey' => 'ivf_id'
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
            ->add('dish_no', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('dish_no');

        $validator
            ->add('clutches_no', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('clutches_no');

        $validator
            ->add('cocs_in_dish_time', 'valid', ['rule' => 'time'])
            ->allowEmpty('cocs_in_dish_time');

        $validator
            ->add('insemination_time', 'valid', ['rule' => 'time'])
            ->allowEmpty('insemination_time');

        $validator
            ->add('sperm_ul', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('sperm_ul');

        $validator
            ->add('one_cell_no', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('one_cell_no');

        $validator
            ->add('two_cell_no', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('two_cell_no');

        $validator
            ->add('fert_rate', 'valid', ['rule' => 'decimal'])
            ->allowEmpty('fert_rate');

        $validator
            ->allowEmpty('note');

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
        $rules->add($rules->existsIn(['ivf_id'], 'Ivfs'));
        return $rules;
    }
}
