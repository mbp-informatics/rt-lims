<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * QcCreflip Entity.
 *
 * @property int $id
 * @property int $vial_id
 * @property \App\Model\Entity\Vial $vial
 * @property \Cake\I18n\Time $started
 * @property \Cake\I18n\Time $finished
 * @property int $started_by
 * @property int $finished_by
 * @property int $pass
 * @property string $comment
 * @property int $pcr1
 * @property int $southern1
 * @property int $northern1
 * @property int $electroporation1
 * @property int $pcr2
 * @property int $southern2
 * @property int $northern2
 * @property int $electroporation2
 * @property int $pcr3
 * @property int $southern3
 * @property int $northern3
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 * @property int $user_id
 * @property \App\Model\Entity\User $user
 */
class QcCreflip extends Entity
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
