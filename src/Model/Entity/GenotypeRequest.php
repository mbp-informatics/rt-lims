<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * GenotypeRequest Entity
 *
 * @property int $id
 * @property int $job_id
 * @property string $sample_type
 * @property int $user_id
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 * @property \Cake\I18n\Time $collection_date
 *
 * @property \App\Model\Entity\Job $job
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Genotyping[] $genotypings
 */
class GenotypeRequest extends Entity
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
