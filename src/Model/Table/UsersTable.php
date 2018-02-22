<?php
namespace App\Model\Table;

use App\Model\Entity\User;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\Rule\IsUnique;

/**
 * Users Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Roles
 * @property \Cake\ORM\Association\HasMany $CalendarCollections
 * @property \Cake\ORM\Association\HasMany $CalendarInjections
 * @property \Cake\ORM\Association\HasMany $CalendarTransfers
 * @property \Cake\ORM\Association\HasMany $Collections
 * @property \Cake\ORM\Association\HasMany $Injections
 * @property \Cake\ORM\Association\HasMany $ProjectProcedureLogs
 * @property \Cake\ORM\Association\HasMany $ProjectProcedures
 * @property \Cake\ORM\Association\HasMany $PseudopregnantRecipientOrders
 * @property \Cake\ORM\Association\HasMany $SpermCryos
 * @property \Cake\ORM\Association\HasMany $Transfers
 * @property \Cake\ORM\Association\BelongsToMany $ProjectProcedures
 */
class UsersTable extends Table
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

        $this->table('users');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Roles', [
            'foreignKey' => 'role_id'
        ]);
        $this->hasMany('Collections', [
            'foreignKey' => 'user_id'
        ]);
        $this->hasMany('Injections', [
            'foreignKey' => 'user_id'
        ]);
        $this->hasMany('PseudopregnantRecipientOrders', [
            'foreignKey' => 'user_id'
        ]);
        $this->hasMany('SpermCryos', [
            'foreignKey' => 'user_id'
        ]);
        $this->hasMany('InventoryShippedVials', [
            'foreignKey' => 'user_id'
        ]);
        $this->hasMany('Users', [
            'foreignKey' => 'user_id'
        ]);
        $this->hasMany('SpermCryos', [
            'foreignKey' => 'verified_by'
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
            ->add('is_active', 'valid', ['rule' => 'numeric']);

        $validator
            ->allowEmpty('name');

        $validator
            ->add('username', 'valid', ['rule' => 'alphaNumeric']);

        $validator
            ->add('email', 'valid', ['rule' => 'email'])
            ->allowEmpty('email');

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
        $rules->add($rules->isUnique(['username']));
        $rules->add($rules->isUnique(['email']));
        $rules->add($rules->existsIn(['role_id'], 'Roles'));
        return $rules;
    }
}
