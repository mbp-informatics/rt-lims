<?php
echo $this->Html->link('<span class="glyphicon glyphicon-pencil"></span> ' . __('Edit IVF/ICSI'), ['controller' => 'Ivfs', 'action' => 'edit', $ivf->id], array('escape' => false, 'class' => 'btn btn-warning pull-right'));
?>
<?php $fromJob = $this->CustomForm->displayFromJobLabel(); ?>
<div class="ivfs view large-9 medium-8 columns content">
    <h3><?= __('IVF')." #".h($ivf->id) ?></h3>
    <div class='alert alert-info' role='alert'>IVF Info</div>
    <div class='container-fluid'>        
        <div class='row'>
            <div class='col-xs-4'><strong><?= __('Job') ?>: </strong><?= $ivf->has('job') ? $this->Html->link($ivf->job->id, ['controller' => 'Jobs', 'action' => 'view', $ivf->job->id]) : '' ?></div>
            <div class='col-xs-4'><strong><?= __('IVF Date') ?>: </strong><?php if (isset($ivf->ivf_date)) { echo h($ivf->ivf_date->format('n/j/Y')); } ?></div>
            <div class='col-xs-4'><strong><?= __('Purpose') ?>: </strong><?= h($ivf->purpose) ?></div>
        </div>
        
        <div class='row'>
            <div class='col-xs-8'><strong><?= __('Strain name') ?>: </strong><?php if ($ivf->job_id){ echo h($ivf->job->strain_name);} ?></div>
            <!-- <div class='col-xs-4'><strong><?= __('Background') ?>: </strong><?= h($ivf->background) ?></div> -->
            <div class='col-xs-4'><strong><?= __('Membership') ?>: </strong><?= h($ivf->membership) ?></div>
        </div>
        
        <div class='row'>
            <div class='col-xs-4'><strong><?= __('MMRRC ID') ?>: </strong><?php if ($ivf->job_id){ echo h($ivf->job->mmrrc_no);} ?></div>
            <div class='col-xs-4'><strong><?= __('KOMP Clone ID') ?>: </strong><?php if ($ivf->job_id){ echo h($ivf->job->esc_clone_id_no);} ?></div>
            <div class='col-xs-4'><strong><?= __('BL #') ?>: </strong><?php if ($ivf->job_id){ echo h($ivf->job->bl_no);} ?></div>
        </div>
        <div class='row'>
            <div class='col-xs-4'> <strong><?= __('Investigator') ?>: </strong><?= h($ivf->pi) ?></div>
        </div>
    </div>
    <div class='alert alert-info' role='alert'>Sperm Info</div>
    <div class='container-fluid'>
        <div class='row'>
            <div class='col-xs-4'><strong><?= __('Genotype') ?>: </strong><?php if ($ivf->job_id){ echo h($ivf->job->genotype);} ?></div>
            <div class='col-xs-4'><strong><?= __('Donor Strain (if wildtype)') ?>: </strong><?= h($ivf->sperm_info_donor_strain) ?></div>
            <div class='col-xs-4'><strong><?= __('Fresh/Frozen') ?>: </strong><?= h($ivf->fresh_frozen) ?></div>
        </div>
        
        <div class='row'>
            <div class='col-xs-4'><strong><?= __('Collect/Thaw Time') ?>: </strong><?php if (isset($ivf->collect_thaw_time)) { echo h($ivf->collect_thaw_time->format('g:i A')); } ?></div>
            <div class='col-xs-4'><strong><?= __('Stud ID') ?>: </strong><?= h($ivf->stud_id_no) ?></div>
            <div class='col-xs-4'><strong><?= __('Stud DOB') ?>: </strong><?php if (isset($ivf->stud_dob)) { echo h($ivf->stud_dob->format('n/j/Y')); } ?></div>
        </div>
        
        <div class='row'>
            <div class='col-xs-4'><strong><?= __('Time In MBCD') ?>: </strong><?php if (isset($ivf->time_in_mbcd)) { echo h($ivf->time_in_mbcd->format('g:i A')); } ?></div>
            
        </div>
        
    </div>
    <div class="panel panel-info">
        <div class="panel-body">
    		<p><span class="label label-info">If frozen</span></p>
            <div class='container-fluid'>
                <div class='row'>
                    <div class='col-xs-3'><strong><?= __('Sample Type') ?>: </strong><?= h($ivf->sample_type) ?></div>
                    <div class='col-xs-3'><strong><?= __('SC #') ?>: </strong><?= $ivf->sperm_cryo_id ? $this->Html->link($ivf->sperm_cryo_id, ['controller' => 'SpermCryos', 'action' => 'view', $ivf->sperm_cryo_id]) : '' ?></div>
                    <div class='col-xs-3'><strong><?= __('Straw/Vial ID') ?>: </strong><?= h($ivf->straw_vial_no) ?></div>
                    <div class='col-xs-3'><strong><?= __('CPA Lot No') ?>: </strong><?= h($ivf->cpa_lot_no) ?></div>
                </div>
            </div>
            
    		<p><span class="label label-info">If centrifugation</span></p>
            <div class='container-fluid'>
                <div class='row'>
                    <div class='col-xs-3'><strong><?= __('Force (g)') ?>: </strong><?= h($ivf->centrifuge_force) ?></div>
                    <div class='col-xs-3'><strong><?= __('Centrifuge Time') ?>: </strong><?= h($ivf->centrifuge_time) ?></div>
                </div>
            </div>
        </div>
    </div>
    <div class='alert alert-info' role='alert'>Sperm Parameters</div>
    <div class='container-fluid'>
        <div class='row'>
            <div class='col-xs-1'></div>
            <div class='col-xs-10'>
                <div class="panel panel-info">
                    <div class="panel-body">
                        <div class='container-fluid'>
                            <div class='row'>
                                <div class='col-xs-5'></div>
                                <div class='col-xs-3'><strong>CPA/Fresh</strong></div>
                                <div class='col-xs-3'><strong>MBCD</strong></div>
                            </div>
                            <div class='row'>
                                <div class='col-xs-5'><strong>Sperm Concentration (M/ml)</strong></div>
                                <div class='col-xs-3'><?= h($ivf->cpa_fresh_sperm_conc) ?></div>
                                <div class='col-xs-3'><?= h($ivf->mbcd_sperm_conc) ?></div>
                            </div>
                            <div class='row'>
                                <div class='col-xs-5'><strong>Total Motility</strong></div>                    
                                <div class='col-xs-3'><?= h($ivf->cpa_fresh_total_motility) ?>%</div>
                                <div class='col-xs-3'><?= h($ivf->mbcd_total_motality) ?>%</div>
                            </div>
                            <div class='row'>
                                <div class='col-xs-5'><strong>Rapid Motility</strong></div>                       
                                <div class='col-xs-3'><?= h($ivf->cpa_fresh_rapid_motility) ?>%</div>
                                <div class='col-xs-3'><?= h($ivf->mbcd_rapid_motality) ?>%</div>
                            </div>
                            <div class='row'>
                                <div class='col-xs-5'><strong>Progressive Motility</strong></div>                     
                                <div class='col-xs-3'><?= h($ivf->cpa_fresh_prog_motality) ?>%</div>
                                <div class='col-xs-3'><?= h($ivf->mbcd_prog_motality) ?>%</div>
                            </div>
                            <hr>
                            <div class='row'>
                                <div class='col-xs-4'><strong><em>Sperm Morphology:</em></strong></div>
                            </div>
                            
                            <div class='row'>
                                <div class='col-xs-4'><strong><?= __('Abnormal Heads') ?>: </strong><?= h($ivf->abnormal_heads) ?>%</div>
                                <div class='col-xs-4'><strong><?= __('Abnormal Tails') ?>: </strong><?= h($ivf->abnormal_tails) ?>%</div>
                                <div class='col-xs-4'><strong><?= __('Sperm Analyzer') ?>: </strong><?= h($ivf->sperm_analyzer) ?></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class='col-xs-1'></div>
        </div>
        
        <div class='row'>   
            <div class='col-xs-12'><strong><?= __('Sperm Info Comments') ?>: </strong><?= h($ivf->sperm_info_comments) ?></div>          
        </div>
	</div>    
    
    <div class="panel panel-info">
        <div class="panel-body">
    		<p><span class="label label-info">If no SC, Epi storage:</span></p>
            <div class='container-fluid'>
                <div class='row'>
                    <div class='col-xs-3'><strong><?= __('Tank') ?>: </strong><?= h($ivf->epi_storage_tank) ?></div>
    		        <div class='col-xs-3'><strong><?= __('Rack') ?>: </strong><?= h($ivf->epi_storage_rack) ?></div>
    		        <div class='col-xs-3'><strong><?= __('Box') ?>: </strong><?= h($ivf->epi_storage_box) ?></div>
    		        <div class='col-xs-3'><strong><?= __('Space') ?>: </strong><?= h($ivf->epi_storage_space) ?></div>
                </div>
                
                <div class='row'>
    		        <div class='col-xs-3'><strong><?= __('Vial ID') ?>: </strong><?= h($ivf->epi_storage_vial_id_no) ?></div>
    		        <div class='col-xs-3'><strong><?= __('Code') ?>: </strong><?= h($ivf->epi_storage_code) ?></div>
    		    </div>
                <hr>
                <div class='row'>
                    <div class='col-xs-4'><strong><?= __('Male Genotype Confirmed') ?>: </strong><?= $ivf->male_genotype_confirmed ? __('<span class="bool-yes glyphicon glyphicon-ok"> Yes</span>') : __('<span class="bool-no glyphicon glyphicon-remove"> No</span>'); ?></div>
                    <div class='col-xs-4'><strong><?= __('Geno Date') ?>: </strong><?php if (isset($ivf->geno_date)) { echo h($ivf->geno_date->format('n/j/Y')); } ?></div>
                    <div class='col-xs-4'><strong><?= __('Genotyped By') ?>: </strong><?= h($ivf->genotyped_by) ?></div>
                </div>
    		</div>
        </div>
    </div>

    <div class='alert alert-info' role='alert'>IVF Info</div>
    <div class='container-fluid'>
        <div class='row'>
            <div class='col-xs-2'><strong><?= __('ICSI?') ?>: </strong><?= $ivf->icsi ? __('<span class="bool-yes glyphicon glyphicon-ok"> Yes</span>') : __('<span class="bool-no glyphicon glyphicon-remove"> No</span>'); ?></div>
            <div class='col-xs-4'><strong><?= __('IVF Method') ?>: </strong><?= h($ivf->ivf_method) ?></div>                       
            <div class='col-xs-3'><strong><?= __('Incubator ID') ?>: </strong><?= h($ivf->incubator_id_no) ?></div> 
            <div class='col-xs-3'><strong><?= __('IVF/ICSI By') ?>: </strong><?= h($ivf->ivf_icsi_by) ?></div> 
        </div>
        
        <div class='row'>
            <div class='col-xs-2'><strong><?= __('Co-culture hrs') ?>: </strong><?= h($ivf->co_culture_hrs) ?></div> 
            <div class='col-xs-4'><strong><?= __('2-cell Score Time') ?>: </strong><?php if (isset($ivf->two_cell_score_time)) { echo h($ivf->two_cell_score_time->format('g:i A')); } ?></div> 
            
        </div>
        
        <div class='row'>
            <div class='col-xs-12'><strong><?= __('Comment') ?>: </strong><?= h($ivf->ivf_icsi_info_comment) ?></div> 
        </div>

    </div>
    
    <div id='ivf-dishes' class='horizontal-table'>
        <h4><?= __('<span class="glyphicon glyphicon-edit"></span> IVF Dishes') ?></h4>
        <?php if (!empty($ivf->ivf_dishes)): ?>
        <table class="table table-striped order-column table-responsive">
            <thead>
                <th><?= __('Dish #') ?></th>
                <th><?= __('# Clutches') ?></th>
                <th><?= __('COCs in Dish Time') ?></th>
                <th><?= __('Insemination Time') ?></th>
                <th><?= __('Sperm (ul)') ?></th>
                <th><?= __('# 1-cell') ?></th>
                <th><?= __('# 2-cell') ?></th>
                <th><?= __('Fert Rate (%)') ?></th>
                <th><?= __('Dish Notes') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </thead>
            <?php 
            $one_cell_sum = $two_cell_sum = $fert_rate_sum = $fert_rate_i = 0;

            foreach ($ivf->ivf_dishes as $ivfDishes): ?>
            <tr>
                <td><?= h($ivfDishes->dish_no) ?></td>
                <td><?= h($ivfDishes->clutches_no) ?></td>
                <td><?php if (isset($ivfDishes->cocs_in_dish_time)) { echo h($ivfDishes->cocs_in_dish_time->format('g:i A')); } ?></td>
                <td><?php if (isset($ivfDishes->insemination_time)) { echo h($ivfDishes->insemination_time->format('g:i A')); } ?></td>
                <td><?= h($ivfDishes->sperm_ul) ?></td>
                <td><?= h($ivfDishes->one_cell_no); $one_cell_sum += $ivfDishes->one_cell_no; ?></td>
                <td><?= h($ivfDishes->two_cell_no); $two_cell_sum += $ivfDishes->two_cell_no; ?></td>
                <td><?= h($ivfDishes->fert_rate); $fert_rate_sum += $ivfDishes->fert_rate; $fert_rate_i++;  ?></td>
                <td><?= h($ivfDishes->note) ?></td>
                <td class="actions">
                    <?= '<span data-toggle="tooltip" title="View">'. $this->Html->link('<span class="pad-action-glyph glyphicon glyphicon-eye-open"></span>', ['action' => 'view', 'controller'=> 'ivfDishes', $ivfDishes->id],  array('escape' => false, 'class' => 'label label-primary action-pad')) . '</span>' ?>
                    <?= '<span data-toggle="tooltip" title="Edit">'. $this->Html->link('<span class="pad-action-glyph glyphicon glyphicon-pencil"></span>', ['action' => 'edit', 'controller' => 'ivfDishes', $ivfDishes->id], array('escape' => false, 'class' => 'label label-success action-pad')) . '</span>' ?>
                    <?= '<span data-toggle="tooltip" title="Delete">'. $this->Form->postLink('<span class="pad-action-glyph glyphicon glyphicon glyphicon-trash"></span> ', ['action' => 'delete', 'controller' => 'ivfDishes' , $ivfDishes->id], ['escape' => false, 'class' => 'label label-danger action-pad', 'confirm' => __("Are you sure you want to delete this dish?"), $ivfDishes->id]) . '</span>'; ?>
                </td>
            </tr>
            <?php endforeach; ?>
            <tr>
                <td> </td>
                <td> </td>
                <td> </td>
                <td> </td>
                <td> </td>
                <td style="border-top:1px solid black; padding-top:5px !important;">
                    <span class="important"><?= $one_cell_sum ?></span>
                </td>
                <td style="border-top:1px solid black; padding-top:5px !important;">
                    <span class="important"><?= $two_cell_sum ?></span>
                </td>
                <td style="border-top:1px solid black; padding-top:5px !important;">
                    <?php
                    if ($two_cell_sum+$one_cell_sum != 0) {
                        $fertRate = ($two_cell_sum/($two_cell_sum+$one_cell_sum))*100;
                    } else {
                        $fertRate = 0;
                    } 
                    ?>
                    <span class="important"><?= number_format($fertRate, 2).'%'; ?></span>
                </td>
                <td> </td>
                <td> </td>
            </tr>
        </table>
    <?php endif; ?>
        <?php
            echo $this->Html->link('<span class="glyphicon glyphicon-plus"></span> ' . __('Add Dish'), ['controller' => 'IvfDishes', 'action' => 'add', $ivf->id], array('escape' => false, 'class' => 'btn btn-warning pad-button'));
        ?>
    </div>
 
    <div class='alert alert-info' role='alert'>Eggs Info</div>
    <div class='container-fluid'>
        <div class='row'>
            <div class='col-xs-4'><strong><?= __('Donor Strain') ?>: </strong><?= h($ivf->eggs_info_donor_strain) ?></div>
            <div class='col-xs-4'><strong><?= __('Genotype') ?>: </strong><?= h($ivf->eggs_info_genotype) ?></div>
            <div class='col-xs-4'><strong><?= __('Donor DOB') ?>: </strong><?php if (isset($ivf->eggs_info_donor_dob)) {echo h($ivf->eggs_info_donor_dob->format('n/j/Y'));} ?></div>
        </div>
        
        <div class='row'>
            <!-- <div class='col-xs-4'><strong><?= __('Donor Age') ?>: </strong><?= h($ivf->eggs_info_donor_age) ?  h($ivf->eggs_info_donor_age) : '-' ?></div> -->
            <div class='col-xs-4'><strong><?= __('Females Ordered #') ?>: </strong><?= h($ivf->females_ordered_no) ?></div>
            <!-- <div class='col-xs-4'><strong><?= __('Females Out #') ?>: </strong><?= $this->Number->format($ivf->females_out_no) ?></div> -->

            <div class='col-xs-4'><strong><?= __('Unsuperovulated #') ?>: </strong><?= h($ivf->unsuperovulated_no) ?></div>
            <div class='col-xs-2'><strong><?= __('PMSG Time') ?>: </strong><?php if (isset($ivf->pmsg_time)) { echo h($ivf->pmsg_time->format('g:i A')); } ?></div>
            <div class='col-xs-2'><strong><?= __('HCG Time') ?>: </strong><?php if (isset($ivf->hcg_time)) { echo h($ivf->hcg_time->format('g:i A')); } ?></div>
        </div>
        <!-- The average eggs/donor is calculated from total number of cells/# of females - unsuperovulated -->
        <?php
            if ($ivf->females_out_no-$ivf->unsuperovulated_no != 0) {
                $averageEggs = ($two_cell_sum+$one_cell_sum)/($ivf->females_out_no-$ivf->unsuperovulated_no);
            } else {
                $averageEggs = 0;
            } 
        ?>        
        <div class='row'>
            <div class='col-xs-4'><strong><?= __('PMSG HCG By') ?>: </strong><?= h($ivf->pmsg_hcg_by) ?></div>
            <div class='col-xs-4'><strong><?= __('Average Eggs/Donor') ?>: </strong><?= h(number_format($averageEggs, 2)) ?></div>
        </div>
        
        <div class='row'>
            <div class='col-xs-12'><strong><?= __('Eggs Info Comments') ?>: </strong><?= h($ivf->eggs_info_comments) ?></div>          
        </div>
    </div>

    <div class='alert alert-info' role='alert'>More ICSI/Laser Info</div>
    <div class='container-fluid'>
        <div class='row'>
            <div class='col-xs-3'><strong><?= __('Eggs Injected #') ?>: </strong><?= h($ivf->eggs_injected_no) ?></div>
            <div class='col-xs-3'><strong><?= __('Eggs Survived #') ?>: </strong><?= h($ivf->eggs_survived_no) ?></div>
            <div class='col-xs-3'><strong><?= __('Survival Rate') ?>: </strong><?= h($ivf->survival_rate) ?></div>
            <div class='col-xs-3'><strong><?= __('Egg Collection Time') ?>: </strong><?php if (isset($ivf->egg_collection_time)) {echo h($ivf->egg_collection_time->format('g:i A'));} ?></div>
        </div>
        
        <div class='row'>  
            <div class='col-xs-3'><strong><?= __('Laser System') ?>: </strong><?= h($ivf->laser_system) ?></div> 
            <div class='col-xs-3'><strong><?= __('Pulse Duration (µs)') ?>: </strong><?= h($ivf->pulse_duration) ?></div> 
            <div class='col-xs-3'><strong><?= __('Laser Power %') ?>: </strong><?= h($ivf->laser_power) ?></div> 
            <div class='col-xs-3'><strong><?= __('ICSI End Time') ?>: </strong><?php if (isset($ivf->icsi_end_time)) {echo h($ivf->icsi_end_time->format('g:i A'));} ?></div>
        </div>
        
        <div class='row'>        
            <div class='col-xs-12'><strong><?= __('More ICSI Info Comments') ?>: </strong><?= h($ivf->more_icsi_info_comments) ?></div>
        </div>
	</div>
    <div class='alert alert-info' role='alert'>Media</div>
    <div class='container-fluid'>
        <div class='row'>
            <div class='col-xs-4'><strong><?= __('IVF Medium') ?>: </strong><?= h($ivf->ivf_medium) ?></div>
            <div class='col-xs-4'><strong><?= __('IVF Medium Lot') ?>: </strong><?= h($ivf->ivf_medium_lot) ?></div>
            <div class='col-xs-4'><strong><?= __('IVF Medium Vendor') ?>: </strong><?= h($ivf->ivf_medium_vendor) ?></div>
        </div>
        
        <div class='row'>      
            <div class='col-xs-4'><strong><?= __('Oil Vendor') ?>: </strong><?= h($ivf->oil_vendor) ?></div>
            <div class='col-xs-4'><strong><?= __('Oil Lot') ?>: </strong><?= h($ivf->oil_lot) ?></div>
        </div>
    </div>

    
    <?php if ( !empty($ivf->embryo_cryos)) { ?>

	<h4><span class="glyphicon glyphicon-retweet"></span> <?= __('Related Data') ?></h4>
	<div id="accordion" role="tablist" aria-multiselectable="true" style="margin-left:35px;">

	<?php if (!empty($ivf->embryo_cryos)): ?>
		<div class="panel panel-default">
		    <a class="accord-head collapsed accord-head" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
		    <div class="panel-heading alert-info"" role="tab" id="headingOne">
		      <h4 class="panel-title">
		          Embryo Cryos <sup>(<?= count($ivf->embryo_cryos) ?>)</sup> <span class="caret"></span>
		      </h4>
		    </div>
		    </a>
		    <div id="collapseOne" class="horizontal-table panel-collapse collapse role="tabpanel" aria-labelledby="headingOne">
		        <table class="data-table table stripe order-column">
		            <tr>
		  				<th><?= __('Id') ?></th>
		                <th><?= __('Job Id') ?></th>
		                <th><?= __('Cryo Date') ?></th>
		                <th><?= __('Stud Strain') ?></th>
		                <th class="actions"><?= __('Actions') ?></th>
		            </tr>
		            <?php foreach ($ivf->embryo_cryos as $embryoCryos): ?>
		            <tr>
		                <td><?= h($embryoCryos->id) ?></td>
		                <td><?= h($embryoCryos->job_id) ?></td>
		                <td><?= h($embryoCryos->cryo_date) ?></td>
		                <td><?= h($embryoCryos->stud_strain) ?></td>
		                <td class="actions">
		                    <?= '<span data-toggle="tooltip" title="View">'. $this->Html->link('<span class="pad-action-glyph glyphicon glyphicon-eye-open"></span>', ['action' => 'view', 'controller' => 'embryoCryos' ,$embryoCryos->id],  array('escape' => false, 'class' => 'label label-primary action-pad')) . '</span>' ?>
		                    <?= '<span data-toggle="tooltip" title="Edit">'. $this->Html->link('<span class="pad-action-glyph glyphicon glyphicon-pencil"></span>', ['action' => 'edit', 'controller' => 'embryoCryos' ,$embryoCryos->id], array('escape' => false, 'class' => 'label label-success action-pad')) . '</span>' ?>
		                </td>
		            </tr>
		            <?php endforeach; ?>
		        </table>
		    </div>
		  </div>
		<?php endif; ?>

</div>
<?php } ?>

<div style="clear:both;"></div>
    <div class='alert alert-info' role='alert'>Meta</div>
    <div class='container-fluid'>
        <div class='row'>
            <div class='col-xs-4'><strong><?= __('ID') ?>: </strong><?= h($ivf->id) ?></div>
            <div class='col-xs-4'><strong><?= __('Created') ?>: </strong><?= h($ivf->created) ?></div>
            <div class='col-xs-4'><strong><?= __('Modified') ?>: </strong><?= h($ivf->modified) ?></div>
        </div>
    </div>

<?php
 echo $this->Html->link('' . __('Go back'), ['controller' => 'Jobs', 'action' => 'view', $ivf->job_id], array(
        'escape' => false,
        'class' => 'btn btn-default',
        'style' => 'margin-left:10px'

    ));
?>

<div class="clearfix"></div>
<?= $this->ChangeLog->displayChangeLog($changes) ?>