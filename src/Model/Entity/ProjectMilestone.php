<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ProjectMilestone Entity.
 *
 * @property int $id
 * @property int $project_id
 * @property \App\Model\Entity\Project $project
 * @property int $project_status_id
 * @property \App\Model\Entity\ProjectStatus $project_status
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 */
class ProjectMilestone extends Entity
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
