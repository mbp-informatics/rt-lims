<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * GenesStatus Entity
 *
 * @property int $id
 * @property string $mgi_accession_id
 * @property int $gene_status_id
 * @property int $user_id
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 * @property string $comment
 *
 * @property \App\Model\Entity\MgiAccession $mgi_accession
 * @property \App\Model\Entity\GeneStatus $gene_status
 * @property \App\Model\Entity\User $user
 */
class GenesStatus extends Entity
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
