<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * CrisprPrimer Entity.
 *
 * @property int $id
 * @property int $crispr_design_id
 * @property string $name
 * @property string $sequence
 * @property int $chr_start
 * @property int $chr_end
 * @property string $comments
 * @property \Cake\I18n\Time $date_ordered
 * @property string $ordered_by
 * @property string $status
 * @property \Cake\I18n\Time $date_status
 * @property string $confirmed
 * @property string $change_log
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 * @property \App\Model\Entity\CrisprDesign[] $crispr_designs
 */
class CrisprPrimer extends Entity
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
