<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * InventorySperm Entity.
 *
 * @property int $id
 * @property string $sc
 * @property string $cryo_method
 * @property string $donor_id_no
 * @property int $sperm_cryo_id
 * @property \App\Model\Entity\SpermCryo $sperm_cryo
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 * @property \App\Model\Entity\Donor $donor
 * @property \App\Model\Entity\InventorySample[] $inventory_samples
 */
class InventorySperm extends Entity
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
