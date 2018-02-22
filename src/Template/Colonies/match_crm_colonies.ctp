<div class="colonies form large-9 medium-8 columns content" style="background-color:white; padding:20px">
<legend><?= __('Do Colonies and Genes match?') ?></legend>
<p class="badge">Injection id: <?= $injectionId ?></p>
    <?= $this->Form->create($colonies) ?>
    <fieldset>
    <?php
    foreach ($colonies as $colony) { ?>
        <div class='row'>
            <div class='col-xs-5'>
                <label>Colony name</label>
                <input class="form-control" name='colony_id[<?= $colony->id ?>][name]' value='<?= $colony->name ?>' disabled>
            </div>
            <div class='col-xs-1' style='text-align:center; color:#888; margin-top:30px; font-size:19px;'><span class='glyphicon glyphicon-resize-horizontal'></span></div>
            <div class='col-xs-6'>
                <label>Associated Gene</label>
                <?php 
                if (isset($colony->project->project_type_id) && $colony->project->project_type_id == 1) { //KOMP Project ?>
                    <input type="text" name='colony_id[<?= $colony->id ?>][mgi_accession_id]' class="form-control" placeholder="Enter MGI Accession Id, e.g.: MGI:1920453" value="<?= $colony->mgi_accession_id?>">
                <?php
                    $markerSymbol = isset($colony->mgi_genes_dump->marker_symbol) ? $colony->mgi_genes_dump->marker_symbol : '<em>not found</em>';
                    echo "<small><strong>Marker symbol</strong>: {$markerSymbol} ({$colony->mgi_accession_id})</small>";
                } else { ?> 
                    <select name='colony_id[<?= $colony->id ?>][mgi_accession_id]' class="form-control" <?= !isset($colony->mgi_accession_id) ? 'disabled' : ''?>>
                        <option value=''>None</option>
                            <?php 
                            foreach ($genes as $mgi => $gene) { ?>
                                <?php $s = $colony->mgi_accession_id == $mgi ? 'selected' : '' ?>
                                <option value='<?= $mgi ?>' <?= $s ?>>
                                    <?= $gene ?> (<?= $mgi ?>)
                                </option>
                            <?php } ?>
                    </select>
                <?php } //end elseif KOMP project ?>
            </div>
        </div>
        <hr>
    <?php } ?>
    </fieldset>
    <?= $this->Form->button(__('Save'),
        array(
            'class' => 'btn btn-success',
            'div' => false
            )); ?>
    <?= $this->Form->end() ?>
</div>
