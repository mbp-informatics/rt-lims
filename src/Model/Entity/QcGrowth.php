<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * QcGrowth Entity.
 *
 * @property int $id
 * @property int $inventory_vial_id
 * @property \Cake\I18n\Time $started
 * @property \Cake\I18n\Time $finished
 * @property int $started_by
 * @property int $finished_by
 * @property int $pass
 * @property string $comment
 * @property int $confluency
 * @property int $size
 * @property int $shape
 * @property int $texture
 * @property int $color
 * @property int $dead_cells
 * @property int $qc_type
 * @property string $image_name
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 * @property int $user_id
 * @property \App\Model\Entity\User $user
 * @property int $kompvialid
 * @property int $quality_control_id
 * @property \App\Model\Entity\Vial $vial
 */
class QcGrowth extends Entity
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
