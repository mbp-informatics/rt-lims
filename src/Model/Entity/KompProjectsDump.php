<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * KompProjectsDump Entity
 *
 * @property int $id
 * @property string $colony_name
 * @property string $gene
 * @property int $komp_gene_id
 * @property string $clone_name
 * @property string $clone_nickname
 * @property int $mouse_clone_id
 * @property string $mutation
 * @property string $mutation_id_no
 * @property string $cell_line
 * @property int $mgi_number
 * @property string $epd
 *
 * @property \App\Model\Entity\KompGene $komp_gene
 * @property \App\Model\Entity\MouseClone $mouse_clone
 */
class KompProjectsDump extends Entity
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
