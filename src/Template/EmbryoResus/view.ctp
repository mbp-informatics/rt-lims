<?php
    echo $this->Html->link('<span class="glyphicon glyphicon-pencil"></span> ' . __('Edit Embryo Resus'), ['controller' => 'EmbryoResus', 'action' => 'edit', $embryoResus->id], array('escape' => false, 'class' => 'btn btn-warning pull-right'));
?>
<?php $fromJob = $this->CustomForm->displayFromJobLabel(); ?>
<div class="embryoResus view large-9 medium-8 columns content">
    <h3><?= __('EmbryoResus')." #".h($embryoResus->id) ?></h3>
    <div class='alert alert-info' role='alert'>Embryo Resuscitation Info</div>
    <div class='container-fluid'>
        <div class='row'>
            <div class='col-xs-4'><strong><?= __('Job') ?>: </strong><?= $embryoResus->has('job') ? $this->Html->link($embryoResus->job->id, ['controller' => 'Jobs', 'action' => 'view', $embryoResus->job->id]) : '' ?></div>
            <div class='col-xs-4'><strong><?= __('Embryo Cryo') ?>: </strong><?= $embryoResus->has('embryo_cryo') ? $this->Html->link($embryoResus->embryo_cryo->id, ['controller' => 'EmbryoCryos', 'action' => 'view', $embryoResus->embryo_cryo->id]) : '' ?></div>
            <div class='col-xs-4'><strong><?= __('Cryo Date') ?>: </strong><?php if (isset($embryoResus->cryo_date)) { echo h($embryoResus->cryo_date->format('n/j/Y')); } ?></div>
        </div>
        
        <div class='row'>   
            <div class='col-xs-4'><strong><?= __('Investigator') ?>: </strong><?= h($embryoResus->investigator) ?></div>
            <div class='col-xs-4'><strong><?= __('Membership') ?>: </strong><?= h($embryoResus->membership) ?></div>
            <div class='col-xs-4'><strong><?= __('MMRRC ID') ?>: </strong><?= h(isset($embryoResus->job->mmrrc_no) ? $embryoResus->job->mmrrc_no : '') ?></div>
        </div>
        <div class='row'>   
            <div class='col-xs-4'><strong><?= __('Embryo Transfer') ?>: </strong><?php if ($embryoResus->has('embryo_transfers')) {
                foreach ($embryoResus->embryo_transfers as $transfer) {
                    echo $this->Html->link($transfer->id, ['controller' => 'EmbryoTransfers', 'action' => 'view', $transfer->id]);
                }
            }
            else { echo ''; } ?></div>
               <div class='col-xs-4'><strong><?= __('Investigator') ?>: </strong><?= h($embryoResus->pi) ?></div>
        </div>
        <hr>
        <div class='row'>   
            <div class='col-xs-4'><strong><?= __('Male Background') ?>: </strong><?= h(isset($embryoResus->job->background) ? $embryoResus->job->background : '-') ?></div>
            <div class='col-xs-4'><strong><?= __('Female Background') ?>: </strong><?= h(isset($embryoResus->embryo_cryo->female_strain_name) ? $embryoResus->embryo_cryo->female_strain_name : '-') ?></div>
            <div class='col-xs-4'><strong><?= __('KOMP Clone ID') ?>: </strong><?= h(isset($embryoResus->job->sc_tt_batch_no) ? $embryoResus->job->sc_tt_batch_no : '-') ?></div> 
        </div>
        
        <div class='row'>   
            <div class='col-xs-4'><strong><?= __('Strain') ?>: </strong><?= h($embryoResus->strain) ?></div>
            <div class='col-xs-4'><strong><?= __('Purpose') ?>: </strong><?= h($embryoResus->purpose) ?></div>
            <div class='col-xs-4'><strong><?= __('Freezing Medium Lot') ?>: </strong><?= h($embryoResus->freezing_medium_lot) ?></div>
        </div>
    </div>             
    <div class='alert alert-info' role='alert'>Recovery/Culture Info</div>
    <div class='container-fluid'>
        <div class='row'>
            <div class='col-xs-4'><strong><?= __('Thawing Date') ?>: </strong><?php if (isset($embryoResus->thawing_date)) { echo h($embryoResus->thawing_date->format('n/j/Y')); } ?></div>
            <div class='col-xs-4'><strong><?= __('Thawing Time') ?>: </strong><?php if (isset($embryoResus->thawing_time)) { echo h($embryoResus->thawing_time->format('g:i A')); } ?></div>
            <div class='col-xs-4'><strong><?= __('Thawed By') ?>: </strong><?= h($embryoResus->thawed_by) ?></div>
        </div>
        
        <div class='row'> 
            <div class='col-xs-3'><strong><?= __('Straw #') ?>: </strong><?= h($embryoResus->straw_no) ?></div>
            <div class='col-xs-2'><strong><?= __('Tank') ?>: </strong><?= h($embryoResus->tank) ?></div>
            <div class='col-xs-2'><strong><?= __('Rack') ?>: </strong><?= h($embryoResus->rack) ?></div>
            <div class='col-xs-2'><strong><?= __('Box') ?>: </strong><?= h($embryoResus->box) ?></div>
            <div class='col-xs-2'><strong><?= __('Space') ?>: </strong><?= h($embryoResus->space) ?></div>
        </div>
        
        <div class='row'>             
            <div class='col-xs-3'><strong><?= __('Embryo Stage') ?>: </strong><?= h($embryoResus->embryo_stage) ?></div>            
            <div class='col-xs-2'><strong><?= __('# Embryos') ?>: </strong><?= h($embryoResus->embryos_no) ?></div>
            <div class='col-xs-2'><strong><?= __('# Recovered') ?>: </strong><?= h($embryoResus->recovered_no) ?></div>
            <div class='col-xs-2'><strong><?= __('# Intact') ?>: </strong><?= h($embryoResus->intact_no) ?></div>
            <div class='col-xs-2'><strong><?= __('# Bad Lysed') ?>: </strong><?= h($embryoResus->bad_lysed_no) ?></div>
        </div>
        
        <div class='row'> 
            <div class='col-xs-3'><strong><?= __('# Cultured') ?>: </strong><?= h($embryoResus->cultured_no) ?></div>
            <div class='col-xs-3'><strong><?= __('# Morulae') ?>: </strong><?= h($embryoResus->morulae_no) ?></div>
            <div class='col-xs-3'><strong><?= __('# Blastocysts') ?>: </strong><?= h($embryoResus->blastocysts_no) ?></div>
        </div>
        
        <div class='row'> 
            <?php if ($embryoResus->space < 50) { ?> <div class='alert alert-danger col-xs-3'> <?php } else { ?> <div class='alert alert-success col-xs-3'> <?php }; ?>
                <?= __('Blastocyst Rate (%)') ?>: <?= $this->Number->format($embryoResus->blastocyst_rate) ?>
            </div>
        </div>
        <div class='row'>         
            <div class='col-xs-12'><strong><?= __('Comments') ?>: </strong><?= h($embryoResus->comments) ?></div>
        </div>
    </div>
    <div class='alert alert-info' role='alert'>Meta</div>
    <div class='container-fluid'>
        <div class='row'>
           <div class='col-xs-4'><strong><?= __('Created') ?>: </strong><?= h($embryoResus->created) ?></div>
           <div class='col-xs-4'><strong><?= __('Modified') ?>: </strong><?= h($embryoResus->modified) ?></div>
        </div>
    </div>           
</div>
<br/>
<?php
 echo $this->Html->link('' . __('Go back'), ['controller' => 'Jobs', 'action' => 'view', $embryoResus->job_id, '#' => 'related-data'], array(
        'escape' => false,
        'class' => 'btn btn-default',
        'style' => 'margin-left:10px'

    ));
?>

<div class="clearfix"></div>
<?= $this->ChangeLog->displayChangeLog($changes) ?>