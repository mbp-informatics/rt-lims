<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Contact Entity.
 *
 * @property int $id
 * @property int $job_id
 * @property \App\Model\Entity\Job $job
 * @property int $user_id
 * @property \App\Model\Entity\User $user
 * @property string $contact_type_id
 * @property \App\Model\Entity\ContactType $contact_type
 * @property string $first_name
 * @property string $last_name
 * @property string $campus_company
 * @property string $school
 * @property string $email
 * @property string $location
 * @property string $address
 * @property string $city
 * @property string $state
 * @property string $zip_code
 * @property string $contact
 * @property int $contact_number
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 */
class Contact extends Entity
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
