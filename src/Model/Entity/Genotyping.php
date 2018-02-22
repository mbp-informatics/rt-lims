<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Genotyping Entity
 *
 * @property int $id
 * @property string $source
 * @property int $ivf_id
 * @property int $sperm_cryo_id
 * @property int $embryo_cryo_id
 * @property int $genotype_request_id
 * @property string $male_id_no
 * @property string $genotype
 * @property string $note
 * @property int $embryo_count
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 *
 * @property \App\Model\Entity\Ivf $ivf
 * @property \App\Model\Entity\SpermCryo $sperm_cryo
 * @property \App\Model\Entity\EmbryoCryo $embryo_cryo
 * @property \App\Model\Entity\GenotypeRequest $genotype_request
 */
class Genotyping extends Entity
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
