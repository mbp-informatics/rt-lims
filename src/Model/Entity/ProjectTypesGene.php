<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ProjectTypesGene Entity
 *
 * @property int $id
 * @property int $project_type_id
 * @property string $mgi_accession_id
 *
 * @property \App\Model\Entity\ProjectType $project_type
 * @property \App\Model\Entity\MgiAccession $mgi_accession
 */
class ProjectTypesGene extends Entity
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
