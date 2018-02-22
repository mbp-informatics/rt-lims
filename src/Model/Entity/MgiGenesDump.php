<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * MgiGenesDump Entity
 *
 * @property int $id
 * @property string $mgi_accession_id
 * @property string $chr
 * @property string $cm_position
 * @property int $genome_coord_start
 * @property int $genome_coord_end
 * @property string $strand
 * @property string $marker_symbol
 * @property string $status
 * @property string $marker_name
 * @property string $marker_type
 * @property string $feature_type
 * @property string $marker_synonyms
 *
 * @property \App\Model\Entity\MgiAccession $mgi_accession
 */
class MgiGenesDump extends Entity
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
