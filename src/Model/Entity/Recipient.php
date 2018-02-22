<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Recipient Entity.
 *
 * @property int $id
 * @property string $ear_mark
 * @property int $weight
 * @property \Cake\I18n\Time $dob
 * @property string $embryo_stage
 * @property int $anesthetic_vol
 * @property int $analgesic_vol
 * @property bool $cl
 * @property bool $amp
 * @property int $tx_l
 * @property int $tx_r
 * @property int $total_tx
 * @property int $male_pups
 * @property int $female_pups
 * @property int $total_pups
 * @property int $male_mut
 * @property int $female_mut
 * @property int $male_wt
 * @property int $female_wt
 * @property bool $pups_born
 * @property int $embryo_transfer_id
 * @property \App\Model\Entity\EmbryoTransfer $embryo_transfer
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 * @property int $user_id
 * @property \App\Model\Entity\User $user
 */
class Recipient extends Entity
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
