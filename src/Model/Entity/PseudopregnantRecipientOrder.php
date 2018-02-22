<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * PseudopregnantRecipientOrder Entity.
 *
 * @property int $id
 * @property int $protocol
 * @property \Cake\I18n\Time $protocol_expiration
 * @property string $protocol_Investigator
 * @property int $user_id
 * @property \App\Model\Entity\User $user
 * @property string $note
 * @property \Cake\I18n\Time $time_period_start
 * @property \Cake\I18n\Time $time_period_end
 * @property int $total_plugs
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 * @property string $status
 * @property \Cake\I18n\Time $finalize_date
 * @property \App\Model\Entity\PseudopregnantRecipientOrderEntry[] $pseudopregnant_recipient_order_entries
 */
class PseudopregnantRecipientOrder extends Entity
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
