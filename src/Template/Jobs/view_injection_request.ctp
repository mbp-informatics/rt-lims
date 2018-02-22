<script>
$( document ).ready(function() {
	/* Initiate jQuery UI dialogs/modals */
	var jobId = <?= $job->id ?>;
	iniDialog('#associate-contact', '/contacts-jobs/add/', jobId);
	iniDialog('#add-job-comment', '/job-comments/add/', jobId);
});   
</script>
<div class="jobs view large-9 medium-8 columns content">
    <h3><span class="glyphicon glyphicon-calendar"></span> <?= __('Job')." ID # ".h($job->id) ?> (Injection Request)
        <?php
        echo $this->html->link('<span class="glyphicon glyphicon-pencil"></span> ' . __('Edit Request'), ['controller' => 'jobs', 'action' => 'edit', $job->id], array('escape' => false, 'class' => 'btn btn-warning pull-right','style' => 'margin-left:10px;'));
        echo $this->html->link('<span class="glyphicon glyphicon-plus"></span> ' . __('Add Injection'), "/injections/add?job_id={$job->id}", array('escape' => false, 'class' => 'btn btn-success pull-right','style' => 'margin-left:10px;'));
        ?>
    </h3>
<hr/>
    <div class='container-fluid'>
        <div class='row'>
            <div class='col-xs-4'><strong><?= __('Job Source') ?>: </strong><?php if ($job->job_source){ echo $job->job_source ;} else { echo '-';} ?></div>
            <div class='col-xs-4'><strong><?= __('Gene') ?>: </strong><?php if ($job->mgi_accession_id){ echo $job->mgi_genes_dump->marker_symbol.' ('.$job->mgi_accession_id.')'; } else { echo '-';} ?></div>
            <div class='col-xs-4'><strong><?= __('Cell/Clone line') ?>: </strong><?php if ($job->cell_clone_line){ echo $job->cell_clone_line; } else { echo '-';} ?></div>
        </div>

        <div class='row'>
            <div class='col-xs-4'><strong><?= __('Request date') ?>: </strong><?php if ($job->request_date){ echo $job->request_date->format('n/j/y');} else { echo '-';} ?></div>
            <div class='col-xs-4'><strong><?= __('Reopened date') ?>: </strong><?php if ($job->reopened_date){ echo $job->reopened_date->format('n/j/y');} else { echo '-';} ?></div>
            <div class='col-xs-4'><strong><?= __('Closed date') ?>: </strong><?php if ($job->closed_date){ echo $job->closed_date->format('n/j/y');} else { echo '-';} ?></div>
        </div>
        
    	<div class='row'>
            <div class='col-xs-4'><strong><?= __('Membership') ?>: </strong><?= h($job->membership) ?></div>
            <div class='col-xs-4'><strong><?= __('Order #') ?>: </strong><?= h($job->order_no) ?></div>
            <div class='col-xs-4'><strong><?= __('Facility') ?>: </strong><?= h($job->et_location) ?></div>
        </div>
        
        <div class='row'>
            <div class='col-xs-4'><strong><?= __('Parental Line') ?>: </strong><?= h($job->inj_parental_line) ?></div>
            <div class='col-xs-4'><strong><?= __('Preferred Donor') ?>: </strong><?= h($job->preferred_donor) ?></div>
            <div class='col-xs-4'><strong><?= __('Injection Type?') ?> </strong><?= $job->inj_injection_type ?></div>  
        </div>
        <div class='row'>
        <div class='col-xs-4'><strong><?= __('Repeat?') ?> </strong><?= $job->inj_repeat ? __('<span class="bool-yes glyphicon glyphicon-ok"> Yes</span>') : __('<span class="bool-no glyphicon glyphicon-remove"> No</span>'); ?></div>   
        </div>      
<br/>
  
    <div class="panel panel-info" style="background-color:#fafaf8;">
        <div class="panel-body">
			<div id="contacts" class="related horizontal-table" style="margin-bottom:20px;">
		        <h4><?= __('<span class="glyphicon glyphicon-user"></span> Job Contacts') ?></h4>
		        <?php if (!empty($job->contacts)): ?>
		        <table class="table stripe order-column">
		            <tr>
		                <!-- <th><?= __('ID') ?></th> -->
		                <th><?= __('Name') ?></th>
		                <th><?= __('Campus/Institution') ?></th>
						<th><?= __('Contact Type') ?></th>
		                <th><?= __('Email') ?></th>
		                <th class="actions"><?= __('Actions') ?></th>
		            </tr>
		            <?php foreach ($job->contacts as $contacts): ?>
		            <tr>
		                <!-- <td><?= h($contacts->id) ?></td> -->
		                <td><?= h($contacts->first_name . ' ' . $contacts->last_name) ?></td>
		                <td><?= h($contacts->campus_company) ?></td>
						<td><?= h($contacts->contact_type->name) ?></td>
		                <td><?= h($contacts->email) ?>
		                    <?php if (!empty($contacts->email)): ?><a href="mailto:<?= h($contacts->email) ?>"><span class="glyphicon glyphicon-envelope"></span></a><?php endif; ?>
	                    </td>
		                <td class="actions">
		                    <?= '<span data-toggle="tooltip" title="View">'. $this->Html->link('<span class="pad-action-glyph glyphicon glyphicon-eye-open"></span>', ['action' => 'view', 'controller'=> 'Contacts', $contacts->id],  array('escape' => false, 'class' => 'label label-primary action-pad')) . '</span>' ?>
							<!-- edit button -->								
								<script>
								$( document ).ready(function() {
									iniDialog('#edit-contact-<?= $contacts->id ?>', '/contacts/edit/', [<?= $contacts->id ?>,<?= $job->id ?>]);
								});
								</script>
								<div style="display:none;" id="dialog-edit-contact-<?= $contacts->id ?>" title="Edit Contact"></div>
								<span data-toggle="tooltip" title="Edit"><a id="edit-contact-<?= $contacts->id ?>" href="#" class="label label-success action-pad"><span class="pad-action-glyph glyphicon glyphicon-pencil"></span></a></span>
							<!-- /edit button -->
		           			<?php
		           			$assocId = $contacts->_joinData->id;
		           			echo '<span data-toggle="tooltip" title="Delete">'. $this->Form->postLink('<span class="pad-action-glyph glyphicon glyphicon glyphicon-trash"></span> ', ['action' => 'delete', 'controller' => 'ContactsJobs' ,$assocId, $job->id], ['escape' => false, 'class' => 'label label-danger action-pad', 'confirm' => __('Are you sure you want to unlink job-contact association # {0}? This will NOT delete the contact.', $assocId)]) . '</span>';
		           			?>
		                </td>
		            </tr>
		            <?php endforeach; ?>
		        </table>
		    	<?php endif; ?>
				<div id="dialog-associate-contact" title="Associate a contact"></div>
				<button id="associate-contact" class="btn btn-warning pad-button"><span class="glyphicon glyphicon-plus"></span> Associate a contact</button>	
			</div>
        </div>
    </div> 

  
	<div class='alert alert-info' role='alert'>Meta</div>
    <div class='container-fluid'>
    	<div class='row'>
            <div class='col-xs-4'><strong><?= __('Created') ?>: </strong><?= h($job->created) ?></div>
            <div class='col-xs-4'><strong><?= __('Modified') ?>: </strong><?= h($job->modified) ?></div>
            <div class='col-xs-4'><strong><?= __('Created by') ?>: </strong><?= isset($job->user) ? $this->Html->link($job->user->name, ['controller' => 'Users', 'action' => 'view', $job->user->id]) : '' ?></div>
        </div>
        <div class='row'>
           <div class='col-xs-3'><strong><?= __('FMP ID') ?>: </strong><?= h($job->fmp_id_no) ?></div>
        </div>
    </div> 
    
    <div class="panel panel-info" style="background-color:#fafaf8;">
        <div class="panel-body">
		    <div class="related horizontal-table" id='job-comments'>
		        <h4><?= __('<span class="glyphicon glyphicon-comment"></span> Job Comments') ?></h4>
		        <?php if (!empty($comments)) { ?>
			        <table class="table stripe order-column">
			            <tr>
			                <th><?= __('User name') ?></th>
			                <th style="min-width:400px;"><?= __('Comment') ?></th>
			                <th><?= __('Created') ?></th>
			                <th class="actions"><?= __('Actions') ?></th>
			            </tr>
                        <?php foreach ($comments as $jobComments) { ?>
			            <tr>
			                <td><?= h($jobComments->user->name) ?>
			                     <a href="mailto:<?= h($jobComments->user->email) ?>"><span class="glyphicon glyphicon-envelope"></span></a>
			                </td>
			                <td><?= h($jobComments->comment) ?></td>
			                <td><?= h($jobComments->created) ?></td>
			                <td class="actions">
			                    <!-- <?= '<span data-toggle="tooltip" title="View">'. $this->Html->link('<span class="pad-action-glyph glyphicon glyphicon-eye-open"></span>', ['action' => 'view', 'controller'=> 'jobComments', $jobComments->id],  array('escape' => false, 'class' => 'label label-primary action-pad')) . '</span>' ?> -->
							
							<!-- edit button -->								
								<script>
								$( document ).ready(function() {
									iniDialog('#edit-job-comment-<?= $jobComments->id ?>', '/job-comments/edit/', [<?= $jobComments->id ?>,<?= $job->id ?>]);
								});
								</script>
								<div style="display:none;" id="dialog-edit-job-comment-<?= $jobComments->id ?>" title="Edit Job comment"></div>
								<span data-toggle="tooltip" title="Edit"><a id="edit-job-comment-<?= $jobComments->id ?>" href="#" class="label label-success action-pad"><span class="pad-action-glyph glyphicon glyphicon-pencil"></span></a></span>
							<!-- /edit button -->
		                	<?php
		           			echo '<span data-toggle="tooltip" title="Delete">'. $this->Form->postLink('<span class="pad-action-glyph glyphicon glyphicon glyphicon-trash"></span> ', ['action' => 'delete', 'controller' => 'JobComments', $jobComments->id], ['escape' => false, 'class' => 'label label-danger action-pad', 'confirm' => __('Are you sure you want to delete Job Comment # {0}?', $jobComments->id)]) . '</span>';
		           		?>
			                </td>
			            </tr>
			            <?php } ?>
			        </table>
		    	<?php } ?>
		        <hr/>
				<div id="dialog-add-job-comment" title="Add a job comment"></div>
				<button id="add-job-comment" class="btn btn-warning pad-button"><span class="glyphicon glyphicon-plus"></span> Add job comment</button>
		    </div>
        </div>
    </div> 
	<?php if (!empty($job->injections) || !empty($job->embryo_cryos) || !empty($job->embryo_resus) || !empty($job->sperm_cryos) || !empty($job->ivfs) || !empty($job->embryo_transfers) ) { ?>
	<h4><span class="glyphicon glyphicon-retweet"></span> <?= __('Related Data') ?></h4>
	<div id="accordion" role="tablist" aria-multiselectable="true" style="margin-left:35px;">

	<?php if (!empty($job->injections)): ?>
	<div class="panel panel-default horizontal-table">
	<a class="accord-head collapsed accord-head" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
	    <div class="panel-heading alert-info" role="tab" id="headingOne">
	      <h4 class="panel-title">
	          Injections <sup>(<?= count($job->injections) ?>)</sup> <span class="caret"></span>
	      </h4>
	    </div>
	    </a>
	    <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
	        <table class="table stripe order-column">
	            <tr>
	                <th><?= __('Inj ID') ?></th>
	                <th><?= __('Inj date') ?></th>
	                <th><?= __('Project name') ?></th>
	                <th><?= __('QC State') ?></th>
	                <th><?= __('Injected by') ?></th>
	                <th><?= __('Colony ID') ?></th>
	                <th><?= __('Recharge') ?></th>
	                <th class="actions"><?= __('Actions') ?></th>
	            </tr>
	            <?php foreach ($job->injections as $inj): ?>
	            <tr>
	                <td><?= h($inj->id) ?></td>
	                <td><?= isset($inj->injection_date) ? h($inj->injection_date->format('Y-m-d')) : '-' ?></td>
	                <td><?= $inj->project_name ?></td>
	                <td><?= h($inj->qc_state) ?></td>
	                <td><?= h($inj->injected_by) ?></td>
	                <td><?= $inj->colonies ?></td>
	                <td><?= h($inj->recharge) ?></td>
	                <td class="actions">
	                    <?= '<span data-toggle="tooltip" title="View">'. $this->Html->link('<span class="pad-action-glyph glyphicon glyphicon-eye-open"></span>', ['action' => 'view', 'controller' => 'Injections', $inj->id],  array('escape' => false, 'class' => 'label label-primary action-pad')) . '</span>' ?>
	                    <?= '<span data-toggle="tooltip" title="Edit">'. $this->Html->link('<span class="pad-action-glyph glyphicon glyphicon-pencil"></span>', ['action' => 'edit', 'controller' => 'Injections', $inj->id], array('escape' => false, 'class' => 'label label-success action-pad')) . '</span>' ?>                   
	                </td>
	            </tr>
	            <?php endforeach; ?>
	        </table>
	    </div>
	  </div>
	<?php endif; ?>

	<?php if (!empty($job->embryo_cryos)): ?>
	<div class="panel panel-default horizontal-table">
	<a class="accord-head collapsed accord-head" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
	    <div class="panel-heading alert-info" role="tab" id="headingTwo">
	      <h4 class="panel-title">
	          Embryo Cryos <sup>(<?= count($job->embryo_cryos) ?>)</sup> <span class="caret"></span>
	      </h4>
	    </div>
	    </a>
	    <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
	        <table class="table stripe order-column">
	            <tr>
	                <th><?= __('EC#') ?></th>
	                <th><?= __('IVF#') ?></th>
	                <th><?= __('Cryo Date') ?></th>
	                <th><?= __('Male Genotype') ?></th>
	                <th><?= __('Genotype Confirmed') ?></th>
	                <th><?= __('# of Straws') ?></th>
	                <th class="actions"><?= __('Actions') ?></th>
	            </tr>
	            <?php foreach ($job->embryo_cryos as $embryoCryos): ?>
	            <tr>
	                <td><?= h($embryoCryos->id) ?></td>
	                <td><?= h($embryoCryos->ivf_id) ?></td>
	                <td><?= isset($embryoCryos->cryo_date) ? h($embryoCryos->cryo_date->format('Y-m-d')) : '-' ?></td>
	                <td><?= h($embryoCryos->male_genotype) ?></td>
	                <td><?= $embryoCryos->genotype_confirmed ? __('<span class="bool-yes glyphicon glyphicon-ok"> Yes</span>') : __('<span class="bool-no glyphicon glyphicon-remove"> No</span>'); ?></td>
                	<td><?php if (!empty($embryoCryos)){
			                $samplesCount = count($embryoCryos->inventory_vials);
			                echo $samplesCount;
		                } else {
		                	echo '0';
		                } ?></td>
	                <td class="actions">
	                    <?= '<span data-toggle="tooltip" title="View">'. $this->Html->link('<span class="pad-action-glyph glyphicon glyphicon-eye-open"></span>', ['action' => 'view', 'controller' => 'EmbryoCryos', $embryoCryos->id],  array('escape' => false, 'class' => 'label label-primary action-pad')) . '</span>' ?>
	                    <?= '<span data-toggle="tooltip" title="Edit">'. $this->Html->link('<span class="pad-action-glyph glyphicon glyphicon-pencil"></span>', ['action' => 'edit', 'controller' => 'EmbryoCryos', $embryoCryos->id], array('escape' => false, 'class' => 'label label-success action-pad')) . '</span>' ?>                   
	                </td>
	            </tr>
	            <?php endforeach; ?>
	        </table>
	    </div>
	  </div>
	<?php endif; ?>

	<?php if (!empty($job->embryo_resus)): ?> 
	  <div class="panel panel-default horizontal-table">
	    <a class="accord-head collapsed accord-head" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
	    <div class="panel-heading alert-info" role="tab" id="headingThree">
	      <h4 class="panel-title">
	          Embryo Resus <sup>(<?= count($job->embryo_resus) ?>)</sup> <span class="caret"></span>
	      </h4>
	    </div>
	    </a>
	    <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
	        <table class="table stripe order-column">
	            <tr>
	                <th><?= __('ID') ?></th>
	                <th><?= __('Thaw Date') ?></th>
	                <th><?= __('Vial/Straw ID') ?></th>
	                <th><?= __('# Embryos') ?></th>
	                <th><?= __('# Recovered') ?></th>
	                <th><?= __('# Intact') ?></th>
	                <th><?= __('# Bad') ?></th>
	                <th><?= __('Thawed By') ?></th>
	                <th><?= __('EC#') ?></th>
	                <th class="actions"><?= __('Actions') ?></th>
	            </tr>
	            <?php foreach ($job->embryo_resus as $embryoResus): ?>
	            <tr>
	                <td><?= h($embryoResus->id) ?></td>
	                <td><?php if (isset($embryoResus->thawing_date)) { echo h($embryoResus->thawing_date->format('n/j/Y')); } ?></td>
	                <td><?= h($embryoResus->straw_no) ?></td>
	                <td><?= h($embryoResus->embryos_no) ?></td>
	                <td><?= h($embryoResus->recovered_no) ?></td>
	                <td><?= h($embryoResus->intact_no) ?></td>
	                <td><?= h($embryoResus->bad_lysed_no) ?></td>
	                <td><?= h($embryoResus->thawed_by) ?></td>
	                <td><?= h($embryoResus->embryo_cryo_id) ?></td>
	                <td class="actions">
	                    <?= '<span data-toggle="tooltip" title="View">'. $this->Html->link('<span class="pad-action-glyph glyphicon glyphicon-eye-open"></span>', ['action' => 'view', 'controller' => 'EmbryoResus', $embryoResus->id],  array('escape' => false, 'class' => 'label label-primary action-pad')) . '</span>' ?>
	                    <?= '<span data-toggle="tooltip" title="Edit">'. $this->Html->link('<span class="pad-action-glyph glyphicon glyphicon-pencil"></span>', ['action' => 'edit', 'controller' => 'EmbryoResus', $embryoResus->id], array('escape' => false, 'class' => 'label label-success action-pad')) . '</span>' ?>   
	                </td>
	            </tr>
	            <?php endforeach; ?>
	        </table>
	    </div>
	  </div>
	  <?php endif; ?>

	<?php if (!empty($job->sperm_cryos)): ?>
	  <div class="panel panel-default horizontal-table">
	    <a class="accord-head collapsed accord-head" data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
	    <div class="panel-heading alert-info" role="tab" id="headingFour">
	      <h4 class="panel-title">
	          Sperm Cryos <sup>(<?= count($job->sperm_cryos) ?>)</sup> <span class="caret"></span>
	      </h4>
	    </div>
	    </a>
	    <div id="collapseFour" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFour">
	            <table class="table stripe order-column">
	                <tr>
	                    <th><?= __('SC #') ?></th>
	                    <th><?= __('SC Date') ?></th>
	                    <th><?= __('Donor ID') ?></th>
                        <th><?= __('Donor Geno') ?></th>
	                    <th><?= __('Incorrect Geno') ?></th>
	                    <th><?= __('Sperm Conc') ?></th>
	                    <th><?= __('Total Motility') ?></th>
	                    <th><?= __('Rapid Motility') ?></th>
	                    <th><?= __('Prog Motility') ?></th>
	                    <th><?= __('Abn. Heads') ?></th>
	                    <th><?= __('Abn. Tails') ?></th>  
	                    <th><?= __('# of Vials') ?></th>              
	                    <th class="actions"><?= __('Actions') ?></th>
	                </tr>
	                <?php foreach ($job->sperm_cryos as $spermCryos): ?>
	                <tr>
	                    <td><?= h($spermCryos->id) ?></td>
	                    <td><?php if (isset($spermCryos->cryo_date)) { echo h($spermCryos->cryo_date->format('n/j/Y')); } ?></td>
	                    <td><?= h($spermCryos->donor_id_no) ?></td>
	                    <td><?= $spermCryos->donor_genotype_confirmed ? __('<span class="bool-yes glyphicon glyphicon-ok " > Yes</span>') : __('<span class="bool-no glyphicon glyphicon-remove"> No</span>'); ?></td>
                        <td><?= $spermCryos->incorrect_genotype ? __('<span class="glyphicon glyphicon-ok" style="color:red"> Yes</span>') : __('<span class="bool-no glyphicon glyphicon-remove"  style="color:green"> No</span>'); ?></td>
	                    <td><?= h($spermCryos->cryo_sperm_conc) ?></td>
	                    <td><?= h($spermCryos->cryo_total_motility) ?></td>
	                    <td><?= h($spermCryos->cryo_rapid_motility) ?></td>
	                    <td><?= h($spermCryos->cryo_prog_motility) ?></td>     
	                    <td><?= h($spermCryos->cryo_abnormal_heads) ?></td>
	                    <td><?= h($spermCryos->cryo_abnormal_tails) ?></td>
                        <td><?php if (!empty($spermCryos->inventory_vials)){
                    $samplesCount = 0;
                    foreach ($spermCryos->inventory_vials as $vial) {
                        if ($vial->tissue != 1) {
                            $samplesCount += 1;
                        }
                        }
                            echo $samplesCount;
                        } else {
                            echo '0';
                        } ?></td>
	                    <td class="actions">
	                        <?= '<span data-toggle="tooltip" title="View">'. $this->Html->link('<span class="pad-action-glyph glyphicon glyphicon-eye-open"></span>', ['action' => 'view', 'controller' => 'SpermCryos',$spermCryos->id],  array('escape' => false, 'class' => 'label label-primary action-pad')) . '</span>' ?>
	                        <?= '<span data-toggle="tooltip" title="Edit">'. $this->Html->link('<span class="pad-action-glyph glyphicon glyphicon-pencil"></span>', ['action' => 'edit', 'controller' => 'spermCryos', $spermCryos->id], array('escape' => false, 'class' => 'label label-success action-pad')) . '</span>' ?>
	                    </td>
	                </tr>
	                <?php endforeach; ?>
	            </table>
	    </div>
	  </div>
	<?php endif; ?>

	<?php if (!empty($job->ivfs)): ?>
	<div class="panel panel-default horizontal-table">
	    <a class="accord-head collapsed accord-head" data-toggle="collapse" data-parent="#accordion" href="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
	    <div class="panel-heading alert-info"" role="tab" id="headingFive">
	      <h4 class="panel-title">
	          IVF or ICSI <sup>(<?= count($job->ivfs) ?>)</sup> <span class="caret"></span>
	      </h4>
	    </div>
	    </a>
	    <div id="collapseFive" class="panel-collapse collapse role="tabpanel" aria-labelledby="headingFive">
	        <table class="table stripe order-column">
	            <tr>
	                <th><?= __('ID') ?></th>
	                <th><?= __('IVF date') ?></th>
	                <th><?= __('State') ?></th>
	                <th><?= __('SC#') ?></th>
	                <th><?= __('IVF By') ?></th>
	                <th><?= __('ICSI') ?></th>
	                <th class="actions"><?= __('Actions') ?></th>
	            </tr>
	            <?php foreach ($job->ivfs as $ivfs): ?>
	            <tr>
	                <td><?= h($ivfs->id) ?></td>
	                <td><?php if (isset($ivf->ivf_date)) { echo h($ivf->ivf_date->format('n/j/Y')); } ?></td>
	                <td><?= h($ivfs->fresh_frozen) ?></td>
	                <td><?= h($ivfs->sperm_cryo_id) ?></td>
	                <td><?= h($ivfs->ivf_icsi_by) ?></td>
	                <td><?= $ivfs->icsi ? __('<span class="bool-yes glyphicon glyphicon-ok"> Yes</span>') : __('<span class="bool-no glyphicon glyphicon-remove"> No</span>'); ?></td>
	                <td class="actions">
	                    <?= '<span data-toggle="tooltip" title="View">'. $this->Html->link('<span class="pad-action-glyph glyphicon glyphicon-eye-open"></span>', ['action' => 'view', 'controller' => 'ivfs', $ivfs->id],  array('escape' => false, 'class' => 'label label-primary action-pad')) . '</span>' ?>
                        <?= '<span data-toggle="tooltip" title="Edit">'. $this->Html->link('<span class="pad-action-glyph glyphicon glyphicon-pencil"></span>', ['action' => 'edit', 'controller' => 'ivfs', $ivfs->id], array('escape' => false, 'class' => 'label label-success action-pad')) . '</span>' ?>
	                </td>
	            </tr>
	            <?php endforeach; ?>
	        </table>
	    </div>
	  </div>
	<?php endif; ?>

	<?php if (!empty($job->embryo_transfers)): ?>
	<div class="panel panel-default horizontal-table">
	    <a class="accord-head collapsed accord-head" data-toggle="collapse" data-parent="#accordion" href="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
	    <div class="panel-heading alert-info"" role="tab" id="heaadingSix">
	      <h4 class="panel-title">
	          Embryo Transfers <sup>(<?= count($job->embryo_transfers) ?>)</sup> <span class="caret"></span>
	      </h4>
	    </div>
	    </a>
	    <div id="collapseSix" class="panel-collapse collapse role="tabpanel" aria-labelledby="heaadingSix">
	        <table class="table stripe order-column">
	            <tr>
	                <th><?= __('ET ID') ?></th>
	                <th><?= __('ET Date') ?></th>
	                <th><?= __('Embryos') ?></th>
	                <th><?= __("Tx'd") ?></th>
	                <th><?= __('Pups#') ?></th>
	                <th><?= __('MutM') ?></th>
	                <th><?= __('MutF') ?></th>
	                <th><?= __('Recipients') ?></th>
	                <th><?= __('Litter %') ?></th>
	                <th class="actions"><?= __('Actions') ?></th>
	            </tr>

	            <?php foreach ($job->embryo_transfers as $embryo_transfers): 
                $embryosCount = 0;
                $malePups = 0;
                $femalePups = 0;
                $totalPups = 0;
                $mutMales = 0;
                $mutFemales = 0;
                $totalMuts = 0;
                $litterCount = 0;
                $litterRate = 0;
                $birthRate = 0;
                $recipientCount = 0;
                if ($embryo_transfers->recipients) {
                    foreach ($embryo_transfers->recipients as $rec){
                        if ($rec->total_tx) {
                            $embryosCount += $rec->total_tx;
                        } 
                        if ($rec->male_pups) {
                            $malePups += $rec->male_pups;
                        } 
                        if ($rec->female_pups) {
                            $femalePups += $rec->female_pups;
                        } 
                        if ($rec->male_mut) {
                            $mutMales += $rec->male_mut;
                        } 
                        if ($rec->female_mut) {
                            $mutFemales += $rec->female_mut;
                        } 
                        $recipientCount +=1;
                        if ($rec->female_pups||$rec->male_pups) {
                            $litterCount += 1;
                        }                        
                    }
                    $totalPups = $femalePups+$malePups;
                    $totalMuts = $mutFemales+$mutMales;
                    if (!$embryosCount == 0) {
                        $birthRate = ($totalPups/$embryosCount)*100;
                    }
                    if (!$recipientCount == 0) {
                        $litterRate = ($litterCount/$recipientCount)*100;
                    }
                } ?>
	            <tr>
	                <td><?= h($embryo_transfers->id) ?></td>
	                <td><?php if (isset($embryo_transfers->et_date)) { echo h($embryo_transfers->et_date->format('n/j/Y')); } ?></td>
	                <td><?= h($embryo_transfers->fresh_frozen) ?></td>

	                <td><?= $embryosCount ?></td>
	                <td><?= $totalPups ?></td>
	                <td><?= $mutMales ?></td>
	                <td><?= $mutFemales ?></td>
	                <td><?= $recipientCount ?></td>
	                <td><?= round($litterRate, 2); ?></td>
	                <td class="actions">
	                    <?= '<span data-toggle="tooltip" title="View">'. $this->Html->link('<span class="pad-action-glyph glyphicon glyphicon-eye-open"></span>', ['action' => 'view', 'controller' => 'embryo_transfers', $embryo_transfers->id],  array('escape' => false, 'class' => 'label label-primary action-pad')) . '</span>' ?>
                        <?= '<span data-toggle="tooltip" title="Edit">'. $this->Html->link('<span class="pad-action-glyph glyphicon glyphicon-pencil"></span>', ['action' => 'edit', 'controller' => 'embryo_transfers', $embryo_transfers->id], array('escape' => false, 'class' => 'label label-success action-pad')) . '</span>' ?>
	                </td>
	            </tr>
	            <?php endforeach; ?>
	        </table>
	    </div>
	  </div>
	<?php endif; ?>

<?php }  //end if !empty(sperm cryos || embryo cryos || embryo resus...) ?>
<hr style="margin-top:35px;">
<?php
    echo $this->html->link('<span class="glyphicon glyphicon-plus"></span> ' . __('Add Injection'), "/injections/add?job_id={$job->id}", array('escape' => false, 'class' => 'btn btn-info pull-left','style' => 'margin-left:10px;'));
?>
<?php
echo $this->Html->link('<span class="glyphicon glyphicon-plus"></span> ' . __('Add Embryo Cryo'), ['controller' => 'EmbryoCryos', 'action' => 'add', $job->id], array('escape' => false, 'class' => 'btn btn-info pull-left', 'style' => 'margin-left:10px;'));
?>
<?php
echo $this->Html->link('<span class="glyphicon glyphicon-plus"></span> ' . __('Add Embryo RS'), ['controller' => 'EmbryoResus', 'action' => 'add', $job->id, 0], array('escape' => false, 'class' => 'btn btn-info pull-left', 'style' => 'margin-left:10px;'));
?>
<?php
echo $this->Html->link('<span class="glyphicon glyphicon-plus"></span> ' . __('Add Sperm Cryo'), ['controller' => 'SpermCryos', 'action' => 'add', $job->id], array('escape' => false, 'class' => 'btn btn-info pull-left', 'style' => 'margin-left:10px;'));
?>
<?php
echo $this->Html->link('<span class="glyphicon glyphicon-plus"></span> ' . __('Add IVF/ICSI'), ['controller' => 'Ivfs', 'action' => 'add', $job->id], array('escape' => false, 'class' => 'btn btn-info pull-left', 'style' => 'margin-left:10px;'));
?>
<?php
echo $this->Html->link('<span class="glyphicon glyphicon-plus"></span> ' . __('Add Embryo Transfer'), ['controller' => 'EmbryoTransfers', 'action' => 'add', 'job_id' => $job->id], array('escape' => false, 'class' => 'btn btn-info pull-left', 'style' => 'margin-left:10px;'));
?>
</div>
<br/><br/>
<?php
 echo $this->Html->link('' . __('Go back to all Jobs'), ['controller' => 'Jobs', 'action' => 'index'], array(
        'escape' => false,
        'class' => 'btn btn-default',
        'style' => 'margin-left:10px'

    ));
?>
<div class="clearfix"></div>
<?= $this->ChangeLog->displayChangeLog($changes) ?>

