<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * EsCell Entity.
 *
 * @property int $id
 * @property int $inventory_vial_id
 * @property int $dna
 * @property \Cake\I18n\Time $frozen_date
 * @property int $frozen_by
 * @property int $passage
 * @property int $parent_id
 * @property \App\Model\Entity\EsCell $parent_es_cell
 * @property int $project_id
 * @property \App\Model\Entity\Project $project
 * @property \Cake\I18n\Time $disposal_date
 * @property int $disposal_by
 * @property int $item_id
 * @property int $content
 * @property bool $status
 * @property int $pos
 * @property int $mra_treated
 * @property bool $myco_pos
 * @property \Cake\I18n\Time $changed
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 * @property int $user_id
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\InventoryVial $inventory_vial
 * @property \App\Model\Entity\EsCell[] $child_es_cells
 */
class EsCell extends Entity
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
