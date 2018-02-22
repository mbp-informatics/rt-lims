<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * JobComment Entity.
 *
 * @property int $id
 * @property int $job_id
 * @property \App\Model\Entity\Job $job
 * @property int $user_id
 * @property \App\Model\Entity\User $user
 * @property string $comment
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 */
class JobComment extends Entity
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
