<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * InventoryLocation Entity.
 *
 * @property int $id
 * @property int $cell
 * @property int $inventory_box_id
 * @property \App\Model\Entity\InventoryBox $inventory_box
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 * @property \App\Model\Entity\InventoryVial $inventory_vial
 * @property \App\Model\Entity\InventoryShipping[] $inventory_shippings
 */
class InventoryLocation extends Entity
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
