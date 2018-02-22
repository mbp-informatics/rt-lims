<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * InventoryShippedVial Entity.
 *
 * @property int $id
 * @property string $label
 * @property string $volume
 * @property string $comments
 * @property bool $tissue
 * @property int $original_vial_id_no
 * @property int $original_location_id_no
 * @property int $original_vial_type_id_no
 * @property \Cake\I18n\Time $original_created
 * @property \Cake\I18n\Time $original_modified
 * @property string $original_location_snapshot
 * @property string $original_vial_type_snapshot
 * @property \App\Model\Entity\OriginalVial $original_vial
 * @property \App\Model\Entity\OriginalLocation $original_location
 * @property \App\Model\Entity\OriginalVialType $original_vial_type
 */
class InventoryShippedVial extends Entity
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
