<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * KompvialsJob Entity
 *
 * @property int $id
 * @property int $job_id
 * @property int $komp_vial_id
 * @property int $user_id
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 *
 * @property \App\Model\Entity\Job $job
 * @property \App\Model\Entity\KompVial $komp_vial
 * @property \App\Model\Entity\User $user
 */
class KompvialsJob extends Entity
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
        'id' => false
    ];
}
