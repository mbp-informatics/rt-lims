<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Injection Entity.
 *
 * @property int $id
 * @property string $qc_state
 * @property int $user_id
 * @property \App\Model\Entity\User $user
 * @property int $colony_id
 * @property \App\Model\Entity\Colony $colony
 * @property int $project_id
 * @property \App\Model\Entity\Project $project
 * @property string $recharge
 * @property \Cake\I18n\Time $injection_date
 * @property string $membership
 * @property string $donor_strain
 * @property \Cake\I18n\Time $donor_date_of_birth
 * @property string $stud_ids
 * @property \Cake\I18n\Time $pmsg_time
 * @property \Cake\I18n\Time $hcg_time
 * @property int $number_mated
 * @property int $number_plugged
 * @property int $total_eggs_collected
 * @property string $fresh_or_frozen
 * @property string $injection_method
 * @property int $number_injected
 * @property int $number_survived
 * @property int $number_transferred
 * @property string $comments
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 * @property int $mi_plan_id
 * @property int $mi_attempt_id
 * @property int $clone_id
 * @property int $colony_qc_id
 * @property string $investigator
 * @property string $es_cell_source
 * @property string $parental_esc_line
 * @property string $coat_color
 * @property string $es_cell_clone
 * @property string $esc_morphology
 * @property string $embryos_collected_by
 * @property string $injection_type
 * @property string $et_by
 * @property int $total_embryos
 * @property int $total_zygotes
 * @property string $pts_ko_mo
 * @property string $injected_by
 * @property int $number_two_cell
 * @property int $number_zygotes_injected
 * @property \App\Model\Entity\CrisprDesign $crispr_design
 * @property \App\Model\Entity\Transfer[] $transfers
 */
class Injection extends Entity
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
