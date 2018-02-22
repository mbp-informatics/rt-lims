<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Ivf Entity.
 *
 * @property int $id
 * @property int $job_id
 * @property \App\Model\Entity\Job $job
 * @property \Cake\I18n\Time $ivf_date
 * @property string $background
 * @property string $purpose
 * @property string $membership
 * @property string $sperm_info_donor_strain
 * @property string $fresh_frozen
 * @property string $sample_type
 * @property int $sperm_cryo_id
 * @property string $straw_vial_no
 * @property int $cpa_lot_no
 * @property string $centrifuge_force
 * @property int $centrifuge_time
 * @property \Cake\I18n\Time $collect_thaw_time
 * @property \Cake\I18n\Time $time_in_mbcd
 * @property int $stud_id_no
 * @property \Cake\I18n\Time $stud_dob
 * @property string $abnormal_heads
 * @property string $abnormal_tails
 * @property int $cpa_fresh_sperm_conc
 * @property int $cpa_fresh_total_motility
 * @property int $cpa_fresh_rapid_motility
 * @property int $cpa_fresh_prog_motality
 * @property int $mbcd_sperm_conc
 * @property int $mbcd_total_motality
 * @property int $mbcd_rapid_motality
 * @property int $mbcd_prog_motality
 * @property string $sperm_analyzer
 * @property int $epi_storage_tank
 * @property int $epi_storage_rack
 * @property int $epi_storage_box
 * @property int $epi_storage_space
 * @property string $epi_storage_vial_id_no
 * @property string $epi_storage_code
 * @property bool $male_genotype_confirmed
 * @property bool $male_genotype_correct
 * @property \Cake\I18n\Time $geno_date
 * @property string $genotyped_by
 * @property string $sperm_info_comments
 * @property string $eggs_info_donor_strain
 * @property string $eggs_info_genotype
 * @property \Cake\I18n\Time $eggs_info_donor_dob
 * @property string $eggs_info_donor_age
 * @property string $eggs_info_comments
 * @property int $females_ordered_no
 * @property int $females_out_no
 * @property int $unsuperovulated_no
 * @property \Cake\I18n\Time $pmsg_time
 * @property \Cake\I18n\Time $hcg_time
 * @property string $pmsg_hcg_by
 * @property bool $icsi
 * @property string $ivf_method
 * @property string $laser_system
 * @property int $pulse_duration
 * @property int $laser_power
 * @property int $co_culture_hrs
 * @property int $incubator_id_no
 * @property string $ivf_note
 * @property \Cake\I18n\Time $two_cell_score_time
 * @property string $ivf_icsi_by
 * @property string $ivf_icsi_info_comment
 * @property \Cake\I18n\Time $egg_collection_time
 * @property \Cake\I18n\Time $icsi_end_time
 * @property int $eggs_injected_no
 * @property int $eggs_survived_no
 * @property int $survival_rate
 * @property string $more_icsi_info_comments
 * @property string $ivf_medium
 * @property string $ivf_medium_lot
 * @property string $ivf_medium_vendor
 * @property string $mbcd_medium_lot
 * @property string $oil_vendor
 * @property string $oil_lot
 * @property string $bsa_lot
 * @property string $bsa_vendor
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 * @property \App\Model\Entity\SpermCryo $sperm_cryo
 * @property \App\Model\Entity\EmbryoCryo[] $embryo_cryos
 * @property \App\Model\Entity\Transfer[] $transfers
 */
class Ivf extends Entity
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
