<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Project Entity.
 *
 * @property int $id
 * @property string $name
 * @property int $gene_id
 * @property int $project_type_id
 * @property \App\Model\Entity\ProjectType $project_type
 * @property int $project_status_id
 * @property \App\Model\Entity\ProjectStatus $project_status
 * @property string $mutation_id
 * @property \App\Model\Entity\Mutation $mutation
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 * @property \App\Model\Entity\Injection[] $injections
 * @property \App\Model\Entity\ProjectMilestone[] $project_milestones
 */
class Project extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        '*' => true,
        'id' => false,
    ];
}
