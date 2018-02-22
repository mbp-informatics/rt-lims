<script>
$( document ).ready(function() {
    /* Initiate jQuery UI dialogs/modals */
    var etId = <?= $embryoTransfer->id ?>;
    iniDialog('#add-recipient', '/recipients/add/', etId);
});   
</script>

<?php if ($source == 'mtgl') { ?>
<div class="embryoTransfers view large-9 medium-8 columns content">
    <h3><?= __('Embryo Transfer')." ".h($embryoTransfer->id) ?>
        <?php
        echo $this->html->link('<span class="glyphicon glyphicon-pencil"></span> ' . __('Edit Embryo Transfer'), ['controller' => 'embryoTransfers', 'action' => 'edit', $embryoTransfer->id, 'mtgl'], array('escape' => false, 'class' => 'btn btn-warning pull-right','style' => 'margin-left:10px;'));
        ?>
        <?php
        echo $this->html->link('<span class="glyphicon glyphicon-share-alt"></span> ' . __('Switch to MICL View'), ['controller' => 'embryoTransfers', 'action' => 'view', $embryoTransfer->id], array('escape' => false, 'class' => 'btn btn-warning pull-right','style' => 'margin-left:10px;'));
        ?>
    </h3>
    <div class='alert alert-info' role='alert'>Embryo Source</div>
    <div class='container-fluid'>
        <div class='row'>  
            <div class='col-xs-3'><strong><?= __('Injection ID') ?>: </strong><?= $embryoTransfer->has('injection') ? $this->Html->link($embryoTransfer->injection->id, ['controller' => 'Injections', 'action' => 'view', $embryoTransfer->injection->id]) : '' ?></div>
            <div class='col-xs-3'><strong><?= __('Strain Name') ?>: </strong><?= $embryoTransfer->has('injection') ? h($embryoTransfer->injection->donor_strain)  : '' ?></div>
            <div class='col-xs-3'><strong><?= __('Investigator') ?>: </strong><?= $embryoTransfer->has('injection') ? h($embryoTransfer->injection->investigator)  : '' ?></div>
            <!-- <div class='col-xs-3'><strong><?= __('Lab Contact') ?>: </strong><?= h($embryoTransfer->lab_contact) ?></div> -->
        </div>
    </div>
    <div class='alert alert-info' role='alert'>Transfer Information</div>        
    <div class='container-fluid'>
        <div class='row'>            
            <div class='alert alert-success col-xs-4'><strong><?= __('ET #') ?>: </strong><?= h($embryoTransfer->id) ?></div>
        </div>
        <div class='row'>    
            <div class='col-xs-3'><strong><?= __('ET By') ?>: </strong><?= h($embryoTransfer->et_by) ?></div>
            <div class='col-xs-3'><strong><?= __('ET Date') ?>: </strong><?php if (isset($embryoTransfer->et_date)) { echo h($embryoTransfer->et_date->format('n/j/Y')); } ?></div>
            <div class='col-xs-3'><strong><?= __('ET Time') ?>: </strong><?php if (isset($embryoTransfer->et_time)) { echo h($embryoTransfer->et_time->format('g:i A')); } ?></div>
            <div class='col-xs-3'><strong><?= __('ET Location') ?>: </strong><?= h($embryoTransfer->et_location) ?></div>
        </div>
        <div class='row'>    
            <div class='col-xs-4'><strong><?= __('ET Lab') ?>: </strong><?= h($embryoTransfer->et_lab) ?></div>
            <div class='col-xs-4'><strong><?= __('Expected DOB') ?>: </strong><?php if (isset($embryoTransfer->expected_dob)) { echo h($embryoTransfer->expected_dob->format('n/j/Y')); } ?></div>
            <div class='col-xs-4'><strong><?= __('Recipient Strain') ?>: </strong><?= h($embryoTransfer->recipient_strain) ?></div> 
        </div>
        <div class='row'>           
            <div class='col-xs-6'><strong><?= __('Anesthetic') ?>: </strong><?= h($embryoTransfer->anesthetic) ?> (<em>Lot #<?= h($embryoTransfer->anesthetic_lot_no) ?> </em>)</div>
            <div class='col-xs-6'><strong><?= __('Analgesic') ?>: </strong><?= h($embryoTransfer->analgesic) ?> (<em>Lot #<?= h($embryoTransfer->analgesic_lot_no) ?> </em>)</div>
        </div>
        <hr/>
        <div class="row">
            <div class='col-xs-12'><strong><?= __('Comments') ?>: </strong><?= $this->Text->autoParagraph(h($embryoTransfer->comments)); ?></div>
        </div>
    </div>


    <div class='alert alert-info' role='alert'>Meta</div>        
    <div class='container-fluid'>
        <div class='row'>
            <div class='col-xs-4'><strong><?= __('Created') ?>: </strong><?= h($embryoTransfer->created) ?></div>
            <div class='col-xs-4'><strong><?= __('Modified') ?>: </strong><?= h($embryoTransfer->modified) ?></div>
            <div class='col-xs-4'><strong><?= __('User') ?>: </strong><?= $embryoTransfer->has('user') ? $this->Html->link($embryoTransfer->user->name, ['controller' => 'Users', 'action' => 'view', $embryoTransfer->user->id]) : '' ?></div>
        </div>
    </div>

<?php } else { ?>

<div class="embryoTransfers view large-9 medium-8 columns content">
    <h3><?= __('Embryo Transfer')." ".h($embryoTransfer->id) ?>
        <?php
        echo $this->html->link('<span class="glyphicon glyphicon-pencil"></span> ' . __('Edit Embryo Transfer'), ['controller' => 'embryoTransfers', 'action' => 'edit', $embryoTransfer->id], array('escape' => false, 'class' => 'btn btn-warning pull-right','style' => 'margin-left:10px;'));
        ?>
        <?php
        echo $this->html->link('<span class="glyphicon glyphicon-share-alt"></span> ' . __('Switch to MTGL View'), ['controller' => 'embryoTransfers', 'action' => 'view', $embryoTransfer->id, 'mtgl'], array('escape' => false, 'class' => 'btn btn-warning pull-right','style' => 'margin-left:10px;'));
        ?>
    </h3>
    <div class='alert alert-info' role='alert'>Embryo Source</div>
    <div class='container-fluid'>
        <div class='row'>
            <div class='col-xs-3'><strong><?= __('Job') ?>: </strong><?= $embryoTransfer->has('job') ? $this->Html->link($embryoTransfer->job->id, ['controller' => 'Jobs', 'action' => 'view', $embryoTransfer->job->id]) : '' ?></div>
            <div class='col-xs-3'><strong><?= __('Embryo RS') ?>: </strong><?= $embryoTransfer->has('embryo_resus') ? $this->Html->link($embryoTransfer->embryo_resus->id, ['controller' => 'EmbryoResus', 'action' => 'view', $embryoTransfer->embryo_resus->id]) : '' ?></div>
            <div class='col-xs-3'><strong><?= __('IVF') ?>: </strong><?= $embryoTransfer->has('ivf') ? $this->Html->link($embryoTransfer->ivf->id, ['controller' => 'Ivfs', 'action' => 'view', $embryoTransfer->ivf->id]) : '' ?></div>      
            <div class='col-xs-3'><strong><?= __('Injection ID') ?>: </strong><?= $embryoTransfer->has('injection') ? $this->Html->link($embryoTransfer->injection->id, ['controller' => 'Injections', 'action' => 'view', $embryoTransfer->injection->id]) : '' ?></div>
        </div>
        
        <div class='row'>        
            <div class='col-xs-4'><strong><?= __('BL #') ?>: </strong><?= h($embryoTransfer->bl_no) ?></div>
            <div class='col-xs-4'><strong><?= __('PN/CR #') ?>: </strong><?= h($embryoTransfer->pn_cr_no) ?></div>
            <div class='col-xs-4'><strong><?= __('Membership') ?>: </strong><?= h($embryoTransfer->membership) ?></div> 
        </div>
        
        <div class='row'>                   
            <div class='col-xs-4'><strong><?= __('PTS/KO/MO #') ?>: </strong>
                <?= h(isset($embryoTransfer->job) ? $embryoTransfer->job->order_no : '') ?>
            </div>
            <div class='col-xs-4'><strong><?= __('CRISPR') ?>: </strong><?= $embryoTransfer->crispr ? __('<span class="bool-yes glyphicon glyphicon-ok"> Yes</span>') : __('<span class="bool-no glyphicon glyphicon-remove"> No</span>'); ?></div>    
            <div class='col-xs-4'><strong><?= __('ET Purpose') ?>: </strong><?= h($embryoTransfer->et_purpose) ?></div>
        </div>
        
        <div class='row'>
            <div class='col-xs-2'><strong><?= __('EC #') ?>: </strong><?= $embryoTransfer->has('embryo_cryo') ? $this->Html->link($embryoTransfer->embryo_cryo->id, ['controller' => 'EmbryoCryos', 'action' => 'view', $embryoTransfer->embryo_cryo->id]) : '' ?></div>
            <div class='col-xs-2'><strong><?= __('Straw #') ?>: </strong><?= $embryoTransfer->has('embryo_resus') ? $this->Html->link($embryoTransfer->embryo_resus->straw_no, ['controller' => 'EmbryoResus', 'action' => 'view', $embryoTransfer->embryo_resus->id]) : '' ?></div>
            <div class='col-xs-2'><strong><?= __("# EC'd") ?>: </strong><?= $embryoTransfer->has('embryo_resus') ? $this->Html->link($embryoTransfer->embryo_resus->embryo_no, ['controller' => 'EmbryoResus', 'action' => 'view', $embryoTransfer->embryo_resus->id]) : '' ?></div>
            <div class='col-xs-2'><strong><?= __('# Recovered') ?>: </strong><?= $embryoTransfer->has('embryo_resus') ? $this->Html->link($embryoTransfer->embryo_resus->recovered_no, ['controller' => 'EmbryoResus', 'action' => 'view', $embryoTransfer->embryo_resus->id]) : '' ?></div>
            <div class='col-xs-2'><strong><?= __('# Bad') ?>: </strong><?= $embryoTransfer->has('embryo_resus') ? $this->Html->link($embryoTransfer->embryo_resus->bad_no, ['controller' => 'EmbryoResus', 'action' => 'view', $embryoTransfer->embryo_resus->id]) : '' ?></div>
            <div class='col-xs-2'><strong><?= __('# Intact') ?>: </strong><?= $embryoTransfer->has('embryo_resus') ? $this->Html->link($embryoTransfer->embryo_resus->intact_no, ['controller' => 'EmbryoResus', 'action' => 'view', $embryoTransfer->embryo_resus->id]) : '' ?></div>
        </div>
        <div class='row'>
            <div class='col-xs-4'><strong><?= __('Investigator') ?>: </strong><?= h($embryoTransfer->pi) ?></div>
        </div>
    </div>
    <div class='alert alert-info' role='alert'>Strain Information</div>        
    <div class='container-fluid'>
        <div class='row'>
            <div class='col-xs-4'><strong><?= __('Strain Name') ?>: </strong><?= h($embryoTransfer->strain_name) ?></div>
            <div class='col-xs-4'><strong><?= __('MMRRC #') ?>: </strong><?= h($embryoTransfer->mmrrc_no) ?></div>
            <div class='col-xs-4'><strong><?= __('Investigator') ?>: </strong><?= h($embryoTransfer->investigator) ?></div>
        </div>

        <?php 
        if ($embryoTransfer->job) {
        if ($embryoTransfer->job->targeting_conf == 1) {
                $targetConf = 'Yes';
            } elseif ($embryoTransfer->job->targeting_conf == 0){
                $targetConf = 'No';
            } else {
                $targetConf = '';
            }
        ?>        
        <div class='row'>
            <div class='col-xs-4'><strong><?= __('Egg Donors') ?>: </strong><?= h($embryoTransfer->job->egg_donors) ?></div>
            <div class='col-xs-4'><strong><?= __('Genotype') ?>: </strong><?= h($embryoTransfer->job->genotype) ?></div>
            <div class='col-xs-4'><strong><?= __('Targeting Confirmation?') ?>: </strong><?= $targetConf ?></div>
        </div>
        <?php } ?>
        <div class='row'>
            <div class='col-xs-4'><strong><?= __('Lab Contact') ?>: </strong><?= h($embryoTransfer->lab_contact) ?></div>
            <div class='col-xs-4'><strong><?= __('Background') ?>: </strong><?= h($embryoTransfer->background) ?></div>
            <div class='col-xs-4'><strong><?= __('KOMP Clone') ?>: </strong><?= h($embryoTransfer->job->esc_clone_id_no) ?></div>
        </div>
    </div>

    <div class='alert alert-info' role='alert'>Transfer Information</div>        
    <div class='container-fluid'>
        <div class='row'>            
            <div class='alert alert-success col-xs-4'><strong><?= __('ET #') ?>: </strong><?= h($embryoTransfer->id) ?></div>
        </div>
        
        <div class='row'>    
            <div class='col-xs-4'><strong><?= __('ET By') ?>: </strong><?= h($embryoTransfer->et_by) ?></div>
            <div class='col-xs-4'><strong><?= __('ET Location') ?>: </strong><?= h($embryoTransfer->et_location) ?></div>    
            <div class='col-xs-3'><strong><?= __('ET Date') ?>: </strong><?php if (isset($embryoTransfer->et_date)) { echo h($embryoTransfer->et_date->format('n/j/Y')); } ?></div>
        </div>
        
        <div class='row'>    
            <div class='col-xs-4'><strong><?= __('ET Time') ?>: </strong><?php if (isset($embryoTransfer->et_time)) { echo h($embryoTransfer->et_time->format('g:i A')); } ?></div>
            <div class='col-xs-4'><strong><?= __('ET Lab') ?>: </strong><?= h($embryoTransfer->et_lab) ?></div>
            <div class='col-xs-4'><strong><?= __('Expected DOB') ?>: </strong><?php if (isset($embryoTransfer->expected_dob)) { echo h($embryoTransfer->expected_dob->format('n/j/Y')); } ?></div>
        </div>
        
        <div class='row'>
            <div class='col-xs-4'><strong><?= __('Fresh/Frozen') ?>: </strong><?= h($embryoTransfer->fresh_frozen) ?></div>
            <div class='col-xs-4'><strong><?= __('ICSI Embryos') ?>: </strong><?= $embryoTransfer->icsi_embryos ? __('<span class="bool-yes glyphicon glyphicon-ok"> Yes</span>') : __('<span class="bool-no glyphicon glyphicon-remove"> No</span>'); ?></div>
            <div class='col-xs-4'><strong><?= __('Assisted IVF Embryos') ?>: </strong><?= h($embryoTransfer->assisted_ivf_embryos) ?></div>
        </div>
        
        <div class='row'>
            <div class='col-xs-2'><strong><?= __('Save Pups?') ?>: </strong><?= $embryoTransfer->save_pups ? __('<span class="bool-yes glyphicon glyphicon-ok"> Yes</span>') : __('<span class="bool-no glyphicon glyphicon-remove"> No</span>'); ?></div>
            <div class='col-xs-2'><strong><?= __('Send Tails To') ?>: </strong><?= h($embryoTransfer->send_tails_to) ?></div>          
            <div class='col-xs-4'><strong><?= __('Anesthetic') ?>: </strong><?= h($embryoTransfer->anesthetic) ?> <em>Lot #<?= h($embryoTransfer->anesthetic_lot_no) ?></em></div>
            <div class='col-xs-4'><strong><?= __('Analgesic') ?>: </strong><?= h($embryoTransfer->analgesic) ?> <em>Lot #<?= h($embryoTransfer->analgesic_lot_no) ?></em></div>
        </div>
        <hr/>
        <div class="row">
            <div class='col-xs-12'><strong><?= __('Comments') ?>: </strong><?= $this->Text->autoParagraph(h($embryoTransfer->comments)); ?></div>
        </div>
    </div>

    <div class='alert alert-info' role='alert'>Pups Information</div>        
    <div class='container-fluid'>
        <div class='row'> 
            <div class='col-xs-4'><strong><?= __('Maternity Updated By') ?>: </strong><?= h($embryoTransfer->maternity_updated_by) ?></div>
            <div class='col-xs-4'><strong><?= __('Pup Genotype Updated By') ?>: </strong><?= h($embryoTransfer->pup_genotype_updated_by) ?></div>
            <!-- <div class='col-xs-4'><strong><?= __('Search') ?>: </strong><?= h($embryoTransfer->search) ?></div> -->
        </div>
            <?php 
                $embryosCount = Null;
                $malePups = Null;
                $femalePups = Null;
                $mutMales = Null;
                $mutFemales = Null;
                $recipientCount = 0;
                $litterCount = 0;
                $litterRate = 0;
                $birthRate = 0;
                $pups = 'No';

                if (!empty($embryoTransfer->recipients)){
                    foreach ($embryoTransfer->recipients as $rec) {
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
                    } else {
                        $totalPups = '';
                    }
                    if ($mutFemales && $mutMales) {
                        $totalMuts = $mutFemales+$mutMales;
                    } elseif ($mutFemales){
                        $totalMuts = $mutFemales;
                    } elseif ($mutMales){
                        $totalMuts = $mutMales;
                    } else {
                        $totalMuts = '';
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
                    }
                } 
            ?>        
        <div class='row'>
            <div class='col-xs-4'><strong><?= __("Total Embryos Tx'd") ?>: </strong><?php echo $embryosCount ?></div>
            <div class='col-xs-4'><strong><?= __('ET Birth Rate') ?>: </strong><?php echo round($birthRate, 2) ?>%</div>
            <div class='col-xs-4'><strong><?= __('Pups?') ?>: </strong><?php echo $pups ?></div> 
        </div>
        
        <div class='row'>
            <div class='col-xs-4'><strong><?= __('Total Male Pups') ?>: </strong><?php echo $malePups ?></div>
            <div class='col-xs-4'><strong><?= __('Total Female Pups') ?>: </strong><?php echo $femalePups ?></div>
            <div class='col-xs-4'><strong><?= __('Total Pups Born') ?>: </strong><?php echo $totalPups ?></div>
        </div>
        
        <div class='row'>
            <div class='col-xs-4'><strong><?= __('Total Mut Males') ?>: </strong><?php echo $mutMales ?></div>
            <div class='col-xs-4'><strong><?= __('Total Mut Females') ?>: </strong><?php echo $mutFemales ?></div>           
            <div class='col-xs-4'><strong><?= __('Total Mut Mice') ?>: </strong><?php echo $totalMuts ?></div>
        </div>
        
        <div class='row'>
            <div class='col-xs-4'><strong><?= __('# Recipients') ?>: </strong><?php echo $recipientCount ?></div>
            <div class='col-xs-4'><strong><?= __('# Litters') ?>: </strong><?php echo $litterCount ?></div>
            <div class='col-xs-4'><strong><?= __('Litter Rate') ?>: </strong><?php echo round($litterRate, 2) ?>%</div>    
                              
        </div>
    </div>

    <div class='alert alert-info' role='alert'>Recharge Information</div>        
    <div class='container-fluid'>
        <div class='row'>
            <div class='col-xs-4'><strong><?= __('Primary Recharge') ?>: </strong><?= h($embryoTransfer->primary_recharge) ?></div>
            <div class='col-xs-4'><strong><?= __('Secondary Recharge') ?>: </strong><?= h($embryoTransfer->secondary_recharge) ?></div>
        </div>
    </div>

    <div class='alert alert-info' role='alert'>Meta</div>        
    <div class='container-fluid'>
        <div class='row'>
            <div class='col-xs-4'><strong><?= __('Created') ?>: </strong><?= h($embryoTransfer->created) ?></div>
            <div class='col-xs-4'><strong><?= __('Modified') ?>: </strong><?= h($embryoTransfer->modified) ?></div>
            <div class='col-xs-4'><strong><?= __('User') ?>: </strong><?= $embryoTransfer->has('user') ? $this->Html->link($embryoTransfer->user->name, ['controller' => 'Users', 'action' => 'view', $embryoTransfer->user->id]) : '' ?></div>
        </div>
    </div>

<?php }; ?>

    <hr>
    <?php if (!empty($embryoTransfer->recipients)): ?>
    <div id="related-recipients" class="related horizontal-table table-responsive">
        <h4><?= __('<span class="glyphicon glyphicon-edit"></span> Related Recipients') ?></h4>
            <table class="table stripe order-column">
                <tr>
                    <th><?= __('ID') ?></th>
                    <th><?= __('Ear Mark') ?></th>
                    <th><?= __('Weight') ?></th>
                    <th><?= __('DOB') ?></th>
                    <th><?= __('Embryo Stage') ?></th>
                    <th><?= __('Anesthetic') ?></th>
                    <th><?= __('Analgesic (mL)') ?></th>
                    <th><?= __('Cl') ?></th>
                    <th><?= __('Amp') ?></th>
                    <th><?= __('Tx L') ?></th>
                    <th><?= __('Tx R') ?></th>
                    <th><?= __('Total Tx') ?></th>
                    <th><?= __('Male Pups') ?></th>
                    <th><?= __('Female Pups') ?></th>
                    <th><?= __('Total Pups') ?></th>
                    <th><?= __('Male Mut') ?></th>
                    <th><?= __('Female Mut') ?></th>
                    <th><?= __('Pups Born') ?></th>
                    <th><?= __('ET By') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            <?php foreach ($embryoTransfer->recipients as $recipients): ?>
                <tr>
                    <td><?= h($recipients->id) ?></td>
                    <td><?= h($recipients->ear_mark) ?></td>
                    <td><?= h($recipients->weight) ?></td>
                    <td><?php if (isset($recipients->dob)) { echo h($recipients->dob->format('n/j/Y')); } ?></td>
                    <td><?= h($recipients->embryo_stage) ?></td>
                    <td><?= h($recipients->anesthetic_vol) ?> <?= h($recipients->anesthetic_vol_type) ?></td>
                    <td><?= h($recipients->analgesic_vol) ?></td>
                    <td><?= $recipients->cl ? __('Yes') : __('No'); ?></td>
                    <td><?= $recipients->amp ? __('Yes') : __('No'); ?></td>
                    <td><?= h($recipients->tx_l) ?></td>
                    <td><?= h($recipients->tx_r) ?></td>
                    <td><?= h($recipients->total_tx) ?></td>
                    <td><?= h($recipients->male_pups) ?></td>
                    <td><?= h($recipients->female_pups) ?></td>
                    <td><?= h($recipients->total_pups) ?></td>
                    <td><?= h($recipients->male_mut) ?></td>
                    <td><?= h($recipients->female_mut) ?></td>
                    <?php if ($recipients->pups_born == 1) {
                            $pupsborn = 'Yes';
                        } elseif ($recipients->pups_born == 0){
                            $pupsborn = 'No';
                        } elseif ($recipients->pups_born == 2){
                            $pupsborn = 'Pending';
                        } else {
                            $pupsborn = '';
                        }
                        ?>
                    <td><?= $pupsborn; ?></td>
                    <td><?= h($recipients->et_by) ?></td>
                    <td class="actions">
                        <?= '<span data-toggle="tooltip" title="View">'. $this->Html->link('<span class="pad-action-glyph glyphicon glyphicon-eye-open"></span>', ['action' => 'view', 'controller' => 'recipients', $recipients->id],  array('escape' => false, 'class' => 'label label-primary action-pad')) . '</span>' ?>
                        <?= '<span data-toggle="tooltip" title="Edit">'. $this->Html->link('<span class="pad-action-glyph glyphicon glyphicon-pencil"></span>', ['action' => 'edit', 'controller' => 'recipients', $recipients->id], array('escape' => false, 'class' => 'label label-success action-pad')) . '</span>' ?>
                        <?= '<span data-toggle="tooltip" title="Delete">'. $this->Form->postLink('<span class="pad-action-glyph glyphicon glyphicon glyphicon-trash"></span> ', ['action' => 'delete', 'controller' => 'recipients', $recipients->id], ['escape' => false, 'class' => 'label label-danger action-pad', 'confirm' => __('Are you sure you want to delete # {0}?', $embryoTransfer->id)]) . '</span>' ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
    <hr/>
    <?php endif; ?>
    <?php
        if ($source == 'mtgl') { 
            echo $this->Html->link('<span class="glyphicon glyphicon-plus"></span> ' . __('Add Recipient'), ['controller' => 'Recipients', 'action' => 'add', $embryoTransfer->id, 'mtgl'], array('escape' => false, 'class' => 'btn btn-warning pad-button'));
        } 
        else {
            echo $this->Html->link('<span class="glyphicon glyphicon-plus"></span> ' . __('Add Recipient'), ['controller' => 'Recipients', 'action' => 'add', $embryoTransfer->id], array('escape' => false, 'class' => 'btn btn-warning pad-button'));
        }
        echo $this->Html->link('<span class="glyphicon glyphicon-save-file"></span> '.__('View Post-OP sheet'), ['controller' => 'EmbryoTransfers', 'action' => 'post_op', $embryoTransfer->id], array('escape' => false, 'class' => 'btn btn-success pad-button'));

        if (isset( $embryoTransfer->job->id)) {
            echo $this->Html->link('<span class="glyphicon glyphicon-arrow-left"></span> '.__('Go Back to Job'), ['controller' => 'Jobs', 'action' => 'view', $embryoTransfer->job->id], array('escape' => false, 'class' => 'btn btn-default pad-button'));
        }
    ?>
</div>

<div class="clearfix"></div>
<?= $this->ChangeLog->displayChangeLog($changes) ?>