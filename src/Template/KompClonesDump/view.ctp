<?php
/**
  * @var \App\View\AppView $this
  */
?>

<div class="kompClonesDump view large-9 medium-8 columns content">
    <h3><?= h($kompClonesDump->ID) ?></h3>
    <div class='alert alert-info' role='alert'>KOMP Clone Info</div>
    <div class='container-fluid'>
        <div class='row'>  
            <div class='col-xs-4'><strong><?= __('Clone Number') ?>: </strong><?= h($kompClonesDump->clone_number) ?></div>
            <div class='col-xs-4'><strong><?= __('Is CRISPR?') ?>: </strong><?= $kompClonesDump->is_crispr ? __('Yes') : __('No'); ?></div>
            <div class='col-xs-4'><strong><?= __('Gene ID') ?>: </strong><a href="/komp-genes-dump/view/<?= $kompClonesDump->gene_id ?>"><?= $kompClonesDump->gene_id ?></a>
            </div>
        </div>
        <div class='row'>   
            <div class='col-xs-4'><strong><?= __('FP Plate') ?>: </strong><?= h($kompClonesDump->fp_plate) ?></div>
            <div class='col-xs-4'><strong><?= __('FP Well') ?>: </strong><?= h($kompClonesDump->fp_well) ?></div>
            <div class='col-xs-4'><strong><?= __('Is Mouse Clone') ?>: </strong><?= h($kompClonesDump->is_mouse_clone) ?></div>
        </div>
        <div class='row'>   
            <div class='col-xs-4'><strong><?= __('Mutation Type') ?>: </strong><?= $this->Number->format($kompClonesDump->mutation_type) ?></div>
            <div class='col-xs-4'><strong><?= __('Mutation') ?>: </strong><?= h($kompClonesDump->mutation) ?></div>
            <div class='col-xs-4'><strong><?= __('Mutation ID') ?>: </strong><?= h($kompClonesDump->mutation_id_no) ?></div>
        </div>
        <div class='row'> 
            <div class='col-xs-4'><strong><?= __('DP') ?>: </strong><?= h($kompClonesDump->dp) ?></div>
            <div class='col-xs-4'><strong><?= __('Project ID') ?>: </strong><?= h($kompClonesDump->project_id_no) ?></div>
            <!-- <div class='col-xs-4'><strong><?= __('KP') ?>: </strong><?= $this->Number->format($kompClonesDump->kp) ?></div> -->
        </div>
        <div class='row'> 
            <div class='col-xs-4'><strong><?= __('Mice Status Update Date') ?>: </strong><?= h($kompClonesDump->mice_status_update_date) ?></div>
            <div class='col-xs-4'><strong><?= __('Cryo Status Update Date') ?>: </strong><?= h($kompClonesDump->cryo_status_update_date) ?></div>
        </div>
    </div>
    <div class='alert alert-info' role='alert'>PG</div>
    <div class='container-fluid'>
        <div class='row'>  
            <div class='col-xs-4'><strong><?= __('PG') ?>: </strong><?= h($kompClonesDump->pg) ?></div>
            <div class='col-xs-4'><strong><?= __('PGS Plate') ?>: </strong><?= h($kompClonesDump->pgs_plate) ?></div>
            <div class='col-xs-4'><strong><?= __('PGS Well') ?>: </strong><?= h($kompClonesDump->pgs_well) ?></div>
        </div>
        <div class='row'>   
            <div class='col-xs-4'><strong><?= __('PGS Distribute') ?>: </strong><?= h($kompClonesDump->pgs_distribute) ?></div>
            <div class='col-xs-4'><strong><?= __('PGS Pass') ?>: </strong><?= h($kompClonesDump->pgs_pass) ?></div>
            <div class='col-xs-4'><strong><?= __('PGS Well ID') ?>: </strong><?= $this->Number->format($kompClonesDump->pgs_well_id_no) ?></div>
        </div>
    </div>
    <div class='alert alert-info' role='alert'>PC</div>
    <div class='container-fluid'>
        <div class='row'> 
            <div class='col-xs-4'><strong><?= __('PC') ?>: </strong><?= h($kompClonesDump->pc) ?></div>
            <div class='col-xs-4'><strong><?= __('PCS Plate') ?>: </strong><?= h($kompClonesDump->pcs_plate) ?></div>
            <div class='col-xs-4'><strong><?= __('PCS Well') ?>: </strong><?= h($kompClonesDump->pcs_well) ?></div>
        </div>
        <div class='row'>  
            <div class='col-xs-4'><strong><?= __('PCS Distribute') ?>: </strong><?= h($kompClonesDump->pcs_distribute) ?></div>
            <div class='col-xs-4'><strong><?= __('PCS Pass') ?>: </strong><?= h($kompClonesDump->pcs_pass) ?></div>
        </div>
    </div>
    <div class='alert alert-info' role='alert'>EPD</div>
    <div class='container-fluid'>
        <div class='row'>     
            <div class='col-xs-4'><strong><?= __('EPD') ?>: </strong><?= h($kompClonesDump->epd) ?></div>
            <div class='col-xs-4'><strong><?= __('EPD Distribute') ?>: </strong><?= h($kompClonesDump->epd_distribute) ?></div>
            <div class='col-xs-4'><strong><?= __('EPD Pass') ?>: </strong><?= h($kompClonesDump->epd_pass) ?></div>
        </div>
    </div>
    <div class='alert alert-info' role='alert'>Available</div>
    <div class='container-fluid'>
        <div class='row'>  
            <div class='col-xs-4'><strong><?= __('Mice Available') ?>: </strong><?= h($kompClonesDump->mice_available) ?></div>
            <div class='col-xs-4'><strong><?= __('Sperm Available') ?>: </strong><?= h($kompClonesDump->sperm_available) ?></div>
            <div class='col-xs-4'><strong><?= __('Sperm Recovery Available') ?>: </strong><?= h($kompClonesDump->sperm_recovery_available) ?></div>
        </div>
        <div class='row'>   
            <div class='col-xs-4'><strong><?= __('Embryo Available') ?>: </strong><?= h($kompClonesDump->embryo_available) ?></div>
            <div class='col-xs-4'><strong><?= __('Embryo Recovery Available') ?>: </strong><?= h($kompClonesDump->embryo_recovery_available) ?></div>
            <div class='col-xs-4'><strong><?= __('Mice Rederivation Available') ?>: </strong><?= h($kompClonesDump->mice_rederivation_available) ?></div>
        </div>
        <div class='row'>  
            <div class='col-xs-4'><strong><?= __('Mice Toronto Available') ?>: </strong><?= h($kompClonesDump->mice_toronto_available) ?></div>
            <div class='col-xs-4'><strong><?= __('Mice Available Conventional') ?>: </strong><?= h($kompClonesDump->mice_available_conventional) ?></div>
            <div class='col-xs-4'><strong><?= __('Available') ?>: </strong><?= h($kompClonesDump->available) ?></div>
        </div>
<!--         <div class='row'>  
            <div class='col-xs-4'><strong><?= __('Receiving Origin') ?>: </strong><?= $this->Number->format($kompClonesDump->receiving_origin) ?></div>
            <div class='col-xs-4'><strong><?= __('Receiving Distribution Available') ?>: </strong><?= $this->Number->format($kompClonesDump->available) ?></div> 
            <div class='col-xs-4'><strong><?= __('Receiving Arrival') ?>: </strong><?= h($kompClonesDump->receiving_arrival) ?></div>
        </div>
        <div class='row'>  
            <div class='col-xs-4'><strong><?= __('Receiving Released On') ?>: </strong><?= h($kompClonesDump->receiving_released_on) ?></div>
            <div class='col-xs-4'><strong><?= __('Receiving Data Received On') ?>: </strong><?= h($kompClonesDump->receiving_dataReceivedOn) ?></div>
            <div class='col-xs-4'><strong><?= __('Receiving Content') ?>: </strong><?= h($kompClonesDump->receiving_content) ?></div>
        </div> -->
    </div>
    <div class='alert alert-info' role='alert'>Design</div>
    <div class='container-fluid'>
        <div class='row'>          
            <div class='col-xs-4'><strong><?= __('Cassette') ?>: </strong><?= $this->Number->format($kompClonesDump->cassette) ?></div>
            <div class='col-xs-4'><strong><?= __('Backbone') ?>: </strong><?= $this->Number->format($kompClonesDump->backbone) ?></div>
            <div class='col-xs-4'><strong><?= __('Cell Line') ?>: </strong><?= $this->Number->format($kompClonesDump->cell_line) ?></div>
        </div>
        <div class='row'>  
            <div class='col-xs-4'><strong><?= __('Passage') ?>: </strong><?= $this->Number->format($kompClonesDump->passage) ?></div>
            <div class='col-xs-4'><strong><?= __('Design') ?>: </strong><?= $this->Number->format($kompClonesDump->design) ?></div>
            <div class='col-xs-4'><strong><?= __('QC Result') ?>: </strong><?= $this->Number->format($kompClonesDump->qc_result) ?></div>
        </div>
        <div class='row'>              
            <div class='col-xs-4'><strong><?= __('Sanger Project') ?>: </strong><?= $this->Number->format($kompClonesDump->sanger_project) ?></div>
            <div class='col-xs-4'><strong><?= __('Facility') ?>: </strong><?= $this->Number->format($kompClonesDump->facility) ?></div>
            <div class='col-xs-4'><strong><?= __('MAID') ?>: </strong><?= h($kompClonesDump->maid) ?></div>
        </div>
        <div class='row'>              
            <div class='col-xs-4'><strong><?= __('Pass5arm') ?>: </strong><?= $this->Number->format($kompClonesDump->pass5arm) ?></div>
            <div class='col-xs-4'><strong><?= __('Passloxp') ?>: </strong><?= $this->Number->format($kompClonesDump->passloxp) ?></div>
            <div class='col-xs-4'><strong><?= __('Pass3arm') ?>: </strong><?= $this->Number->format($kompClonesDump->pass3arm) ?></div>
        </div>
        <div class='row'>   
            <div class='col-xs-4'><strong><?= __('Design ID') ?>: </strong><?= $this->Number->format($kompClonesDump->design_id_no) ?></div>
            <div class='col-xs-4'><strong><?= __('Design Instance ID') ?>: </strong><?= $this->Number->format($kompClonesDump->design_instance_id_no) ?></div>
        </div>
    </div>
    <div class='alert alert-info' role='alert'>Meta</div>
    <div class='container-fluid'>
        <div class='row'>        
            <div class='col-xs-4'><strong><?= __('Created') ?>: </strong><?= h($kompClonesDump->created) ?></div>
            <div class='col-xs-4'><strong><?= __('Modified') ?>: </strong><?= h($kompClonesDump->modified) ?></div>
            <div class='col-xs-4'><strong><?= __('User') ?>: </strong><?= $kompClonesDump->has('user') ? $this->Html->link($kompClonesDump->user->name, ['controller' => 'Users', 'action' => 'view', $kompClonesDump->user->id]) : '' ?></div>
        </div>
    </div>

    <div class="horizontal-table table-responsive">
        <h4><?= __('Related ES Cells') ?></h4>
        <?php if (!empty($kompClonesDump->es_cells)): ?>
        <table class="data-table table stripe order-column">
            <tr>
                <th><?= __('ID') ?></th>
                <th><?= __('Frozen Date') ?></th>
                <th><?= __('Passage') ?></th>
                <th><?= __('Status') ?></th>
                <th><?= __('Created') ?></th>
                <th><?= __('Modified') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($kompClonesDump->es_cells as $esCells): ?>
            <tr>
                <td><?= h($esCells->id) ?></td>
                <td><?= h($esCells->frozen_date) ?></td>
                <td><?= h($esCells->passage) ?></td>
                <td><?= h($esCells->status) ?></td>
                <td><?= h($esCells->created) ?></td>
                <td><?= h($esCells->modified) ?></td>
                <td class="actions">
                    <?= '<span data-toggle="tooltip" title="View">'. $this->Html->link('<span class="pad-action-glyph glyphicon glyphicon-eye-open"></span>', ['controller' => 'EsCells', 'action' => 'view', $esCells->id],  array('escape' => false, 'class' => 'label label-primary action-pad')) . '</span>' ?>
                    <?= '<span data-toggle="tooltip" title="Edit">'. $this->Html->link('<span class="pad-action-glyph glyphicon glyphicon-pencil"></span>', ['controller' => 'EsCells', 'action' => 'edit', $esCells->id], array('escape' => false, 'class' => 'label label-success action-pad')) . '</span>' ?>
                    <?= '<span data-toggle="tooltip" title="Delete">'. $this->Form->postLink('<span class="pad-action-glyph glyphicon glyphicon glyphicon-trash"></span> ', ['controller' => 'EsCells', 'action' => 'delete', $esCells->id], ['escape' => false, 'class' => 'label label-danger action-pad', 'confirm' => __('Are you sure you want to delete # {0}?', $esCells->id)]) . '</span>' ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
    <br><br>
    </div>

    <div class="horizontal-table table-responsive">
        <h4><?= __('Quality Control Testing') ?></h4>
        <table class="data-table table stripe order-column">
            <tr>
                <th><?= __('ID') ?></th>
                <th><?= __('ES Cell') ?></th>
                <th><?= __('Started') ?></th>
                <th><?= __('Finished') ?></th>
                <th><?= __('Pass') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($kompClonesDump->es_cells as $es_cell) {
                if (!empty($es_cell->quality_control)) {  ?>
            <tr>
                <td><?= $es_cell->quality_control->id ? $this->Html->link($es_cell->quality_control->id, ['controller' => 'qualityControls', 'action' => 'view', $es_cell->quality_control->id]) : '' ?></td>
                <td><?= $es_cell->id ? $this->Html->link($es_cell->id, ['controller' => 'esCells', 'action' => 'view', $es_cell->id]) : '' ?></td>
                <td><?= h($es_cell->quality_control->started_by) ?> <em><?= h($es_cell->quality_control->started) ?></em></td>
                <td><?= h($es_cell->quality_control->finished_by) ?> <em><?= h($es_cell->quality_control->finished) ?></em></td>
                <?php if ($es_cell->quality_control->pass == "Passed") { ?><td style="background-color:palegreen"> <?php } elseif ($es_cell->quality_control->pass == "Failed"){ ?><td style="background-color:#cc0000;color:#ffffff"> <?php } elseif ($es_cell->quality_control->pass == "Inconclusive"){ ?><td style="background-color:#ffff99"> <?php } else { ?><td>  <?php }; ?><?= h($es_cell->quality_control->pass) ?></td>
                <!-- <td><?= h($es_cell->quality0_control->pass) ?></td> -->
                <td class="actions">
                    <?= '<span data-toggle="tooltip" title="View">'. $this->Html->link('<span class="pad-action-glyph glyphicon glyphicon-eye-open"></span>', ['controller' => 'EsCells', 'action' => 'view', $esCells->id],  array('escape' => false, 'class' => 'label label-primary action-pad')) . '</span>' ?>
                    <?= '<span data-toggle="tooltip" title="Edit">'. $this->Html->link('<span class="pad-action-glyph glyphicon glyphicon-pencil"></span>', ['controller' => 'EsCells', 'action' => 'edit', $esCells->id], array('escape' => false, 'class' => 'label label-success action-pad')) . '</span>' ?>
                    <?= '<span data-toggle="tooltip" title="Delete">'. $this->Form->postLink('<span class="pad-action-glyph glyphicon glyphicon glyphicon-trash"></span> ', ['controller' => 'EsCells', 'action' => 'delete', $esCells->id], ['escape' => false, 'class' => 'label label-danger action-pad', 'confirm' => __('Are you sure you want to delete # {0}?', $esCells->id)]) . '</span>' ?>
                </td>
            </tr>
            <?php };}; ?>
        </table>
    </div>
    <br><br>

    <?php
    echo $this->Html->link('<span class="glyphicon glyphicon-plus"></span> ' . __('Add ES Cells to Clone'),
        [
        'controller' => 'InventoryVials',
        'action' => 'add',
        $kompClonesDump->id,
        'escell'
        ], array(
            'escape' => false,
            'class' => 'btn btn-success pad-button'
            ));     
?>
</div>

