<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * CrisprDesign Entity.
 *
 * @property int $id
 * @property int $gene_id
 * @property string $comments
 * @property string $vector_name
 * @property string $nuclease
 * @property string $batch_upload_id
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 * @property \App\Model\Entity\CrisprAttribute[] $crispr_attributes
 * @property \App\Model\Entity\CrisprDesignAttribute[] $crispr_design_attributes
 * @property \App\Model\Entity\CrisprDesignPrimer[] $crispr_design_primers
 * @property \App\Model\Entity\CrisprPrimer[] $crispr_primers
 * @property \App\Model\Entity\Injection[] $injections
 */
class CrisprDesign extends Entity
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
