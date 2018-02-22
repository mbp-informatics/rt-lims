<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ChangeLog Entity.
 *
 * @property int $id
 * @property string $table_alias
 * @property int $entity_id
 * @property \App\Model\Entity\Entity $entity
 * @property string $changes
 * @property string $user_info
 * @property string $old_entity
 * @property \Cake\I18n\Time $change_date
 */
class ChangeLog extends Entity
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
