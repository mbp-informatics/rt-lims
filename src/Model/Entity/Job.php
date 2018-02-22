<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Job Entity.
 *
 * @property int $id
 * @property int $user_id
 * @property \App\Model\Entity\User $user
 * @property bool $job_status
 * @property int $job_astatus_id
 * @property \App\Model\Entity\JobAstatus $job_astatus
 * @property int $job_bstatus_id
 * @property \App\Model\Entity\JobBstatus $job_bstatus
 * @property string $mcrl_note
 * @property int $sc_tt_batch_no
 * @property string $membership
 * @property string $komp_source
 * @property string $mosaic_id_no
 * @property string $tag_no
 * @property string $im_no
 * @property \Cake\I18n\Time $request_date
 * @property \Cake\I18n\Time $reopened_date
 * @property \Cake\I18n\Time $closed_date
 * @property bool $irm
 * @property string $strain_note
 * @property string $strain_name
 * @property int $mmrrc_no
 * @property int $bl_no
 * @property int $pn_cr_no
 * @property string $esc_clone_id_no
 * @property string $esc_line
 * @property string $genotype
 * @property bool $sexlinked
 * @property string $background
 * @property string $previous_name
 * @property string $method_note
 * @property string $egg_donors
 * @property string $housing
 * @property string $coat_color
 * @property int $males_no
 * @property string $males_id_dob
 * @property int $females_no
 * @property string $females_id_dob
 * @property string $chimeras
 * @property string $chimera_fertility
 * @property bool $genotyping
 * @property bool $by_mgal
 * @property bool $targeting_conf
 * @property string $where_geno
 * @property bool $m3_breeding
 * @property string $pi_iacuc_no
 * @property \Cake\I18n\Time $exp_date
 * @property bool $billed
 * @property int $billing_id_no
 * @property int $order_no
 * @property int $pts_ko_mo_no
 * @property string $url
 * @property string $mcrl_recharge
 * @property string $mvp_recharge
 * @property string $mgel_recharge
 * @property string $et_location
 * @property int $recipient_no
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 * @property \App\Model\Entity\EmbryoCryo[] $embryo_cryos
 * @property \App\Model\Entity\EmbryoResus[] $embryo_resus
 * @property \App\Model\Entity\Ivf[] $ivfs
 * @property \App\Model\Entity\JobComment[] $job_comments
 * @property \App\Model\Entity\JobContact[] $job_contacts
 * @property \App\Model\Entity\JobType[] $job_types
 * @property \App\Model\Entity\SpermCryo[] $sperm_cryos
 */
class Job extends Entity
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
