<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * InventoryBox Entity.
 *
 * @property int $id
 * @property string $name
 * @property int $inventory_container_id
 * @property \App\Model\Entity\InventoryContainer $inventory_container
 * @property int $inventory_box_type_id
 * @property \App\Model\Entity\InventoryBoxType $inventory_box_type
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 * @property \App\Model\Entity\InventoryLocation[] $inventory_locations
 */
class InventoryBox extends Entity
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
