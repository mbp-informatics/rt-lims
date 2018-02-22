<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * InventorySample Entity.
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string $mmrrc_id_no
 * @property int $fmp_record
 * @property string $investigator
 * @property string $storage_comments
 * @property int $inventory_embryo_id
 * @property \App\Model\Entity\InventoryEmbryo $inventory_embryo
 * @property int $inventory_sperm_id
 * @property \App\Model\Entity\InventorySperm $inventory_sperm
 * @property int $inventory_sample_source_id
 * @property \App\Model\Entity\InventorySampleSource $inventory_sample_source
 * @property \Cake\I18n\Time $cryo_date
 * @property string $last_name
 * @property string $label_color
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 * @property string $sample_type
 * @property \App\Model\Entity\InventoryVial[] $inventory_vials
 */
class InventorySample extends Entity
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
