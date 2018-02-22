<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * EmbryoResus Entity.
 *
 * @property int $id
 * @property int $job_id
 * @property \App\Model\Entity\Job $job
 * @property int $embryo_cryo_id
 * @property \App\Model\Entity\EmbryoCryo $embryo_cryo
 * @property \Cake\I18n\Time $cryo_date
 * @property string $investigator
 * @property string $membership
 * @property string $strain
 * @property string $purpose
 * @property string $freezing_medium_lot
 * @property string $thawing_medium_lot
 * @property \Cake\I18n\Time $thawing_date
 * @property \Cake\I18n\Time $thawing_time
 * @property string $tank
 * @property string $rack
 * @property string $box
 * @property string $space
 * @property string $thawed_by
 * @property string $embryo_stage
 * @property int $straw_no
 * @property int $embryos_no
 * @property int $recovered_no
 * @property int $intact_no
 * @property int $bad_lysed_no
 * @property int $cultured_no
 * @property int $morulae_no
 * @property int $blastocysts_no
 * @property float $blastocyst_rate
 * @property string $comments
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 */
class EmbryoResus extends Entity
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
