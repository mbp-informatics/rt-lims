<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ImitsDumpPhenotypeAttempt Entity
 *
 * @property int $id
 * @property string $phenotype_attempt_json
 * @property int $imits_phenotype_attempt_id
 * @property int $imits_mi_plan_id
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 * @property int $user_id
 *
 * @property \App\Model\Entity\ImitsPhenotypeAttempt $imits_phenotype_attempt
 * @property \App\Model\Entity\ImitsMiPlan $imits_mi_plan
 * @property \App\Model\Entity\User $user
 */
class ImitsDumpPhenotypeAttempt extends Entity
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
        'id' => false
    ];
}
