<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * QcCustomerInvivo Entity.
 *
 * @property int $id
 * @property int $clone_id
 * @property \App\Model\Entity\Clone $clone
 * @property int $order_id
 * @property \App\Model\Entity\Order $order
 * @property string $starting_product
 * @property string $injection_outcome
 * @property string $germline_outcome
 * @property string $notes
 * @property \Cake\I18n\Time $updated
 * @property \Cake\I18n\Time $injection_date
 * @property \Cake\I18n\Time $germline_date
 * @property int $added_by
 * @property int $updated_by
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 * @property int $user_id
 * @property \App\Model\Entity\User $user
 * @property int $quality_control_id
 */
class QcCustomerInvivo extends Entity
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
