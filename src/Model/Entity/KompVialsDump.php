<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * KompVialsDump Entity
 *
 * @property int $id
 * @property string $gene
 * @property int $komp_gene_id
 * @property string $clone_name
 * @property string $clone_nickname
 * @property int $mouse_clone_id
 * @property string $mutation
 * @property string $mutation_id_no
 * @property string $cell_line
 * @property string $mgi_accession_id
 * @property string $epd
 * @property int $komp_vial_id
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 */
class KompVialsDump extends Entity
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
