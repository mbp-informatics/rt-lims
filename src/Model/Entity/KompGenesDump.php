<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * KompGenesDump Entity
 *
 * @property int $ID
 * @property int $MGI_Number
 * @property string $Chr
 * @property string $cM
 * @property string $Symbol
 * @property string $Status
 * @property string $Name
 * @property int $MGI_type
 * @property int $available
 * @property int $ensembl
 * @property int $vega
 * @property int $Regeneron
 * @property int $CSD
 * @property int $EUCOMM
 * @property int $IGTC
 * @property int $Targeted
 * @property int $Other_Mutants
 * @property int $Sanger
 * @property string $komptarget
 * @property \Cake\I18n\Time $kompgenesversion
 * @property int $start
 * @property int $end
 * @property string $strand
 * @property int $IMSR
 * @property string $vectorAvailable
 * @property string $miceAvailable
 * @property int $NorCOMM
 * @property string $TIGM
 * @property int $spermAvailable
 * @property int $embryoAvailable
 * @property \Cake\I18n\Time $MGIupdate
 * @property string $comment
 * @property int $GXD
 * @property int $synonym_of
 * @property int $hasBeenOrdered
 */
class KompGenesDump extends Entity
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
        'ID' => false
    ];
}
