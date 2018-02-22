<?php $fromJob = $this->CustomForm->displayFromJobLabel(); ?>
<?php
    echo $this->Html->link('<span class="glyphicon glyphicon-pencil"></span> ' . __('Edit Sperm Cryo'), ['controller' => 'SpermCryos', 'action' => 'edit', $spermCryo->id], array('escape' => false, 'class' => 'btn btn-warning pull-right'));
?>
<div class="spermCryos view large-9 medium-8 columns content">
    <h3><?= __('SpermCryo')." #".h($spermCryo->id) ?></h3>
    <div class='alert alert-info' role='alert'>Sperm Cryo Info</div>
    <div class='container-fluid'>
        <?php 
        if ($spermCryo->distribute_status == "Do Not Distribute") {
                echo "<p style='color:red'><strong>DO NOT DISTRIBUTE</strong></p>";
            } elseif ($spermCryo->distribute_status == "Do Not Distribute- Internal Use Only") {
                echo "<p style='color:red'><strong>DO NOT DISTRIBUTE - INTERNAL USE ONLY</strong></p>";
            } 
        ?>   
        <div class='row'>
            <div class='col-xs-3'><strong><?= __('SC#') ?>: </strong><?= h($spermCryo->id) ?></div>
            <div class='col-xs-3'><strong><?= __('Job ID') ?>: </strong><?=  $this->Html->link($spermCryo->job_id, ['controller' => 'Jobs', 'action' => 'view', $spermCryo->job_id]) ?></div>
            <?php
            $tmpCryoDate = '';
            if (isset($spermCryo->cryo_date)) {
              $tmpCryoDate = $spermCryo->cryo_date->format('Y-m-d');
            } ?> 
            <div class='col-xs-3'><strong><?= __('Cryo Date') ?>: </strong><?= $tmpCryoDate ?></div>
            <!-- <div class='col-xs-3'><strong><?= __('Cryo Date') ?>: </strong><?php if (isset($spermCryo->cryo_date)) { $spermCryo->cryo_date->format('n/j/Y'); } else { echo '-'; } ?></div> -->
            <?php
            $tmpValue = '';
            if (isset($spermCryo->job)) {
              $tmpValue = $spermCryo->job->esc_clone_id_no;
            } ?> 
            <div class='col-xs-3'><strong><?= __('Clone ID') ?>: </strong><?= $tmpValue ?></div>
        </div>
        
        <div class='row'>
            <?php
            $tmpValue = '';
            if (isset($spermCryo->job)) {
              $tmpValue = $spermCryo->job->background;
            } ?> 
            <div class='col-xs-3'><strong><?= __('Background') ?>: </strong><?= $tmpValue ?></div>
            <?php
            $tmpValue = '';
            if (isset($spermCryo->job)) {
              $tmpValue = $spermCryo->job->mmrrc_no;
            } ?> 
            <div class='col-xs-3'><strong><?= __('MMRRC No') ?>: </strong><?= $tmpValue ?></div>
            <div class='col-xs-3'><strong><?= __('PI Name') ?>: </strong><?= $spermCryo->pi_first_name ?> <?= $spermCryo->pi_last_name ?></div>
            <div class='col-xs-3'><strong><?= __('Distribution Comments') ?>: </strong><?= h($spermCryo->distribute_comment) ?></div>
        </div>

    <div class='row'>
        <div class='col-xs-3'>
            <strong><?= __('Investigator') ?>: </strong><?= h($spermCryo->pi) ?>
        </div>
    </div>
    
    </div>
    <div class='alert alert-info' role='alert'>Donor Info</div>
    <div class='container-fluid'>
        <div class='row'>
            <?php
            $tmpValue = '';
            if (isset($spermCryo->job)) {
              $tmpValue = $spermCryo->job->strain_name;
            } ?> 
            <div class='col-xs-3'><strong><?= __('Strain Name') ?>: </strong><?= $tmpValue ?></div>
<!--             <?php
            $tmpValue = '';
            if (isset($spermCryo->job)) {
              $tmpValue = $spermCryo->job->genotype;
            } ?>  -->
            <div class='col-xs-3'><strong><?= __('Genotype') ?>: </strong><?= h($spermCryo->donor_genotype) ?></div>
            <div class='col-xs-3'><strong><?= __('Donor ID') ?>: </strong><?= h($spermCryo->donor_id_no) ?></div>
        </div>
        
        <div class='row'>
            <?php
              $tmpDate = '';
              if (isset($spermCryo->geno_date)) {
              $tmpDate = $spermCryo->geno_date->format('Y-m-d');
            } ?>
            <div class='col-xs-3'><strong><?= __('Genotype Date') ?>: </strong><?= $tmpDate; ?></div>
            <div class='col-xs-3'><strong><?= __('Genotyped By') ?>: </strong><?= h($spermCryo->geno_by) ?></div>
            <div class='col-xs-3'><strong><?= __('Donor Genotype Confirmed') ?>: </strong><?= $spermCryo->donor_genotype_confirmed ? __('<span class="bool-yes glyphicon glyphicon-ok"> Yes</span>') : __('<span class="bool-no glyphicon glyphicon-remove"> No</span>'); ?></div>           
            <div class='col-xs-3'><strong><?= __('Incorrect Genotype') ?>: </strong><?= $spermCryo->incorrect_genotype ? __('<span class="glyphicon glyphicon-ok" style="color:red"> Yes</span>') : __('<span class="bool-no glyphicon glyphicon-remove" style="color:green"> No</span>'); ?></div>           
        </div>
        <div class='row'>
            <?php
              $tmpDate = '';
              if (isset($spermCryo->donor_dob)) {
              $tmpDate = $spermCryo->donor_dob->format('Y-m-d');
            } ?> 
            <div class='col-xs-3'><strong><?= __('Donor DOB') ?>: </strong><?= $tmpDate; ?></div>
            <div class='col-xs-3'><strong><?= __('Donor Age (weeks)') ?>: </strong><?= h($spermCryo->donor_age) ?></div>
        </div>        
        <div class='row'>
            <div class='col-xs-12'><strong><?= __('Donor Comments') ?>: </strong><?= h($spermCryo->donor_comments) ?></div>
        </div>
        <hr>
        <div class='row'>
            <div class='col-xs-3'><strong><?= __('Sperm TaqMan') ?>: </strong><?= $spermCryo->sperm_taqman ?></div>
            <?php
              $tmpDate = '';
              if (isset($spermCryo->taqman_date)) {
              $tmpDate = $spermCryo->taqman_date->format('Y-m-d');
            } ?> 
            <div class='col-xs-3'><strong><?= __('TaqMan Date') ?>: </strong><?= $tmpDate; ?></div>
            <div class='col-xs-3'><strong><?= __('TaqMan By') ?>: </strong><?= h($spermCryo->taqman_by) ?></div>
            <div class='col-xs-3'><strong><?= __('PCR Results') ?>: </strong><?= h($spermCryo->pcr_results) ?></div>
        </div>
        
        <div class='row'>
            <div class='col-xs-3'><strong><?= __('Targeted Status') ?>: </strong><?= h($spermCryo->targeted_status) ?></div>
            <?php
              $tmpDate = '';
              if (isset($spermCryo->targeted_confirmed_date)) {
              $tmpDate = $spermCryo->targeted_confirmed_date->format('Y-m-d');
            } ?> 
            <div class='col-xs-3'><strong><?= __('Targeted Confirmed Date') ?>: </strong><?= $tmpDate; ?></div>
            <div class='col-xs-3'><strong><?= __('Targeted Confirmed By') ?>: </strong><?= h($spermCryo->targeting_confirmed_by) ?></div>
        </div>
        

    </div>
    <div class='alert alert-info' role='alert'>Cryo Info</div>
    
    <div class='container-fluid'>
        <div class='row'>
            <div class='col-xs-2'></div>
            <div class='col-xs-8'>
                <div class="panel panel-info">
                    <div class="panel-heading"><strong>Sperm Parameters</strong></div>
                    <div class="panel-body">
                        <div class='container-fluid'>
                            <div class='row'>
                                <div class='col-xs-5'></div>
                                <div class='col-xs-3'><strong>Pre-Freeze</strong></div>
                                <div class='col-xs-3'><strong>Post-Thaw</strong></div>
                            </div>
                            <div class='row'>
                                <div class='col-xs-5'><strong>Sperm Concentration (M/ml)</strong></div>
                                <div class='col-xs-3'><?= $spermCryo->cryo_sperm_conc ?></div>
                                <div class='col-xs-3'><?= $spermCryo->post_sperm_conc ?></div>
                            </div>
                            <div class='row'>
                                <div class='col-xs-5'><strong>Total Motility</strong></div>                    
                                <div class='col-xs-3'><?= $spermCryo->cryo_total_motility ?>%</div>
                                <div class='col-xs-3'><?= $spermCryo->post_total_motility ?>%</div>
                            </div>
                            <div class='row'>
                                <div class='col-xs-5'><strong>Rapid Motility</strong></div>                       
                                <div class='col-xs-3'><?= $spermCryo->cryo_rapid_motility ?>%</div>
                                <div class='col-xs-3'><?= $spermCryo->post_rapid_motility ?>%</div>
                            </div>
                            <div class='row'>
                                <div class='col-xs-5'><strong>Progressive Motility</strong></div>                     
                                <div class='col-xs-3'><?= $spermCryo->cryo_prog_motility ?>%</div>
                                <div class='col-xs-3'><?= $spermCryo->post_prog_motility ?>%</div>
                            </div>
                            <hr>
                            <div class='row'>
                                <div class='col-xs-4'><strong><em>Sperm Morphology:</em></strong></div>
                            </div>
                            <br/>
                            <div class='row'>
                                <div class='col-xs-4'><strong><?= __('Abnormal Heads') ?>: </strong><?= $spermCryo->cryo_abnormal_heads ?>%</div>
                                <div class='col-xs-4'><strong><?= __('Abnormal Tails') ?>: </strong><?= $spermCryo->cryo_abnormal_tails ?>%</div>
                                <div class='col-xs-4'><strong><?= __('LN2 Vapor Temperature (C)') ?>: </strong><?= $spermCryo->vapor_temperature ?></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class='col-xs-2'></div>
        </div>
        <div class='row'>
            <div class='col-xs-4'><strong><?= __('Sample Type') ?>: </strong><?= h($spermCryo->cryo_sample_type) ?></div>
            <div class='col-xs-4'><strong><?= __('Cryo Method') ?>: </strong><?= h($spermCryo->cryo_method) ?></div>
            <div class='col-xs-4'><strong><?= __('Caps/Label Color') ?>: </strong><?= h($spermCryo->cryo_caps_label_color) ?></div>
        </div>
        
        <div class='row'>
            <div class='col-xs-4'><strong><?= __('Cryo Medium') ?>: </strong><?= h($spermCryo->cryo_medium) ?></div>
            <div class='col-xs-4'><strong><?= __('CPM Lot No') ?>: </strong><?= $spermCryo->cryo_cpm_lot_no ?></div>
            <div class='col-xs-4'><strong><?= __('CPM mOsm') ?>: </strong><?= $spermCryo->cryo_mosm ?></div>
        </div>
        
        <div class='row'>
            <div class='col-xs-4'><strong><?= __('Sperm Analyser') ?>: </strong><?= h($spermCryo->cryo_sperm_analyser) ?></div>
            <div class='col-xs-4'><strong><?= __('Sperm Scored By') ?>: </strong><?= h($spermCryo->cryo_scored_by) ?></div>
            <div class='col-xs-4'><strong><?= __('Sperm Collected By') ?>: </strong><?= h($spermCryo->cryo_collected_by) ?></div>
        </div>
        
        <div class='row'>
            <div class='col-xs-4'><strong><?= __('SC Performed By') ?>: </strong><?= h($spermCryo->cryo_sc_performed_by) ?></div>
            <div class='col-xs-4'><strong><?= __('Cryo Data Entry By') ?>: </strong><?= $spermCryo->has('user') ? $this->Html->link($spermCryo->user->name, ['controller' => 'Users', 'action' => 'view', $spermCryo->user->id]) : '' ?></div>          
        </div>
<?php if (empty($allVials))  { ?>         
        <div class='row'>
            <div class='col-xs-12'><strong><?= __('Cryo Comments') ?>: </strong><?= h($spermCryo->cryo_comments) ?></div>
        </div>
        <div class='row'>
            <div class='col-xs-12'><strong><?= __('Additional Storage Comments') ?>: </strong><?= h($spermCryo->storage_comments) ?></div>
        </div>
<?php } ?>
    </div>
    <div class='alert alert-info' role='alert'>Meta</div>
    <div class='container-fluid'>
        <div class='row'>
            <div class='col-xs-3'><strong><?= __('Created') ?>: </strong><?php if (isset($spermCryo->created)) { h(date_format($spermCryo->created, 'Y-m-d')); } ?></div>
            <div class='col-xs-3'><strong><?= __('Modified') ?>: </strong><?php if (isset($spermCryo->modified)) { h(date_format($spermCryo->modified, 'Y-m-d')); } ?></div>
        </div>
    </div>
    <br/>
</div>
<style>
    td, th { text-align:center; }
</style>
<?php if (!empty($allVials))  { ?> 
<!-- count number of inventory vials that aren't tissue -->
    <div class='alert alert-info' role='alert'>Freezer Inventory (<?php if (!empty($spermCryo->inventory_vials)){
                    $samplesCount = 0;
                    foreach ($spermCryo->inventory_vials as $vial) {
                        if ($vial->tissue != 1 && $vial->do_not_distribute != 1) {
                            $samplesCount += 1;
                        }
                        }
                            echo $samplesCount;
                        } else {
                            echo '0';
                        } ?>)</div>
<?php } ?>
<?php 
if ($spermCryo->distribute_status == "Do Not Distribute") {
        echo "<p style='color:red'><strong>DO NOT DISTRIBUTE</strong></p>";
    } elseif ($spermCryo->distribute_status == "Do Not Distribute- Internal Use Only") {
        echo "<p style='color:red'><strong>DO NOT DISTRIBUTE - INTERNAL USE ONLY</strong></p>";
    } 
?> 

<?php if (!empty($allVials)): ?>
        <?php if ($spermCryo->verified){ ?>
            <div class='row'>
                <div class='col-xs-12'><p style='color:red'>Verified by <?php echo $userName ?> on <?= h(date_format(date_create($spermCryo->verified_time), 'Y-m-d')) ?></p></div>
            </div>
        <?php } else { 
            echo $this->Html->link('<span class="glyphicon glyphicon-ok"></span> ' . __('Verify'),
                [
                'controller' => 'SpermCryos',
                'action' => 'verify',
                $spermCryo->id,
                $this->request->session()->read('Auth.User.id')
                ], array(
                    'escape' => false,
                    'class' => 'btn btn-danger',
                    'formmethod' => 'post'
                    ));    
         } ?>
    <h4><?= __('<span class="glyphicon glyphicon-hand-right"></span> Sperm') ?><span class="badge" data-toggle="tooltip" title="Press and hold shift to sort multiple columns.">?</span></h4>
    <div class='container-fluid'>

        <div class='row'>
            <div class='col-xs-12'><strong><?= __('Cryo Comments') ?>: </strong><?= h($spermCryo->cryo_comments) ?></div>
        </div>
        <div class='row'>
            <div class='col-xs-12'><strong><?= __('Additional Storage Comments') ?>: </strong><?= h($spermCryo->storage_comments) ?></div>
        </div>
    </div><br/>
    <div class="horizontal-table table-responsive">
        <table id='all-vials' class="table stripe" data-page-length='25'>
        <thead>
            <tr>
                <th><?= __('Label') ?></th>
                <th><?= __('Sample Vol (μl)') ?></th>
                <th><?= __('Box Hierarchy') ?></th>
                <th><?= __('Space/Cane') ?></th>
                <th><?= __('Tissue?') ?></th>
                <th><?= __('Distribute?') ?></th>
                <th><?= __('Vial Comment') ?></th>
                <th><?= __('Thaw/Ship Date') ?></th>
                <th><?= __('Thaw/Ship Info') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>

        <?php
        // Insert box/contaier hierarchy string into the array
        foreach ($allVials as &$vial) {
            $vial->box_hierarchy = $this->customForm->getContainerHierarchy($vial['parent_containers']);
        }
        unset($vial); //do this to prevent funny behaviour with the following foreach...
        
        // Sort the array by multiple fields
        foreach ($allVials as $key => $row) {
            $label[$key]  = $row['label'];
            // $boxHierarchy[$key]  = $row['box_hierarchy'];
            $spaceId[$key]  = $row['inventory_location']['cell'];
        }
        array_multisort($label, SORT_ASC, $spaceId, SORT_ASC, $allVials);
        ?>

        <?php foreach ($allVials as $vial): ?>
            <tr>
                <td><?php if(isset($vial->ship_thaw_reason) || isset($vial->ship_thaw_date)) { ?><a href="/inventory-shipped-vials/view/<?= $vial->id ?>"> <?php } else { ?><a href="/inventory-vials/view/<?= $vial->id ?>"><?php } ?><?= h($vial->label) ?></a></td>
                <td><?= h($vial->volume) ?></td>
                <td>
                    <?php
                     if (isset($vial->box_hierarchy)) { ?>
                        <a href="/inventory-boxes/view/<?= h($vial->inventory_location->inventory_box->id) ?>">
                        <?= str_replace(' ', '&nbsp;', $vial->box_hierarchy) ?></a> 
                    <?php } elseif(isset($vial->ship_thaw_reason) || isset($vial->ship_thaw_date)) { //shipped vial
                         echo '<span style="color:#aaa"><em>Removed... </em><i class="fa fa-truck fa-flip-horizontal"></i></span>';
                     } else { //vial with no location but not shipped
                        echo '-';
                     } ?>
                </td>
                <td><?= isset($vial->inventory_location->cell) ? h($vial->inventory_location->cell) : '-' ?></td>
                <td><?= $vial->tissue ? __('<span class="bool-yes glyphicon glyphicon-ok"> Yes</span>') : __('<span class="bool-no glyphicon glyphicon-remove"> No</span>'); ?></td>
                <td><?= $vial->do_not_distribute ? __('<span class="bool-no glyphicon glyphicon-remove"> No</span>') : __('<span class="bool-yes glyphicon glyphicon-ok"> Yes</span>'); ?></td>
                <td><em><?= h($vial->comments) ?></em></td>
                <td><?= isset($vial->ship_thaw_date) ? $vial->ship_thaw_date->format('n/j/y') : '-' ?></td>
                <td><strong><?= isset($vial->ship_thaw_reason) ? $vial->ship_thaw_reason : '-' ?></strong></td>                
                <td class="actions">
                    <?php $controllerName = isset($vial->ship_thaw_date) || isset($vial->ship_thaw_reason) ? 'inventoryShippedVials' : 'inventoryVials'; ?>
                    <?= '<span data-toggle="tooltip" title="View">'. $this->Html->link('<span class="pad-action-glyph glyphicon glyphicon-eye-open"></span>', ['action' => 'view', 'controller'=>$controllerName, $vial->id],  array('escape' => false, 'class' => 'label label-primary action-pad')) . '</span>' ?>
                    <?= '<span data-toggle="tooltip" title="Delete Vial">'. $this->Form->postLink('<span class="pad-action-glyph glyphicon glyphicon glyphicon-trash"></span> ', ['controller' => $controllerName ,'action' => 'delete', $vial->id, 'sperm', $vial->sperm_cryo_id], ['escape' => false, 'class' => 'label label-danger action-pad', 'confirm' => __('Are you sure you want to delete Vial Id# {0}?', $vial->id)]) . '</span>' ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
        </table>
        </div>
    <?php endif; ?>
<br/>

<?php
    echo $this->Html->link('' . __('Go back'), ['controller' => 'Jobs', 'action' => 'view', $spermCryo->job_id, '#' => 'related-data'], array(
            'escape' => false,
            'class' => 'btn btn-default pad-button'
    ));

    echo $this->Html->link('<span class="glyphicon glyphicon-plus"></span> ' . __('Add Vials to SC'),
        [
        'controller' => 'InventoryVials',
        'action' => 'add',
        $spermCryo->id,
        'sperm'
        ], array(
            'escape' => false,
            'class' => 'btn btn-success pad-button'
            ));    
?>
<script>
$(document).ready( function () {
  $('#all-vials').dataTable({
    "ordering": true,
    "orderMulti": true, //enable multiple column ordering (SHIFT+click table column name)
    "aaSorting": [] //no sorting on table load
    //"iDisplayLength": -1 //how many entries to display on table load
  });
});
</script>

<div class="clearfix"></div>
<?= $this->ChangeLog->displayChangeLog($changes) ?>