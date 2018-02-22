<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * InventoryVial Entity.
 *
 * @property int $id
 * @property string $label
 * @property string $volume
 * @property int $inventory_sample_id
 * @property \App\Model\Entity\InventorySample $inventory_sample
 * @property int $inventory_location_id
 * @property int $inventory_vial_type_id
 * @property \App\Model\Entity\InventoryVialType $inventory_vial_type
 * @property string $comments
 * @property bool $tissue
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 * @property \App\Model\Entity\InventoryLocation $inventory_location
 * @property \App\Model\Entity\InventoryShipping[] $inventory_shippings
 */
class InventoryVial extends Entity
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
