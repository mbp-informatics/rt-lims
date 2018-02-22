<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * QcMicroinjection Entity.
 *
 * @property int $id
 * @property int $inventory_vial_id
 * @property \Cake\I18n\Time $started
 * @property \Cake\I18n\Time $finished
 * @property int $started_by
 * @property int $finished_by
 * @property int $pass
 * @property string $comment
 * @property \Cake\I18n\Time $birthdate
 * @property int $npups
 * @property int $nmale
 * @property int $chimerism
 * @property int $max_chimerism
 * @property int $number_injected
 * @property string $bl
 * @property int $parent_strain
 * @property int $number_pups_born
 * @property int $injection_type
 * @property int $number_recipients
 * @property int $number_litters
 * @property int $user_id
 * @property \App\Model\Entity\User $user
 * @property \Cake\I18n\Time $modified
 * @property \Cake\I18n\Time $created
 * @property int $kompvialid
 * @property int $quality_control_id
 * @property \App\Model\Entity\Vial $vial
 */
class QcMicroinjection extends Entity
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
