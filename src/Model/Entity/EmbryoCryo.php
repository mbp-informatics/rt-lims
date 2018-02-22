<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * EmbryoCryo Entity.
 *
 * @property int $id
 * @property int $job_id
 * @property \App\Model\Entity\Job $job
 * @property int $ivf_id
 * @property \App\Model\Entity\Ivf $ivf
 * @property \Cake\I18n\Time $cryo_date
 * @property \Cake\I18n\Time $receiving_date
 * @property string $pi_or_mmrrc
 * @property string $search
 * @property string $affiliation
 * @property string $school
 * @property string $stud_strain
 * @property int $stud_id_no
 * @property \Cake\I18n\Time $stud_dob
 * @property string $male_genotype
 * @property string $female_strain_name
 * @property string $no_females_used
 * @property string $female_age
 * @property string $female_genotype
 * @property bool $genotype_confirmed
 * @property bool $incorrect_genotype
 * @property string $donor_genotyped_by
 * @property \Cake\I18n\Time $donor_genotyping_date
 * @property string $donor_genotype_comments
 * @property string $fert_method
 * @property string $ec_method
 * @property string $ivf_by
 * @property string $ec_by
 * @property string $cryo_embryo_stage
 * @property string $ec_media_lot
 * @property string $label_color
 * @property int $biocool_id_no
 * @property int $proh_time_min
 * @property string $start_temp
 * @property \Cake\I18n\Time $start_time
 * @property string $end_temp
 * @property \Cake\I18n\Time $end_time
 * @property int $time_hold_at_end_temp
 * @property string $cryo_info_comments
 * @property string $blast_genotype
 * @property bool $embryogeno_confirmed
 * @property string $ec_test_genotyped_by
 * @property \Cake\I18n\Time $embryo_geno_date
 * @property string $embryo_genotype_notes
 * @property \Cake\I18n\Time $thawing_date
 * @property int $straw_id_no
 * @property int $recovered_no
 * @property int $intact_no
 * @property int $cultured_no
 * @property int $blasts_no
 * @property string $culture_medium
 * @property string $culture_medium_lot
 * @property string $cultured_by
 * @property int $etd_no
 * @property string $ec_test_embryo_stage
 * @property int $pups_no
 * @property int $mut_no
 * @property \Cake\I18n\Time $et_date
 * @property string $et_by
 * @property string $incubator_no
 * @property string $ec_test_thaw_comments
 * @property int $user_id
 * @property \App\Model\Entity\User $user
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 * @property \App\Model\Entity\EmbryoResus[] $embryo_resus
 */
class EmbryoCryo extends Entity
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
