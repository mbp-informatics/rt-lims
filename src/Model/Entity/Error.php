<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Error Entity
 *
 * @property int $id
 * @property int $entity_id_no
 * @property string $error_type
 * @property string $error
 * @property string $this_object_dump_json
 * @property int $user_id
 * @property string $created
 *
 * @property \App\Model\Entity\Entity $entity
 * @property \App\Model\Entity\User $user
 */
class Error extends Entity
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
