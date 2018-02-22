<?php
namespace App\Model\Table;

use App\Model\Entity\ProjectStatus;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ProjectStatuses Model
 *
 * @property \Cake\ORM\Association\HasMany $ProjectMilestones
 * @property \Cake\ORM\Association\HasMany $Projects
 */
class ProjectStatusesTable extends Table
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

        $this->table('project_statuses');
        $this->displayField('status');
        $this->primaryKey('id');

        $this->hasMany('ProjectMilestones', [
            'foreignKey' => 'project_status_id'
        ]);
        $this->hasMany('Projects', [
            'foreignKey' => 'project_status_id'
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
            ->allowEmpty('status');

        return $validator;
    }
}
