<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * SpermCryo Entity.
 *
 * @property int $id
 * @property int $user_id
 * @property \App\Model\Entity\User $user
 * @property int $job_id
 * @property \App\Model\Entity\Job $job
 * @property \Cake\I18n\Time $cryo_date
 * @property string $pi_first_name
 * @property string $pi_last_name
 * @property string $pi_affiliation
 * @property string $pi_school
 * @property string $pi_campus
 * @property string $pi_department
 * @property string $donor_genotype
 * @property int $donor_id_no
 * @property \Cake\I18n\Time $donor_dob
 * @property int $donor_age
 * @property string $cryo_sample_type
 * @property string $cryo_method
 * @property string $cryo_caps_label_color
 * @property string $cryo_medium
 * @property int $cryo_cpm_lot_no
 * @property int $cryo_mosm
 * @property float $cryo_sperm_conc
 * @property int $cryo_total_motility
 * @property int $cryo_rapid_motility
 * @property int $cryo_prog_motility
 * @property string $cryo_sperm_analyser
 * @property int $cryo_abnormal_heads
 * @property int $cryo_abnormal_tails
 * @property string $cryo_scored_by
 * @property string $cryo_collected_by
 * @property string $cryo_sc_performed_by
 * @property string $cryo_comments
 * @property \Cake\I18n\Time $modified
 * @property \Cake\I18n\Time $created
 */
class SpermCryo extends Entity
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
