<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * PseudopregnantRecipientOrderEntry Entity.
 *
 * @property int $id
 * @property int $pseudopregnant_recipient_order_id
 * @property \App\Model\Entity\PseudopregnantRecipientOrder $pseudopregnant_recipient_order
 * @property string $recharge
 * @property string $location
 * @property \Cake\I18n\Time $date_plugged
 * @property \Cake\I18n\Time $date_needed
 * @property string $pseudo_state
 * @property int $quantity
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 */
class PseudopregnantRecipientOrderEntry extends Entity
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
