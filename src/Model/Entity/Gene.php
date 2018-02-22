<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Gene Entity.
 *
 * @property int $id
 * @property int $mi_plan_id
 * @property string $mgi_accession_id
 * @property string $marker_symbol
 * @property string $marker_name
 * @property string $orthologs
 * @property int $number_go_terms
 * @property string $type_go_terms
 * @property int $interest_rank
 * @property int $chr_start
 * @property int $chr_end
 * @property string $cm
 * @property \App\Model\Entity\Status $status
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 * @property \App\Model\Entity\CrisprDesign[] $crispr_designs
 * @property \App\Model\Entity\Project[] $projects
 */
class Gene extends Entity
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
