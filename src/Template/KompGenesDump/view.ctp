<?php
/**
  * @var \App\View\AppView $this
  */
?>
<div class="kompGenesDump view large-9 medium-8 columns content">
    <h3><?= h($kompGenesDump->ID) ?></h3>
    <table class="vertical-table table">
        <tr>
            <th scope="row"><?= __('Chr') ?></th>
            <td><?= h($kompGenesDump->Chr) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('CM') ?></th>
            <td><?= h($kompGenesDump->cM) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Symbol') ?></th>
            <td><?= h($kompGenesDump->Symbol) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Status') ?></th>
            <td><?= h($kompGenesDump->Status) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($kompGenesDump->Name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Komptarget') ?></th>
            <td><?= h($kompGenesDump->komptarget) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Strand') ?></th>
            <td><?= h($kompGenesDump->strand) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('VectorAvailable') ?></th>
            <td><?= h($kompGenesDump->vectorAvailable) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('MiceAvailable') ?></th>
            <td><?= h($kompGenesDump->miceAvailable) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('TIGM') ?></th>
            <td><?= h($kompGenesDump->TIGM) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Comment') ?></th>
            <td><?= h($kompGenesDump->comment) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('ID') ?></th>
            <td><?= $this->Number->format($kompGenesDump->ID) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('MGI Number') ?></th>
            <td><a href="/mgi-genes-dump/view/MGI:<?= $kompGenesDump->MGI_Number ?>">MGI:<?= $kompGenesDump->MGI_Number ?></a></td>
        </tr>
        <tr>
            <th scope="row"><?= __('MGI Type') ?></th>
            <td><?= $this->Number->format($kompGenesDump->MGI_type) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Available') ?></th>
            <td><?= $this->Number->format($kompGenesDump->available) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Ensembl') ?></th>
            <td><?= $this->Number->format($kompGenesDump->ensembl) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Vega') ?></th>
            <td><?= $this->Number->format($kompGenesDump->vega) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Regeneron') ?></th>
            <td><?= $this->Number->format($kompGenesDump->Regeneron) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('CSD') ?></th>
            <td><?= $this->Number->format($kompGenesDump->CSD) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('EUCOMM') ?></th>
            <td><?= $this->Number->format($kompGenesDump->EUCOMM) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('IGTC') ?></th>
            <td><?= $this->Number->format($kompGenesDump->IGTC) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Targeted') ?></th>
            <td><?= $this->Number->format($kompGenesDump->Targeted) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Other Mutants') ?></th>
            <td><?= $this->Number->format($kompGenesDump->Other_Mutants) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Sanger') ?></th>
            <td><?= $this->Number->format($kompGenesDump->Sanger) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Start') ?></th>
            <td><?= $this->Number->format($kompGenesDump->start) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('End') ?></th>
            <td><?= $this->Number->format($kompGenesDump->end) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('IMSR') ?></th>
            <td><?= $this->Number->format($kompGenesDump->IMSR) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('NorCOMM') ?></th>
            <td><?= $this->Number->format($kompGenesDump->NorCOMM) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('SpermAvailable') ?></th>
            <td><?= $this->Number->format($kompGenesDump->spermAvailable) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('EmbryoAvailable') ?></th>
            <td><?= $this->Number->format($kompGenesDump->embryoAvailable) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('GXD') ?></th>
            <td><?= $this->Number->format($kompGenesDump->GXD) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Synonym Of') ?></th>
            <td><?= $this->Number->format($kompGenesDump->synonym_of) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('HasBeenOrdered') ?></th>
            <td><?= $this->Number->format($kompGenesDump->hasBeenOrdered) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Kompgenesversion') ?></th>
            <td><?= h($kompGenesDump->kompgenesversion) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('MGIupdate') ?></th>
            <td><?= h($kompGenesDump->MGIupdate) ?></td>
        </tr>
    </table>
</div>
