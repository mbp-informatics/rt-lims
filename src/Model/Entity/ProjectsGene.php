<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ProjectsGene Entity
 *
 * @property int $id
 * @property int $project_id
 * @property int $mgi_accession_id
 * @property int $user_id
 * @property \Cake\I18n\Time $created
 *
 * @property \App\Model\Entity\Project $project
 * @property \App\Model\Entity\MgiAccession $mgi_accession
 * @property \App\Model\Entity\User $user
 */
class ProjectsGene extends Entity
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
        'id' => false
    ];
}
