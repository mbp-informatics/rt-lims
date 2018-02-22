<div class="genesStatuses form large-9 medium-8 columns content">
    <?= $this->Form->create($genesStatus) ?>
    <fieldset>
    <?php
        $marker = isset($genesStatus->mgi_genes_dump->marker_symbol)? ' ('.$genesStatus->mgi_genes_dump->marker_symbol.')' : '<small>(no gene found for this mgi accession id)</small>';
    ?>
        <legend><?= __("Edit Gene Status {$marker}") ?></legend>
        <?php
            echo $this->Form->input('mgi_accession_id', ['type'=>'text']);
            echo $this->Form->input('gene_status_id', ['options' => $geneStatuses]);
            echo $this->Form->input('comment');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Save')) ?>
    <?= $this->Form->end() ?>
</div>