<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * QcGenotype Entity.
 *
 * @property int $id
 * @property int $inventory_vial_id
 * @property \Cake\I18n\Time $started
 * @property \Cake\I18n\Time $finished
 * @property int $started_by
 * @property int $finished_by
 * @property int $pass
 * @property string|resource $comment
 * @property int $test5
 * @property int $test3
 * @property int $testcopy1
 * @property float $testcopy1value
 * @property int $testLRPCR5
 * @property int $test_integrity5
 * @property \Cake\I18n\Time $date5
 * @property \Cake\I18n\Time $date3
 * @property \Cake\I18n\Time $date_copy
 * @property \Cake\I18n\Time $dateLRPCR5
 * @property \Cake\I18n\Time $date_integrity5
 * @property int $test_genome
 * @property \Cake\I18n\Time $date_genome
 * @property int $lost_y
 * @property \Cake\I18n\Time $date_y
 * @property int $positive_control
 * @property int $test_identity
 * @property \Cake\I18n\Time $last_changed
 * @property int $testLRPCR3
 * @property \Cake\I18n\Time $dateLRPCR3
 * @property int $test_loxp
 * @property \Cake\I18n\Time $date_loxp
 * @property int $loxp_result
 * @property \Cake\I18n\Time $date_loxp_result
 * @property int $prime3_loxp_result
 * @property \Cake\I18n\Time $date_3prime_loxp_result
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 * @property int $user_id
 * @property \App\Model\Entity\User $user
 * @property int $kompvialid
 * @property int $quality_control_id
 * @property \App\Model\Entity\Vial $vial
 */
class QcGenotype extends Entity
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
