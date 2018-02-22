<script>
$( document ).ready(function() {
    /* Initiate jQuery UI dialogs/modals */
    var jobId = <?= $job->id ?>;
    iniDialog('#associate-contact', '/contacts-jobs/add/', jobId);
    iniDialog('#add-job-type', '/job-types/add/', jobId);
    iniDialog('#add-job-comment', '/job-comments/add/', jobId);
    iniDialog('#associate-contact', '/contacts-jobs/add/', jobId);
    iniDialog('#associate-komp-vial', '/kompvials-jobs/add/', jobId, null, null, 550);
});   
</script>
<div class="jobs view large-9 medium-8 columns content">
    <h3><span class="glyphicon glyphicon-calendar"></span> <?= __('Job')." ID # ".h($job->id) ?>
        <?php
        echo $this->html->link('<span class="glyphicon glyphicon-pencil"></span> ' . __('Edit Job Request'), ['controller' => 'jobs', 'action' => 'edit', $job->id], array('escape' => false, 'class' => 'btn btn-warning pull-right','style' => 'margin-left:10px;'));
        ?>
    </h3>
    <div class='container-fluid'>
        <div class='row' style="word-break: break-all;">
            <?php if ($job->job_status == "Closed") { ?> <div class='alert alert-danger' style='text-align:left !important;'> <?php } else { ?> <div class='alert alert-success' style='text-align:left !important;'> <?php }; ?>
                <div class="panel-body">            
                    <div class='col-xs-4'><strong><?= __('Job status') ?>: </strong><?php if (isset($job->job_status)) { echo h($job->job_status);} else { echo '-';} ?></div>
                    <div class='col-xs-4'><strong><?= __('Job status 1') ?>: </strong><?php if (isset($job->job_astatus)) { echo h($job->job_astatus->name);} else { echo '-';} ?></div>
                    <div class='col-xs-4'><strong><?= __('Job status 2') ?>: </strong><?php if (isset($job->job_bstatus)) { echo h($job->job_bstatus->name);} else { echo '-';} ?></div>
                    
                <?php
                    echo "<br/><br/>";
                    if (!empty($job->job_source)) { ?>
                        <div class='col-xs-4'><strong><?= __('Job Source') ?>: <?= $job->job_source ?></strong></div>          
                <?php }
                if (!empty($job->project_id)) { ?>
                        <div class='col-xs-4'><strong><?= __('Project') ?>: <?= "<a href='/projects/view/{$job->project_id}'>{$job->project_name}</a>" ?></strong></div>          
                <?php } ?>
                </div>
            </div>
        </div>
    </div>
<!--
    <div class="panel panel-info" style="background-color:#fafaf8;">
        <div class="panel-body">
            <div id="job-source" class="related horizontal-table" style="margin-bottom:20px;">
                <h4>KOMP Job Source</h4>
                <?php if (!empty($job->komp_vials_dump)): ?>
                <table class="table stripe order-column">
                    <tr>                        
                        <th><?= __('KOMP vial ID') ?></th>
                        <th><?= __('KOMP Clone name') ?></th>
                        <th><?= __('MGI Accession Id') ?></th>
                        <th><?= __('KOMP Order Id') ?></th>
                        <th class="actions"><?= __('Actions') ?></th>
                    </tr>
                    <?php foreach ($job->komp_vials_dump as $vial): ?>
                    <tr>
                        <td><?= "<a href='/komp-vials-dump/view/{$vial->komp_vial_id}'>{$vial->komp_vial_id}</a>" ?></td>
                        <td><?= h($vial->clone_name) ?></td>
                        <td><?= h($vial->mgi_accession_id) ?></td>
                        <td>
                            <?= !empty($vial->komp_order_id) ? "<a target='_BLANK' href='https://www.komp.org/orderstatus2.php?order={$vial->komp_order_id}'>{$vial->komp_order_id} <span class='glyphicon glyphicon-link'></span></a>" : null?>
                        </td>
                        <td class="actions">
                            <?php
                            $assocId = $vial->_joinData->id;
                            echo '<span data-toggle="tooltip" title="Delete">'. $this->Form->postLink('<span class="pad-action-glyph glyphicon glyphicon glyphicon-trash"></span> ', ['action' => 'delete', 'controller' => 'Kompvials_jobs' ,$assocId, $job->id], ['escape' => false, 'class' => 'label label-danger action-pad', 'confirm' => __("Are you sure you want to unlink Komp vial <-> Job Reqest association for komp vial id = {$vial->komp_vial_id}? This will NOT delete the vial.", $assocId)]) . '</span>';
                            ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </table>
                <?php endif; ?>
                <div id="dialog-associate-komp-vial" title="Associate Komp Vial"></div>                
                <button id="associate-komp-vial" class="btn btn-warning pad-button pull-left"><span class="glyphicon glyphicon-zoom-in"></span> Associate a KOMP vial</button>  
                <?php if (!empty($job->project_id)) { ?>
                    <a target="_BLANK" href="/injections/add?project_id=<?= $job->project_id ?>&job_id=<?= $job->id ?>"><button style="margin:5px 0px 0px 35px" class="btn btn-info pull-left"><span class="glyphicon glyphicon-plus"></span> Add Injection</button></a>
                <?php } ?>
            </div>
        </div>
    </div> 
-->
    <div class='container-fluid'>
        <div class='row'>
            <div class='col-xs-4'><strong><?= __('Request date') ?>: </strong><?php if ($job->request_date){ echo $job->request_date->format('n/j/y');} else { echo '-';} ?></div>
            <div class='col-xs-4'><strong><?= __('Reopened date') ?>: </strong><?php if ($job->reopened_date){ echo $job->reopened_date->format('n/j/y');} else { echo '-';} ?></div>
            <div class='col-xs-4'><strong><?= __('Closed date') ?>: </strong><?php if ($job->closed_date){ echo $job->closed_date->format('n/j/y');} else { echo '-';} ?></div>
        </div>
        
        <div class='row'>
            <div class='col-xs-4'><strong><?= __('Membership') ?>: </strong><?= h($job->membership) ?></div>
            <div class='col-xs-4'><strong><?= __('KOMP source') ?>: </strong><?= h($job->komp_source) ?></div>
            <div class='col-xs-4'><strong><?= __('Mosaic ID') ?>: </strong><?= h($job->mosaic_id_no) ?></div>
        </div>
        

        <div class='row'>
            <div class='col-xs-4'><strong><?= __('MICL recharge') ?>: </strong><?= h($job->mcrl_recharge) ?></div>
            <div class='col-xs-4'><strong><?= __('MVP recharge') ?>: </strong><?= h($job->mvp_recharge) ?></div>
            <div class='col-xs-4'><strong><?= __('MGEL recharge') ?>: </strong><?= h($job->mgel_recharge) ?></div>
        </div>
        
        <div class='row'>
            <div class='col-xs-3'><strong><?= __('Will be billed?') ?> </strong><?= $job->billed ? __('<span class="bool-yes glyphicon glyphicon-ok"> Yes</span>') : __('<span class="bool-no glyphicon glyphicon-remove"> No</span>'); ?></div>          
            <div class='col-xs-3'><strong><?= __('Order #') ?>: </strong><?= $job->order_no ?></div>
            <div class='col-xs-3'><strong><?= __('Billing ID') ?>: </strong><?= $job->billing_id_no ?></div>
            <div class='col-xs-3'><strong><?= __('Import #') ?>: </strong><?= $job->import_id_no ?></div>
        </div>
    </div>
  
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


    <div class='alert alert-info' role='alert'>Job Request Details</div>
    <div class='container-fluid'>
        <div class='row'>
            <div class='col-xs-6'><strong><?= __('Strain Name') ?>: </strong><?= h($job->strain_name) ?></div>
            <div class='col-xs-6'><strong><?= __('Previous Strain Name') ?>: </strong><?= h($job->previous_name) ?></div>            
        </div>
        
        <div class='row'>
            <div class='col-xs-4'><strong><?= __('MMRRC ID') ?>: </strong><?= $job->mmrrc_no ?></div>
            <div class='col-xs-4'><strong><?= __('BL#') ?>: </strong><?= $job->bl_no ?></div>
            <div class='col-xs-4'><strong><?= __('PN/CR#') ?>: </strong><?= $job->pn_cr_no ?></div> 
        </div>
        
        <div class='row'>
            <div class='col-xs-12'><strong><?= __('Strain Note') ?>: </strong><?= h($job->strain_note) ?></div>           
        </div>
        <hr/>
        <div class='row'>
            <div class='col-xs-4'><strong><?= __('ESC Clone ID') ?>: </strong><?= h($job->esc_clone_id_no) ?></div>
            <div class='col-xs-4'><strong><?= __('ESC Line') ?>: </strong><?= h($job->esc_line) ?></div>
            <div class='col-xs-4'></div>
        </div>
        
        <div class='row'>   
            <div class='col-xs-4'><strong><?= __('Genotype') ?>: </strong><?= h($job->genotype) ?></div>
            <div class='col-xs-4'><strong><?= __('Sex-linked?') ?> </strong><?= h($job->sexlinked); ?></div>
            <div class='col-xs-4'></div>
        </div>
        <hr/>
        <div class='row'>
            <div class='col-xs-4'><strong><?= __('Background') ?>: </strong><?= h($job->background) ?></div>
            <div class='col-xs-4'><strong><?= __('Egg Donors') ?>: </strong><?= h($job->egg_donors) ?></div>
            <div class='col-xs-4'><strong><?= __('ET Location') ?>: </strong><?= h($job->et_location) ?></div>
        </div>
        
        <div class='row'>            
            <div class='col-xs-4'><strong><?= __('Recipient #') ?>: </strong><?= $job->recipient_no ?></div>            
            <div class='col-xs-4'><strong><?= __('Method or Note') ?>: </strong><?= h($job->method_note) ?></div>
            <div class='col-xs-4'></div>
        </div>
    </div>

    <div class="panel panel-info" style="background-color:#fafaf8; margin-top:20px;">
        <div class="panel-body">
            <div class="horizontal-table" id='requested-job-types'>
                <h4><?= __('<span class="glyphicon glyphicon-exclamation-sign"></span> Requested Job Types') ?></h4>        
                <?php if (!empty($job->job_types)): ?>
                <table class="table stripe order-column">
                    <tr>
                        <th><?= __('Job Type Name') ?></th>
                        <th><?= __('Scheduled Date 1') ?></th>
                        <th><?= __('Scheduled Date 2') ?></th>
                        <th class="actions"><?= __('Actions') ?></th>
                    </tr>
                    <?php foreach ($job->job_types as $jobTypes): ?>
                    <tr>
                        <td><span class="important"><span class="glyphicon glyphicon-check"></span> <?= h($jobTypes->job_type_name->name) ?></span></td>
                        <td><?= isset($jobTypes->scheduled_date1) ? h($jobTypes->scheduled_date1->format('Y-m-d')) : '-' ?></td>
                        <td><?= isset($jobTypes->scheduled_date2) ? h($jobTypes->scheduled_date2->format('Y-m-d')) : '-' ?></td>
                        <td class="actions">
                            <!-- edit button -->                                
                                <script>
                                $( document ).ready(function() {
                                    iniDialog('#edit-job-type-<?= $jobTypes->id ?>', '/job-types/edit/', [<?= $jobTypes->id ?>,<?= $job->id ?>]);
                                });
                                </script>
                                <div style="display:none;" id="dialog-edit-job-type-<?= $jobTypes->id ?>" title="Edit Job Type"></div>
                                <span data-toggle="tooltip" title="Edit"><a id="edit-job-type-<?= $jobTypes->id ?>" href="#" class="label label-success action-pad"><span class="pad-action-glyph glyphicon glyphicon-pencil"></span></a></span>
                            <!-- /edit button -->
                            <?php
                            echo '<span data-toggle="tooltip" title="Delete">'. $this->Form->postLink('<span class="pad-action-glyph glyphicon glyphicon glyphicon-trash"></span> ', ['action' => 'delete', 'controller' => 'JobTypes', $jobTypes->id], ['escape' => false, 'class' => 'label label-danger action-pad', 'confirm' => __('Are you sure you want to unlink Job Request Type # {0} from this Job Request?? This will NOT delete the Job Type definition.', $jobTypes->id)]) . '</span>';
                        ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </table>
                <?php endif; ?>
                <hr/>
                <div id="dialog-add-job-type" title="Add a job type"></div>
                <button id="add-job-type" class="btn btn-warning pad-button"><span class="glyphicon glyphicon-plus"></span> Add job type</button>   
            </div>
        </div>
    </div> 

    <div class='alert alert-info' role='alert'>Animal Information</div>
    <div class='container-fluid'>
        <div class='row'>
            <div class='col-xs-4'><strong><?= __('Housing') ?>: </strong><?= h($job->housing) ?></div>
            <div class='col-xs-4'><strong><?= __('Chimeras') ?>: </strong><?= h($job->chimeras) ?></div>
            <div class='col-xs-4'><strong><?= __('Chimera Fertility') ?>: </strong><?= h($job->chimera_fertility) ?></div>
        </div>
        <hr/>
        <div class='row'>             
            <div class='col-xs-3'><strong><?= __('# Males') ?>: </strong><?= $job->males_no ?></div>
            <div class='col-xs-9'><strong><?= __('Males ID/DOB') ?>: </strong><?= $job->males_id_dob ?></div>
        </div>
        
        <div class='row'>    
            <div class='col-xs-3'><strong><?= __('# Females') ?>: </strong><?= h($job->females_no) ?></div>
            <div class='col-xs-9'><strong><?= __('Females ID/DOB') ?>: </strong><?= $job->females_id_dob ?></div>         
        </div>
    </div> 
    <div class='alert alert-info' role='alert'>Genotyping</div>
    <div class='container-fluid'>
        <div class='row'>
            <div class='col-xs-3'><strong><?= __('Sperm Donor Genotyping?') ?> </strong><?= $job->donor_genotyping ? __('<span class="bool-yes glyphicon glyphicon-ok"> Yes</span>') : __('<span class="bool-no glyphicon glyphicon-remove"> No</span>'); ?></div>
            <div class='col-xs-3'><strong><?= __('Egg Donor Genotyping?') ?> </strong><?= $job->egg_donor_genotyping ? __('<span class="bool-yes glyphicon glyphicon-ok"> Yes</span>') : __('<span class="bool-no glyphicon glyphicon-remove"> No</span>'); ?></div>
            <div class='col-xs-3'><strong><?= __('Targeting confirmation?') ?> </strong><?= $job->targeting_conf ? __('<span class="bool-yes glyphicon glyphicon-ok"> Yes</span>') : __('<span class="bool-no glyphicon glyphicon-remove"> No</span>'); ?></div>
            <div class='col-xs-3'><strong><?= __('MUGA Sample Required?') ?> </strong><?= $job->muga_sample ? __('<span class="bool-yes glyphicon glyphicon-ok"> Yes</span>') : __('<span class="bool-no glyphicon glyphicon-remove"> No</span>'); ?></div>
        </div>
        
        <div class='row'> 
            <div class='col-xs-4'><strong><?= __('Genotyping of Derived Pups') ?>: </strong><?= h($job->where_geno) ?></div>
        </div>
        
        <div class='row'> 
            <div class='col-xs-12'><strong><?= __('MCRL note') ?>: </strong><?= h($job->mcrl_note) ?></div>
        </div>
    </div> 
    
    <div class='alert alert-info' role='alert'>Meta</div>
    <div class='container-fluid'>
        <div class='row'>
            <div class='col-xs-4'><strong><?= __('Created') ?>: </strong><?= h($job->created) ?></div>
            <div class='col-xs-4'><strong><?= __('Modified') ?>: </strong><?= h($job->modified) ?></div>
            <div class='col-xs-4'><strong><?= __('Created by') ?>: </strong><?= $job->has('user') ? $this->Html->link($job->user->name, ['controller' => 'Users', 'action' => 'view', $job->user->id]) : '' ?></div>
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
    <?php if ( !empty($job->embryo_cryos) || !empty($job->embryo_resus) || !empty($job->sperm_cryos) || !empty($job->ivfs) || !empty($job->embryo_transfers) ) { ?>
    <h4><span class="glyphicon glyphicon-retweet"></span> <?= __('Related Data') ?></h4>
    <div id="accordion" role="tablist" aria-multiselectable="true" style="margin-left:35px;">

    <?php if (!empty($job->embryo_cryos)) { ?>
    <div class="panel panel-default horizontal-table">
    <a class="accord-head collapsed accord-head" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
        <div class="panel-heading alert-info" role="tab" id="headingOne">
          <h4 class="panel-title">
              Embryo Cryos <sup>(<?= count($job->embryo_cryos) ?>)</sup> <span class="caret"></span>
          </h4>
        </div>
        </a>
        <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
            <table class="table stripe order-column">
                <tr>
                    <th><?= __('EC#') ?></th>
                    <th><?= __('IVF#') ?></th>
                    <th><?= __('Cryo Date') ?></th>
                    <th><?= __('Stud ID') ?></th>
                    <th><?= __('Male Genotype') ?></th>
                    <th><?= __('Geno Confirmed') ?></th>
                    <th><?= __('ECGeno Confirmed') ?></th>
                    <th><?= __('# of Embryos') ?></th>
                    <th><?= __('Blast Rate') ?></th>
                    <th><?= __('EC By') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
                <?php $totalEmbryos = 0;
                foreach ($job->embryo_cryos as $embryoCryos) { ?>
                <tr>
                    <td><?= h($embryoCryos->id) ?></td>
                    <td><?= h($embryoCryos->ivf_id) ?></td>
                    <td><?= isset($embryoCryos->cryo_date) ? h($embryoCryos->cryo_date->format('Y-m-d')) : '-' ?></td>
                    <td><?= h($embryoCryos->stud_id_no) ?></td>
                    <td><?= h($embryoCryos->male_genotype) ?></td>
                    <td><?= $embryoCryos->genotype_confirmed ? __('<span class="bool-yes glyphicon glyphicon-ok"> Yes</span>') : __('<span class="bool-no glyphicon glyphicon-remove"> No</span>'); ?></td>
                    <td><?= $embryoCryos->embryogeno_confirmed ? __('<span class="bool-yes glyphicon glyphicon-ok"> Yes</span>') : __('<span class="bool-no glyphicon glyphicon-remove"> No</span>'); ?></td>
                    <td><?php if (!empty($embryoCryos)){
                        if ($embryoCryos->inventory_vials){
                            $embryoCount = 0;
                            foreach ($embryoCryos->inventory_vials as $vial) {
                                if ($vial->volume) {
                                    $embryoCount += $vial->volume;
                                }
                            }
                            echo $embryoCount;
                            $totalEmbryos += $embryoCount;
                        } else {
                            echo '0';
                        }} ?></td>
                    <td><?php if (!empty($embryoCryos)){
                        if (isset($embryoCryos->blasts_no) && isset($embryoCryos->cultured_no) ) {
                            if ($embryoCryos->cultured_no > 0) {
                                echo number_format( ($embryoCryos->blasts_no / $embryoCryos->cultured_no)*100,2) . '%';

                            }
                        } 
                        } ?></td>
                    <td><?= h($embryoCryos->ec_by) ?></td>
                    <td class="actions">
                        <?= '<span data-toggle="tooltip" title="View">'. $this->Html->link('<span class="pad-action-glyph glyphicon glyphicon-eye-open"></span>', ['action' => 'view', 'controller' => 'EmbryoCryos', $embryoCryos->id],  array('escape' => false, 'class' => 'label label-primary action-pad')) . '</span>' ?>
                        <?= '<span data-toggle="tooltip" title="Edit">'. $this->Html->link('<span class="pad-action-glyph glyphicon glyphicon-pencil"></span>', ['action' => 'edit', 'controller' => 'EmbryoCryos', $embryoCryos->id], array('escape' => false, 'class' => 'label label-success action-pad')) . '</span>' ?>                   
                    </td>
                </tr>
                <?php } ?>
<!--                 <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><?php= //echo $totalEmbryos; ?></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr> -->
            </table>
        </div>
      </div>
    <?php } ?>

    <?php if (!empty($job->embryo_resus)): ?> 
      <div class="panel panel-default horizontal-table">
        <a class="accord-head collapsed accord-head" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
        <div class="panel-heading alert-info" role="tab" id="headingTwo">
          <h4 class="panel-title">
              Embryo Resus <sup>(<?= count($job->embryo_resus) ?>)</sup> <span class="caret"></span>
          </h4>
        </div>
        </a>
        <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
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
        <a class="accord-head collapsed accord-head" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
        <div class="panel-heading alert-info" role="tab" id="headingThree">
          <h4 class="panel-title">
              Sperm Cryos <sup>(<?= count($job->sperm_cryos) ?>)</sup> <span class="caret"></span>
          </h4>
        </div>
        </a>
        <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
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
                        if ($vial->tissue != 1 && $vial->do_not_distribute != 1) {
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
        <a class="accord-head collapsed accord-head" data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
        <div class="panel-heading alert-info"" role="tab" id="headingFour">
          <h4 class="panel-title">
              IVF or ICSI <sup>(<?= count($job->ivfs) ?>)</sup> <span class="caret"></span>
          </h4>
        </div>
        </a>
        <div id="collapseFour" class="panel-collapse collapse role="tabpanel" aria-labelledby="headingFour">
            <table class="table stripe order-column">
                <tr>
                    <th><?= __('ID') ?></th>
                    <th><?= __('IVF date') ?></th>
                    <th><?= __('Stud ID') ?></th>
                    <th><?= __('State') ?></th>
                    <th><?= __('SC#') ?></th>
                    <th><?= __('CPA Lot#') ?></th>
                    <th><?= __('Prog Motility') ?></th>
                    <th><?= __('2-Cell') ?></th>
                    <th><?= __('Fert%') ?></th>
                    <th><?= __('IVF By') ?></th>
                    <th><?= __('ICSI') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
                <?php foreach ($job->ivfs as $ivfs): 
                    $fertRate = Null;
                    $twoCell = Null;
                    $oneCell = Null;
                    if (!empty($ivfs->ivf_dishes)){
                        foreach ($ivfs->ivf_dishes as $dish) {
                            if ($dish->two_cell_no) {
                                if ($twoCell) {
                                    $twoCell += $dish->two_cell_no;
                                } else {
                                    $twoCell = $dish->two_cell_no;
                                }
                            }
                            if ($dish->one_cell_no) {
                                if ($twoCell) {
                                    $oneCell += $dish->one_cell_no;
                                } else {
                                    $oneCell = $dish->one_cell_no;
                                }
                            }
                        }
                        if ($twoCell || $oneCell) {
                            $fertRate = ($twoCell/($twoCell+$oneCell))*100;
                        }
                    } 
                ?>
                <tr>
                    <td><?= h($ivfs->id) ?></td>
                    <td><?php if (isset($ivfs->ivf_date)) { echo h($ivfs->ivf_date->format('n/j/Y')); } ?></td>
                    <td><?= h($ivfs->stud_id_no) ?></td>
                    <td><?= h($ivfs->fresh_frozen) ?></td>
                    <td><?= h($ivfs->sperm_cryo_id) ?></td>
                    <td><?= h($ivfs->cpa_lot_no) ?></td>
                    <td><?= h($ivfs->cpa_fresh_prog_motality) ?></td>
                    <td><?= $twoCell ?></td>
                    <td><?= number_format($fertRate, 2).'%'; ?></td>
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
        <a class="accord-head collapsed accord-head" data-toggle="collapse" data-parent="#accordion" href="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
        <div class="panel-heading alert-info"" role="tab" id="headingFive">
          <h4 class="panel-title">
              Embryo Transfers <sup>(<?= count($job->embryo_transfers) ?>)</sup> <span class="caret"></span>
          </h4>
        </div>
        </a>
        <div id="collapseFive" class="panel-collapse collapse role="tabpanel" aria-labelledby="headingFive">
            <table class="table stripe order-column">
                <tr>
                    <th><?= __('ET ID') ?></th>
                    <th><?= __('ET Date') ?></th>
                    <th><?= __('Embryos') ?></th>
                    <th><?= __("Tx'd") ?></th>
                    <th><?= __('Pups?') ?></th>
                    <th><?= __('Pups#') ?></th>
                    <th><?= __('MutM') ?></th>
                    <th><?= __('MutF') ?></th>
                    <th><?= __('Recipients') ?></th>
                    <th><?= __('Litter %') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>

                <?php foreach ($job->embryo_transfers as $embryo_transfers):
                    $embryosCount = Null;
                    $malePups = Null;
                    $femalePups = Null;
                    $totalPups = 0;
                    $mutMales = Null;
                    $mutFemales = Null;
                    $totalMuts = 0;
                    $recipientCount = 0;
                    $litterCount = 0;
                    $litterRate = 0;
                    $birthRate = 0;
                    $pups = 'No';
                    if (!empty($embryo_transfers->recipients)){
                        foreach ($embryo_transfers->recipients as $rec) {
                            if ($rec->total_tx) {
                                if ($embryosCount) {
                                    $embryosCount += $rec->total_tx;
                                } else {
                                    $embryosCount = $rec->total_tx;
                                }
                            } 
                            if ($rec->male_pups) {
                                if ($malePups) {
                                    $malePups += $rec->male_pups;
                                } else {
                                    $malePups = $rec->male_pups;
                                }
                            } 
                            if ($rec->female_pups) {
                                if ($femalePups) {
                                    $femalePups += $rec->female_pups;
                                } else {
                                    $femalePups = $rec->female_pups;
                                }
                            } 
                            if ($rec->male_mut) {
                                if ($mutMales) {
                                    $mutMales += $rec->male_mut;
                                } else {
                                    $mutMales = $rec->male_mut;
                                }
                            }  
                            if ($rec->female_mut) {
                                if ($mutFemales) {
                                    $mutFemales += $rec->female_mut;
                                } else {
                                    $mutFemales = $rec->female_mut;
                                }
                            } 
                            $recipientCount +=1;
                            if ($rec->female_pups || $rec->male_pups) {
                                $litterCount += 1;
                            }       
                            if ($rec->pups_born == 1) {
                                $pups = 'Yes';
                            } elseif ($rec->pups_born == 2 && $pups == 'No') {
                                $pups = 'Pend';   
                            }               
                        }
                        if ($femalePups && $malePups) {
                            $totalPups = $femalePups+$malePups;
                        } elseif ($femalePups){
                            $totalPups = $femalePups;
                        } elseif ($malePups){
                            $totalPups = $malePups;
                        }
                        if ($mutFemales && $mutMales) {
                            $totalMuts = $mutFemales+$mutMales;
                        } elseif ($mutFemales){
                            $totalMuts = $mutFemales;
                        } elseif ($mutMales){
                            $totalMuts = $mutMales;
                        }
                        
                        if (!$embryosCount == 0) {
                            $birthRate = ($totalPups/$embryosCount)*100;
                        }
                        if (!$recipientCount == 0) {
                            $litterRate = ($litterCount/$recipientCount)*100;
                        }
                        if ($pups == 'No' || $pups == 'Pend') {
                            $malePups = '';
                            $femalePups = '';
                            $mutMales = '';
                            $mutFemales = '';
                            $totalPups = '';
                        }
                    } 
                 ?>
                <tr>
                    <td><?= h($embryo_transfers->id) ?></td>
                    <td><?php if (isset($embryo_transfers->et_date)) { echo h($embryo_transfers->et_date->format('n/j/Y')); } ?></td>
                    <td><?= h($embryo_transfers->fresh_frozen) ?></td>
                    <td><?= $embryosCount ?></td>
                    <td><?= $pups ?></td>
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

    <?php if (!empty($job->genotype_requests)): ?>
    <div class="panel panel-default horizontal-table">
        <a class="accord-head collapsed accord-head" data-toggle="collapse" data-parent="#accordion" href="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
        <div class="panel-heading alert-info"" role="tab" id="headingSix">
          <h4 class="panel-title">
              Genotyping Requests <sup>(<?= count($job->genotype_requests) ?>)</sup> <span class="caret"></span>
          </h4>
        </div>
        </a>
        <div id="collapseSix" class="panel-collapse collapse role="tabpanel" aria-labelledby="headingSix">
            <table class="table stripe order-column">
                <tr>
                    <th><?= __('Sample Type') ?></th>
                    <th><?= __('EC#') ?></th>
                    <th><?= __('SC#') ?></th>
                    <th><?= __('IVF#') ?></th>
                    <th><?= __('Submission Date') ?></th>
                    <th><?= __('Collection Date') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
                <?php foreach ($job->genotype_requests as $geno): ?>
                <tr>
                    <td><?= h($geno->sample_type)?></td>
                    <td><?php $typeArray = [];
                        foreach ($geno->genotypings as $gt) {
                            if ($gt->embryo_cryo_id) {
                                array_push($typeArray, $gt->embryo_cryo_id);
                            }
                        } 
                        echo implode(', ', $typeArray); ?></td>
                    <td><?php $typeArray = [];
                        foreach ($geno->genotypings as $gt) {
                            if ($gt->sperm_cryo_id) {
                                array_push($typeArray, $gt->sperm_cryo_id);
                            }
                        } 
                        echo implode(', ', $typeArray); ?></td>
                    <td><?php $typeArray = [];
                        foreach ($geno->genotypings as $gt) {
                            if ($gt->ivf_id) {
                                array_push($typeArray, $gt->ivf_id);
                            }
                        } 
                        echo implode(', ', $typeArray); ?></td>
                    <td><?php if (isset($geno->created)) { echo h($geno->created->format('n/j/Y')); } ?></td>
                    <td><?= h($geno->collection_date) ?></td>
                    <td class="actions">
                        <?= '<span data-toggle="tooltip" title="View">'. $this->Html->link('<span class="pad-action-glyph glyphicon glyphicon-eye-open"></span>', ['action' => 'view', 'controller' => 'genotype_requests', $geno->id, '?print'],  array('escape' => false, 'class' => 'label label-primary action-pad')) . '</span>' ?>
                        <?= '<span data-toggle="tooltip" title="Edit">'. $this->Html->link('<span class="pad-action-glyph glyphicon glyphicon-pencil"></span>', ['action' => 'edit', 'controller' => 'genotype_requests', $geno->id], array('escape' => false, 'class' => 'label label-success action-pad')) . '</span>' ?>
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
<?php 
echo $this->Html->link('<span class="glyphicon glyphicon-plus"></span> ' . __('Genotyping Request'), ['controller' => 'GenotypeRequests', 'action' => 'add', $job->id], array('escape' => false, 'class' => 'btn btn-info pull-left', 'style' => 'margin-left:10px;'));
?>
</div>
<?php
 echo $this->Html->link('' . __('Go back to all Jobs'), ['controller' => 'Jobs', 'action' => 'index'], array(
        'escape' => false,
        'class' => 'btn btn-default',
        'style' => 'margin-left:10px'

    ));
?>
<div class="clearfix"></div>
<?= $this->ChangeLog->displayChangeLog($changes) ?>