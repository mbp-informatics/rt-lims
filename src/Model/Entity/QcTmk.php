<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * QcTmk Entity.
 *
 * @property int $id
 * @property int $inventory_vial_id
 * @property \App\Model\Entity\InventoryVial $inventory_vial
 * @property \Cake\I18n\Time $started
 * @property \Cake\I18n\Time $finished
 * @property int $started_by
 * @property int $fnished_by
 * @property int $pass
 * @property string $comment
 * @property int $euploid
 * @property int $ch1
 * @property int $ch2
 * @property int $ch3
 * @property int $ch4
 * @property int $ch5
 * @property int $ch6
 * @property int $ch7
 * @property int $ch8
 * @property int $ch9
 * @property int $ch10
 * @property int $ch11
 * @property int $ch12
 * @property int $ch13
 * @property int $ch14
 * @property int $ch15
 * @property int $ch16
 * @property int $ch17
 * @property int $ch18
 * @property int $ch19
 * @property int $chX
 * @property int $user_id
 * @property \App\Model\Entity\User $user
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 * @property int $kompvialid
 * @property int $quality_control_id
 */
class QcTmk extends Entity
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
