<?php
    echo $this->Html->link('<span class="glyphicon glyphicon-pencil"></span> ' . __('Edit Embryo Cryo'), ['controller' => 'EmbryoCryos', 'action' => 'edit', $embryoCryo->id], array('escape' => false, 'class' => 'btn btn-warning pull-right'));
?>
<?php $fromJob = $this->CustomForm->displayFromJobLabel(); ?>
<div class="embryoCryos view large-9 medium-8 columns content">
    <h3><?= __('EmbryoCryo')." #".h($embryoCryo->id) ?></h3>
    <div class='alert alert-info' role='alert'>Embryo Cryo Info</div>
    <div class='container-fluid'>
        <div class='row'>
            <?php 
            if ($embryoCryo->distribute_status == "Do Not Distribute") {
                    echo "<p style='color:red'><strong>DO NOT DISTRIBUTE</strong></p>";
                } elseif ($embryoCryo->distribute_status == "Do Not Distribute- Internal Use Only") {
                    echo "<p style='color:red'><strong>DO NOT DISTRIBUTE - INTERNAL USE ONLY</strong></p>";
                } 
            ?>   
            <br/>   
            <div class='col-xs-4'><strong><?= __('Job ID') ?>: </strong><?=  $this->Html->link($embryoCryo->job_id, ['controller' => 'Jobs', 'action' => 'view', $embryoCryo->job_id]) ?></div>
            <div class='col-xs-4'><strong><?= __('IVF ID') ?>: </strong><?=  $this->Html->link($embryoCryo->ivf_id, ['controller' => 'Ivfs', 'action' => 'view', $embryoCryo->ivf_id]) ?></div>
            <div class='col-xs-4'><strong><?= __('Cryo Date') ?>: </strong><?php if (isset($embryoCryo->cryo_date)) { echo h($embryoCryo->cryo_date->format('n/j/Y')); } ?></div>
        </div>
        
        <div class='row'>
            <div class='col-xs-4'><strong><?= __('Job Strain Name') ?>: </strong><?= isset($embryoCryo->job->strain_name) ? h($embryoCryo->job->strain_name) : '' ?></div>
            <div class='col-xs-4'><strong><?= __('KOMP Clone ID') ?>: </strong><?= isset($embryoCryo->job->esc_clone_id_no) ? h($embryoCryo->job->esc_clone_id_no) : '' ?></div>
            <div class='col-xs-4'><strong><?= __('Distribution Comments') ?>: </strong><?= h($embryoCryo->distribute_comment) ?></div>
        </div>
        <div class='row'>
            <div class='col-xs-4'><strong><?= __('Investigator') ?>: </strong><?= h($embryoCryo->pi) ?></div>
            <div class='col-xs-4'><strong><?= __('MMRRC Stock #') ?>: </strong><?php if (isset($embryoCryo->job_id)) { echo h($embryoCryo->job->mmrrc_no); } ?></div>
        </div>
    </div>
    <div class='alert alert-info' role='alert'>Donor info</div>
    <div class='container-fluid'>
        <div class='row'>  
            <div class='col-xs-6'><strong><?= __('Male Genotype') ?>: </strong><?= h($embryoCryo->male_genotype) ?></div>
            <div class='col-xs-6'><strong><?= __('Male Strain Name') ?>: </strong><?= h($embryoCryo->stud_strain) ?></div>
        </div>
        <div class='row'>
            <div class='col-xs-3'><strong><?= __('Male Genetic Background') ?>: </strong><?= h($embryoCryo->background) ?></div>            
            <div class='col-xs-3'><strong><?= __('Stud DOB') ?>: </strong><?php if (isset($embryoCryo->stud_dob)) { echo h($embryoCryo->stud_dob->format('n/j/Y')); } ?></div>
            <div class='col-xs-3'><strong><?= __('Stud ID') ?>: </strong><?= h($embryoCryo->stud_id_no) ?></div>
        </div>
        
        <div class='row'>  
            <div class='col-xs-6'><strong><?= __('Female Genotype') ?>: </strong><?= h($embryoCryo->female_genotype) ?></div>
            <div class='col-xs-6'><strong><?= __('Female Strain Name') ?>: </strong><?= h($embryoCryo->female_strain_name) ?></div>
        </div>
        
        <div class='row'>            
            <div class='col-xs-3'><strong><?= __('No. of females Used') ?>: </strong><?= h($embryoCryo->no_females_used) ?></div>
            <div class='col-xs-3'><strong><?= __('Female Age') ?>: </strong><?= h($embryoCryo->female_age) ?></div>
        </div>
        
        <div class='row'>           
            <div class='col-xs-3'><strong><?= __('Genotype Confirmed') ?>: </strong><?= $embryoCryo->genotype_confirmed ? __('<span class="bool-yes glyphicon glyphicon-ok"> Yes</span>') : __('<span class="bool-no glyphicon glyphicon-remove"> No</span>'); ?></div>
            <div class='col-xs-3'><strong><?= __('Donor Genotyping Date') ?>: </strong><?php if (isset($embryoCryo->donor_genotyping_date)) { echo h($embryoCryo->donor_genotyping_date->format('n/j/Y')); } ?></div>
            <div class='col-xs-3'><strong><?= __('Donor Genotyped By') ?>: </strong><?= h($embryoCryo->donor_genotyped_by) ?></div>          
        </div>
        
        <div class='row'> 
            <div class='col-xs-12'><strong><?= __('Donor Genotype Comments') ?>: </strong><?= h($embryoCryo->donor_genotype_comments) ?></div>
        </div>
    </div>
    <div class='alert alert-info' role='alert'>Cryo info</div>
    <div class='container-fluid'>
        <div class='row'>
            <div class='col-xs-4'><strong><?= __('Fert Method') ?>: </strong><?= h($embryoCryo->fert_method) ?></div>
            <div class='col-xs-4'><strong><?= __('EC Method') ?>: </strong><?= h($embryoCryo->ec_method) ?></div>
            <div class='col-xs-4'><strong><?= __('IVF By') ?>: </strong><?= h($embryoCryo->ivf_by) ?></div>
        </div>
        
        <div class='row'>              
            <div class='col-xs-4'><strong><?= __('EC By') ?>: </strong><?= h($embryoCryo->ec_by) ?></div>
            <div class='col-xs-4'><strong><?= __('Cryo Embryo Stage') ?>: </strong><?= h($embryoCryo->cryo_embryo_stage) ?></div>
            <div class='col-xs-4'><strong><?= __('EC Media Lot') ?>: </strong><?= h($embryoCryo->ec_media_lot) ?></div>
        </div>
        
        <div class='row'>             
            <div class='col-xs-4'><strong><?= __('Label Color') ?>: </strong><?= h($embryoCryo->label_color) ?><span class="coat-color" style="background-color:<?= h($embryoCryo->label_color) ?>"></span></div>      
            <div class='col-xs-4'><strong><?= __('BioCool ID') ?>: </strong><?= h($embryoCryo->biocool_id_no) ?></div>
            <div class='col-xs-4'><strong><?= __('PROH Time (min)') ?>: </strong><?= h($embryoCryo->proh_time_min) ?></div>
        </div>
        
        <div class='row'>              
            <div class='col-xs-3'><strong><?= __('Start Temp') ?>: </strong><?= h($embryoCryo->start_temp) ?></div>
            <div class='col-xs-3'><strong><?= __('Start Time') ?>: </strong><?php if (isset($embryoCryo->start_time)) { echo h($embryoCryo->start_time->format('g:i A')); } ?></div>
            <div class='col-xs-3'><strong><?= __('End Temp') ?>: </strong><?= h($embryoCryo->end_temp) ?></div>
            <div class='col-xs-3'><strong><?= __('End Time') ?>: </strong><?php if (isset($embryoCryo->end_time)) { echo h($embryoCryo->end_time->format('g:i A')); } ?></div>
        </div>
        
        <div class='row'>              
            <div class='col-xs-4'><strong><?= __('Time Hold At End Temp (min)') ?>: </strong><?= h($embryoCryo->time_hold_at_end_temp) ?></div>
            <div class='col-xs-8'><strong><?= __('Cryo Info Comments') ?>: </strong><?= h($embryoCryo->cryo_info_comments) ?></div>
        </div>
    </div>
    <div class='alert alert-info' role='alert'>EC Test Thaw QC</div>
    <div class='container-fluid'>
        <div class='row'>
            <div class='col-xs-4'><strong><?= __('Blast Genotype') ?>: </strong><?= h($embryoCryo->blast_genotype) ?></div>
            <div class='col-xs-4'><strong><?= __('EmbryoGeno Confirmed') ?>: </strong><?= $embryoCryo->embryogeno_confirmed ? __('<span class="bool-yes glyphicon glyphicon-ok"> Yes</span>') : __('<span class="bool-no glyphicon glyphicon-remove"> No</span>'); ?></div>
            <div class='col-xs-4'><strong><?= __('EC Test Genotyped By') ?>: </strong><?= h($embryoCryo->ec_test_genotyped_by) ?></div>
        </div>
        
        <div class='row'>    
            <div class='col-xs-4'><strong><?= __('EmbryoGeno Date') ?>: </strong><?php if (isset($embryoCryo->embryo_geno_date)) { echo h($embryoCryo->embryo_geno_date->format('n/j/Y')); } ?></div>
            <div class='col-xs-8'><strong><?= __('Embryo Genotype Notes') ?>: </strong><?= h($embryoCryo->embryo_genotype_notes) ?></div>
            
        </div>
        
        <div class='row'>   
            <div class='col-xs-4'><strong><?= __('Thawing Date') ?>: </strong><?php if (isset($embryoCryo->thawing_date)) { echo h($embryoCryo->thawing_date->format('n/j/Y')); } ?></div> 
            <div class='col-xs-4'><strong><?= __('Straw ID') ?>: </strong><?= h($embryoCryo->straw_id_no) ?></div>
            <div class='col-xs-4'><strong><?= __('Incubator No') ?>: </strong><?= h($embryoCryo->incubator_no) ?></div>
        </div>
        
        <div class='row'>    
            <div class='col-xs-4'><strong><?= __('Culture Medium') ?>: </strong><?= h($embryoCryo->culture_medium) ?></div>
            <div class='col-xs-4'><strong><?= __('Culture Medium Lot') ?>: </strong><?= h($embryoCryo->culture_medium_lot) ?></div>
            <div class='col-xs-4'><strong><?= __('Cultured By') ?>: </strong><?= h($embryoCryo->cultured_by) ?></div>
        </div>
        
        <div class='row'>               
            <div class='col-xs-12'><strong><?= __('EC Test Thaw Comments') ?>: </strong><?= h($embryoCryo->ec_test_thaw_comments) ?></div>
        </div>
        <hr>
        <div class='row'>    
            <div class='col-xs-2'><strong><?= __('# Recovered') ?>: </strong><?= h($embryoCryo->recovered_no) ?></div>
            <div class='col-xs-2'><strong><?= __('# Intact') ?>: </strong><?= h($embryoCryo->intact_no) ?></div>
            <div class='col-xs-2'><strong><?= __('# Cultured') ?>: </strong><?= h($embryoCryo->cultured_no) ?></div>
            <div class='col-xs-2'><strong><?= __('# Blasts') ?>: </strong><?= h($embryoCryo->blasts_no) ?></div>
            <div class='col-xs-2'><strong><?= __('Blast Rate') ?>: </strong><?php
             if (isset($embryoCryo->blasts_no) && isset($embryoCryo->cultured_no) ) {
                if ($embryoCryo->cultured_no > 0) {
                    echo number_format( ($embryoCryo->blasts_no / $embryoCryo->cultured_no)*100,2) . '%';

                }
            }            
             ?></div>
        </div>
    </div>
    <div class='alert alert-info' role='alert'>Meta</div>
    <div class='container-fluid'>
        <div class='row'>
            <div class='col-xs-3'><strong>User:</strong>
            <?php
             if (isset($embryoCryo->user)) {
                echo $this->Html->link($embryoCryo->user->name, ['controller' => 'Users', 'action' => 'view', $embryoCryo->user->id]);
            } ?></div>
            <div class='col-xs-3'><strong><?= __('ID') ?>: </strong><?= h($embryoCryo->id) ?></div>
            <div class='col-xs-3'><strong><?= __('Created') ?>: </strong><?= h($embryoCryo->created) ?></div>
            <div class='col-xs-3'><strong><?= __('Modified') ?>: </strong><?= h($embryoCryo->modified) ?></div>
         </div>
    </div>      
    <br>     
<?php if ( !empty($allVials) ) { ?>
    <div class='alert alert-info' role='alert'>Freezer Inventory, <?php if (!empty($embryoCryo->inventory_vials)){
                            $samplesCount = count($embryoCryo->inventory_vials);
                            echo $samplesCount;
                        } else {
                            echo '0';
                        } ?> Straws (<?php if (!empty($embryoCryo->inventory_vials)){
                    $embryoCount = 0;
                    foreach ($embryoCryo->inventory_vials as $vial) {
                        if ($vial->volume && $vial->do_not_distribute != 1) {
                            $embryoCount += $vial->volume;
                        }
                        }
                            echo $embryoCount;
                        } else {
                            echo '0';
                        } ?>)</div>
<?php } ?>

<?php 
if ($embryoCryo->distribute_status == "Do Not Distribute") {
        echo "<p style='color:red'><strong>DO NOT DISTRIBUTE</strong></p>";
    } elseif ($embryoCryo->distribute_status == "Do Not Distribute- Internal Use Only") {
        echo "<p style='color:red'><strong>DO NOT DISTRIBUTE - INTERNAL USE ONLY</strong></p>";
    } 
?>  
            
<?php if (!empty($allVials)): ?>
    <div><strong><?= __('Cryo Info Comments') ?>: </strong><?= h($embryoCryo->cryo_info_comments) ?></div><br/>
    <div><strong><?= __('Additional Storage Comments') ?>: </strong><?= h($embryoCryo->storage_comments) ?></div><br/>
        <?php if ($embryoCryo->verified){ ?>
            <div class='row'>
                <div class='col-xs-12'><p style='color:red'>Verified by <?php echo $userName ?> on <?= h(date_format(date_create($embryoCryo->verified_time), 'Y-m-d')) ?></p></div>
            </div>
        <?php } else { 
            echo $this->Html->link('<span class="glyphicon glyphicon-ok"></span> ' . __('Verify'),
                [
                'controller' => 'EmbryoCryos',
                'action' => 'verify',
                $embryoCryo->id,
                $this->request->session()->read('Auth.User.id')
                ], array(
                    'escape' => false,
                    'class' => 'btn btn-danger',
                    'formmethod' => 'post'
                    ));    
         } ?><br/><br/>
    <div class="horizontal-table table-responsive">
        <table id='all-vials' class="table stripe order-column"  data-page-length='25'>
        <thead>
            <tr>
                <th><?= __('Label') ?></th>
                <th><?= __('# Embryos') ?></th>
                <th><?= __('Box Hierarchy') ?></th>
                <!-- <th><?= __('Space/Cane') ?></th> -->
                <th><?= __('Notes') ?></th>
                <th><?= __('Pups?') ?></th>
                <th><?= __('QC Pass?') ?></th>
                <th><?= __('Distribute?') ?></th>
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
                    <?php } elseif(isset($vial->ship_thaw_date) || isset($vial->ship_thaw_reason)) { //shipped vial
                         echo '<span style="color:#aaa"><em>Removed... </em><i class="fa fa-truck fa-flip-horizontal"></i></span>';
                     } else { //vial with no location but not shipped
                        echo '-';
                     } ?>
                </td>
                <!-- <td><?= isset($vial->inventory_location->cell) ? h($vial->inventory_location->cell) : '-' ?></td> -->
                <td><?= h($vial->comments) ?></td>
                <td><?= h($vial->pups) ?></td>
                <td><?= h($vial->qc_pass) ?></td>
                <td><?= $vial->do_not_distribute ? __('<span class="bool-no glyphicon glyphicon-remove"> No</span>') : __('<span class="bool-yes glyphicon glyphicon-ok"> Yes</span>'); ?></td>
                <td><?= isset($vial->ship_thaw_date) ? $vial->ship_thaw_date->format('n/j/y') : '-' ?></td>
                <td><strong><?= isset($vial->ship_thaw_reason) ? $vial->ship_thaw_reason : '-' ?></strong></td>                
                <td class="actions">
                    <?php
                    $controller = isset($vial->ship_thaw_date) || isset($vial->ship_thaw_reason) ? 'inventoryShippedVials' : 'inventoryVials';  
                     echo '<span data-toggle="tooltip" title="View">'. $this->Html->link('<span class="pad-action-glyph glyphicon glyphicon-eye-open"></span>', ['action' => 'view', 'controller'=> $controller, $vial->id],  array('escape' => false, 'class' => 'label label-primary action-pad')) . '</span>';
                    ?>
                    <?= '<span data-toggle="tooltip" title="Delete Straw">'. $this->Form->postLink('<span class="pad-action-glyph glyphicon glyphicon glyphicon-trash"></span> ', ['controller' => $controller ,'action' => 'delete', $vial->id, 'embryo', $vial->embryo_cryo_id], ['escape' => false, 'class' => 'label label-danger action-pad', 'confirm' => __('Are you sure you want to delete vial {0}?', $vial->label)]) . '</span>' ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
        </table>
    <hr class="fat" />
    <?php endif; ?>
    </div>


<?php if (!empty($embryoCryo->embryo_resus)): ?>
    <div class="related horizontal-table">
        <h4><?= __('Related Embryo Resuscitation') ?></h4>
        <table class="table stripe order-column">
            <tr>
                <th><?= __('Id') ?></th>
                <th><?= __('Job Id') ?></th>
                <th><?= __('Embryo Cryo Id') ?></th>
                <th><?= __('Created') ?></th>
                <th><?= __('Modified') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($embryoCryo->embryo_resus as $embryoResus): ?>
            <tr>
                <td><?= h($embryoResus->id) ?></td>
                <td><?= h($embryoResus->job_id) ?></td>
                <td><?= h($embryoResus->embryo_cryo_id) ?></td>
                <td><?= h($embryoResus->created) ?></td>
                <td><?= h($embryoResus->modified) ?></td>
                <td class="actions">
                    <?= '<span data-toggle="tooltip" title="View">'. $this->Html->link('<span class="pad-action-glyph glyphicon glyphicon-eye-open"></span>', ['controller'=>'EmbryoResus', 'action' => 'view', $embryoResus->id],  array('escape' => false, 'class' => 'label label-primary action-pad')) . '</span>' ?>
                    <?= '<span data-toggle="tooltip" title="Edit">'. $this->Html->link('<span class="pad-action-glyph glyphicon glyphicon-pencil"></span>', ['controller'=>'EmbryoResus', 'action' => 'edit', $embryoResus->id], array('escape' => false, 'class' => 'label label-success action-pad')) . '</span>' ?>

                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <hr class="fat" />
    <?php endif; ?>
<div style="clear:both;"></div>
<hr/>
<?php
 echo $this->Html->link('' . __('Go back'), ['controller' => 'Jobs', 'action' => 'view', $embryoCryo->job_id, '#' => 'related-data'], array(
        'escape' => false,
        'class' => 'btn btn-default pad-button'
    ));

    echo $this->Html->link('<span class="glyphicon glyphicon-plus"></span> ' . __('Add Straws to EC'),
        [
        'controller' => 'InventoryVials',
        'action' => 'add',
        $embryoCryo->id,
        'embryo'
        ], array(
            'escape' => false,
            'class' => 'btn btn-success pad-button'
            ));    

    echo $this->Html->link('<span class="glyphicon glyphicon-plus"></span> ' . __('Add Embryo RS'), ['controller' => 'EmbryoResus', 'action' => 'add', $embryoCryo->job_id, $embryoCryo->id], array('escape' => false, 'class' => 'btn btn-info pad-button', 'style' => 'margin-left:10px;'));
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
