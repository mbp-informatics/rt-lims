<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * IvfDish Entity.
 *
 * @property int $id
 * @property int $ivf_id
 * @property \App\Model\Entity\Ivf $ivf
 * @property int $dish_no
 * @property int $clutches_no
 * @property \Cake\I18n\Time $cocs_in_dish_time
 * @property \Cake\I18n\Time $insemination_time
 * @property int $sperm_ul
 * @property int $one_cell_no
 * @property int $two_cell_no
 * @property float $fert_rate
 * @property string $note
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 */
class IvfDish extends Entity
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
