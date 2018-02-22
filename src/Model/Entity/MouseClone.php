<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * MouseClone Entity.
 *
 * @property int $id
 * @property string $library
 * @property string $sublibrary
 * @property string $name
 * @property string $nickname
 * @property string $comment
 * @property string $warning
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 * @property int $user_id
 * @property \App\Model\Entity\User $user
 * @property int $kp
 * @property int $gene_id
 * @property int $clone_number
 * @property int $receiving
 * @property string $fp_plate
 * @property string $fp_well
 * @property string $epd
 * @property int $epd_pass
 * @property int $epd_pass_id_no
 * @property int $epd_distribute
 * @property int $mutation_type
 * @property string $mutation_id_no
 * @property string $pg
 * @property string $pgs_plate
 * @property string $pgs_well
 * @property int $pgs_well_id_no
 * @property int $pgs_pass
 * @property int $pgs_pass_id_no
 * @property int $pgs_distribute
 * @property string $pc
 * @property string $pcs_plate
 * @property string $pcs_well
 * @property int $pcs_pass
 * @property int $pcs_pass_id_no
 * @property int $pcs_distribute
 * @property string $dp
 * @property int $design_id_no
 * @property int $design_instance_id_no
 * @property string $project_id_no
 * @property int $cassette
 * @property int $backbone
 * @property int $cell_line
 * @property int $passage
 * @property int $design
 * @property int $available
 * @property int $qc_result
 * @property int $sanger_project
 * @property int $facility
 * @property int $maid
 * @property string $mice_available
 * @property string $sperm_available
 * @property string $sperm_recovery_available
 * @property string $embryo_available
 * @property string $embryo_recovery_available
 * @property int $pass5arm
 * @property int $passloxp
 * @property int $pass3arm
 * @property string $mice_rederivation_available
 * @property string $mice_totonto_available
 * @property string $mice_available_conventional
 * @property \Cake\I18n\Time $mice_status_update_date
 * @property \Cake\I18n\Time $cryo_status_update_date
 * @property string $is_mouse_clone
 * @property bool $is_crispr
 */
class MouseClone extends Entity
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
