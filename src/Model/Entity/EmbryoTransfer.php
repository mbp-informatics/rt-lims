<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * EmbryoTransfer Entity.
 *
 * @property int $id
 * @property int $job_id
 * @property \App\Model\Entity\Job $job
 * @property int $embryo_resus_id
 * @property \App\Model\Entity\EmbryoResus $embryo_resus
 * @property int $ivf_id
 * @property \App\Model\Entity\Ivf $ivf
 * @property int $mmrrc_no
 * @property int $bl_no
 * @property string $pn_cr_no
 * @property string $membership
 * @property string $pts_ko_mo_no
 * @property bool $crispr
 * @property string $strain_name
 * @property string $et_purpose
 * @property string $investigator
 * @property string $lab_contact
 * @property string $background
 * @property string $komp_clone
 * @property \Cake\I18n\Time $et_date
 * @property string $et_lab
 * @property \Cake\I18n\Time $et_time
 * @property \Cake\I18n\Time $expected_dob
 * @property string $et_by
 * @property string $et_location
 * @property int $et_id_no
 * @property string $fresh_frozen
 * @property bool $icsi_embryos
 * @property string $assisted_ivf_embryos
 * @property bool $save_pups
 * @property string $send_tails_to
 * @property int $sc_no
 * @property int $straw_no
 * @property int $no_ec
 * @property int $no_recovered
 * @property int $no_bad
 * @property int $no_intact
 * @property string $recipient_strain
 * @property string $anesthetic
 * @property string $anesthetic_lot_no
 * @property string $analgesic
 * @property string $analgesic_lot_no
 * @property string $comments
 * @property bool $swollen_ampulla
 * @property bool $no_cl
 * @property string $maternity_updated_by
 * @property string $pup_genotype_updated_by
 * @property int $total_embryos_tx
 * @property int $total_pups_born
 * @property float $et_birth_rate
 * @property int $total_male_pups
 * @property int $total_female_pups
 * @property int $total_mut_males
 * @property int $total_mut_females
 * @property int $et_total_mut_mice
 * @property int $no_recipients
 * @property int $no_litters
 * @property int $litter_rate
 * @property string $search
 * @property string $primary_recharge
 * @property string $secondary_recharge
 * @property string $test_et_birth_rate
 * @property int $no_total_chimeras
 * @property int $no_total_male_chimeras
 * @property int $no_total_female_chimeras
 * @property int $chimeras_less_than_fifty
 * @property int $chimera_bl_no
 * @property int $chimera_pn_no
 * @property bool $chimera_crispr
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 * @property int $user_id
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Recipient[] $recipients
 */
class EmbryoTransfer extends Entity
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
