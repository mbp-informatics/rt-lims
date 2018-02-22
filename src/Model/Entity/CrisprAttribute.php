<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * CrisprAttribute Entity.
 *
 * @property int $id
 * @property string $sequence
 * @property string $chromosome
 * @property int $chr_start
 * @property int $chr_end
 * @property \App\Model\Entity\CrisprDesign $crispr_design
 */
class CrisprAttribute extends Entity
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
