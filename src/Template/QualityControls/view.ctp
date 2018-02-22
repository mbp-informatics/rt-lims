<div class="qualityControls view large-9 medium-8 columns content">
    <h3><?= __('QualityControl')." #".h($qualityControl->id) ?>
        <?php
        echo $this->html->link('<span class="glyphicon glyphicon-pencil"></span> ' . __('Edit Quality Control'), ['controller' => 'QualityControls', 'action' => 'edit', $qualityControl->id], array('escape' => false, 'class' => 'btn btn-warning pull-right','style' => 'margin-left:10px;'));
        ?>
    </h3>
    <div class='container-fluid'>
        <div class='row'>
            <div class='col-xs-3'><strong><?= __('ES Cell') ?>: </strong><?= $qualityControl->has('es_cells') ? $this->Html->link($qualityControl->es_cells->inventory_vial->label, ['controller' => 'EsCells', 'action' => 'view', $qualityControl->es_cells->id]) : '' ?></div>
            <div class='col-xs-3'><strong><?= __('ID') ?>: </strong><?= h($qualityControl->id) ?></div>
            <div class='col-xs-3'><strong><?= __('Started By') ?>: </strong><?= h($qualityControl->started_by) ?></div>
            <div class='col-xs-3'><strong><?= __('Finished By') ?>: </strong><?= h($qualityControl->finished_by) ?></div>
            <div class='col-xs-3'><strong><?= __('Pass') ?>: </strong><?= h($qualityControl->pass) ?></div>
            <div class='col-xs-3'><strong><?= __('Assigned QC') ?>: </strong><?= h($qualityControl->assigned_qc) ?></div>
            <div class='col-xs-3'><strong><?= __('Purpose') ?>: </strong><?= h($qualityControl->purpose) ?></div>
            <div class='col-xs-3'><strong><?= __('Started') ?>: </strong><?= h($qualityControl->started) ?></div>
            <div class='col-xs-3'><strong><?= __('Finished') ?>: </strong><?= h($qualityControl->finished) ?></div>
            <div class='col-xs-3'><strong><?= __('Created') ?>: </strong><?= h($qualityControl->created) ?></div>
            <div class='col-xs-3'><strong><?= __('Modified') ?>: </strong><?= h($qualityControl->modified) ?></div>
        </div>
        <div class="panel panel-primary">    
            <form method="post" action="/quality-controls/request-tests">
                <div class='row'>
                    <div class='col-xs-4'>
                        <div class="checkbox"><label><input type="checkbox" name="qcInVivo" value="invivo">Request Customer in Vivo</label></div>
                        <div class="checkbox"><label><input type="checkbox" name="qcGeno" value="geno">Request Genotyping</label></div>
                        <div class="checkbox"><label><input type="checkbox" name="qcGerm" value="germ">Request Germlines</label></div>
                        <div class="checkbox"><label><input type="checkbox" name="qcGrowth" value="growth">Request Viable Growth Morphology</label></div>
                    </div>
                    <div class='col-xs-4'>
                        <div class="checkbox"><label><input type="checkbox" name="qcMicro" value="micro">Request Microinjections</label></div>
                        <div class="checkbox"><label><input type="checkbox" name="qcPath" value="path">Request Pathogens</label></div>
                        <div class="checkbox"><label><input type="checkbox" name="qcKaryo" value="karyo">Request Karyotyping</label></div>
                    </div>
                    <div class='col-xs-4'>
                        <div class="checkbox"><label><input type="checkbox" name="qcReseq" value="reseq">Request Resequencing</label></div>
                        <div class="checkbox"><label><input type="checkbox" name="qcTmk" value="tmk">Request TaqMan Karyotyping</label></div>
                        <div class="checkbox"><label><input type="checkbox" name="qcCre" value="cre">Request Cre Flips</label></div>
                    </div>
                </div>
                <?php
                    echo $this->Form->hidden('user_id', [
                        'options' => $users,
                        'default' => $this->request->session()->read('Auth.User.id')
                        ]);

                    echo $this->Form->hidden('quality_control_id', [
                        'value' => $qualityControlId,
                        'type' => 'text'
                        ]);
                ?>
                <div class='row'>
                    <div class='col-xs-4'>
                        <?= $this->Form->button(__('Submit'),
                            array(
                                'class' => 'btn btn-primary',
                                'div' => false
                                )); ?>
                        <?= $this->Form->end() ?>
                    </div>
                </div>
            </form>
        </div>
        <?php if (!empty($qualityControl->qc_tmks) or !empty($qualityControl->qc_genotypes) or !empty($qualityControl->qc_creflips) or !empty($qualityControl->qc_customer_invivos) or !empty($qualityControl->qc_germlines) or !empty($qualityControl->qc_growths) or !empty($qualityControl->qc_karyotypes) or !empty($qualityControl->qc_microinjections) or !empty($qualityControl->qc_pathogens) or !empty($qualityControl->qc_resequencings)) { ?>
        <div class="panel panel-primary">   
            <div class='col-xs-12'>
                <div class="large-9 medium-8 columns content horizontal-table">
                    <table class="table stripe ">
                        <thead>
                            <tr>
                                <th>QC Type</th>
                                <th>Progress</th>
                                <th>Started On</th>
                                <th>Started By</th>
                                <th>Finished On</th>
                                <th>Finished By</th>
                                <th class="actions"><?= __('Actions') ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($qualityControl->qc_genotypes)) {
                                foreach ($qualityControl->qc_genotypes as $geno) { ?>
                                    <tr>
                                        <td>Genotype</td>
                                        <?php if ($geno->pass == "Passed") { ?><td style="background-color:palegreen"> <?php } elseif ($geno->pass == "Failed"){ ?><td style="background-color:#cc0000;color:#ffffff"> <?php } elseif ($geno->pass == "Inconclusive"){ ?><td style="background-color:#ffff99"> <?php } else { ?><td>  <?php }; ?><?= h($geno->pass) ?></td>
                                        <td><?= h($geno->started) ?></td>
                                        <td><?= h($geno->started_by) ?></td>
                                        <td><?= h($geno->finished) ?></td>                
                                        <td><?= h($geno->finished_by) ?></td>
                                        <td class="actions">
                                        <?= '<span data-toggle="tooltip" title="View">'. $this->Html->link('<span class="pad-action-glyph glyphicon glyphicon-eye-open"></span>', ['controller'=> 'QcGenotypes', 'action' => 'view', $geno->id],  array('escape' => false, 'class' => 'label label-primary action-pad')) . '</span>' ?>
                                        <?= '<span data-toggle="tooltip" title="Edit">'. $this->Html->link('<span class="pad-action-glyph glyphicon glyphicon-pencil"></span>', ['controller'=> 'QcGenotypes', 'action' => 'edit', $geno->id], array('escape' => false, 'class' => 'label label-success action-pad')) . '</span>' ?>
                                        </td>
                                    </tr>
                            <?php };}; ?>
                            <?php if (!empty($qualityControl->qc_creflips)) {
                                foreach ($qualityControl->qc_creflips as $cre) { ?>
                                    <tr>
                                        <td>CreFlip</td>
                                        <?php if ($cre->pass == "Passed") { ?><td style="background-color:palegreen"> <?php } elseif ($cre->pass == "Failed"){ ?><td style="background-color:#cc0000;color:#ffffff"> <?php } elseif ($cre->pass == "Inconclusive"){ ?><td style="background-color:#ffff99"> <?php } else { ?><td>  <?php }; ?><?= h($cre->pass) ?></td>
                                        <td><?= h($cre->started) ?></td>
                                        <td><?= h($cre->started_by) ?></td>
                                        <td><?= h($cre->finished) ?></td>                
                                        <td><?= h($cre->finished_by) ?></td>
                                        <td class="actions">
                                        <?= '<span data-toggle="tooltip" title="View">'. $this->Html->link('<span class="pad-action-glyph glyphicon glyphicon-eye-open"></span>', ['controller'=> 'QcCreflips', 'action' => 'view', $cre->id],  array('escape' => false, 'class' => 'label label-primary action-pad')) . '</span>' ?>
                                        <?= '<span data-toggle="tooltip" title="Edit">'. $this->Html->link('<span class="pad-action-glyph glyphicon glyphicon-pencil"></span>', ['controller'=> 'QcCreflips', 'action' => 'edit', $cre->id], array('escape' => false, 'class' => 'label label-success action-pad')) . '</span>' ?>
                                        </td>                                        
                                    </tr>
                            <?php };}; ?>   
                            <?php if (!empty($qualityControl->qc_customer_invivos)) {
                                foreach ($qualityControl->qc_customer_invivos as $inv) { ?>
                                    <tr>
                                        <td>Customer inVivo</td>
                                        <?php if ($inv->pass == "Passed") { ?><td style="background-color:palegreen"> <?php } elseif ($inv->pass == "Failed"){ ?><td style="background-color:#cc0000;color:#ffffff"> <?php } elseif ($inv->pass == "Inconclusive"){ ?><td style="background-color:#ffff99"> <?php } else { ?><td>  <?php }; ?><?= h($inv->pass) ?></td>
                                        <td><?= h($inv->started) ?></td>
                                        <td><?= h($inv->started_by) ?></td>
                                        <td><?= h($inv->finished) ?></td>                
                                        <td><?= h($inv->finished_by) ?></td>
                                        <td class="actions">
                                        <?= '<span data-toggle="tooltip" title="View">'. $this->Html->link('<span class="pad-action-glyph glyphicon glyphicon-eye-open"></span>', ['controller'=> 'QcCustomerInvivos', 'action' => 'view', $inv->id],  array('escape' => false, 'class' => 'label label-primary action-pad')) . '</span>' ?>
                                        <?= '<span data-toggle="tooltip" title="Edit">'. $this->Html->link('<span class="pad-action-glyph glyphicon glyphicon-pencil"></span>', ['controller'=> 'QcCustomerInvivos', 'action' => 'edit', $inv->id], array('escape' => false, 'class' => 'label label-success action-pad')) . '</span>' ?>
                                        </td>                                        
                                    </tr>
                                    </tr>
                            <?php };}; ?>     
                            <?php if (!empty($qualityControl->qc_germlines)) {
                                foreach ($qualityControl->qc_germlines as $germ) { ?>
                                    <tr>
                                        <td>Germlines</td>
                                        <?php if ($germ->pass == "Passed") { ?><td style="background-color:palegreen"> <?php } elseif ($germ->pass == "Failed"){ ?><td style="background-color:#cc0000;color:#ffffff"> <?php } elseif ($germ->pass == "Inconclusive"){ ?><td style="background-color:#ffff99"> <?php } else { ?><td>  <?php }; ?><?= h($germ->pass) ?></td>
                                        <td><?= h($germ->started) ?></td>
                                        <td><?= h($germ->started_by) ?></td>
                                        <td><?= h($germ->finished) ?></td>                
                                        <td><?= h($germ->finished_by) ?></td>
                                        <td class="actions">
                                        <?= '<span data-toggle="tooltip" title="View">'. $this->Html->link('<span class="pad-action-glyph glyphicon glyphicon-eye-open"></span>', ['controller'=> 'QcGermlines', 'action' => 'view', $germ->id],  array('escape' => false, 'class' => 'label label-primary action-pad')) . '</span>' ?>
                                        <?= '<span data-toggle="tooltip" title="Edit">'. $this->Html->link('<span class="pad-action-glyph glyphicon glyphicon-pencil"></span>', ['controller'=> 'QcGermlines', 'action' => 'edit', $germ->id], array('escape' => false, 'class' => 'label label-success action-pad')) . '</span>' ?>
                                        </td>                                           
                                    </tr>
                            <?php };}; ?>
                            <?php if (!empty($qualityControl->qc_growths)) {
                                foreach ($qualityControl->qc_growths as $growth) { ?>
                                    <tr>
                                        <td>Viable Growth Morphology</td>
                                        <?php if ($growth->pass == "Passed") { ?><td style="background-color:palegreen"> <?php } elseif ($growth->pass == "Failed"){ ?><td style="background-color:#cc0000;color:#ffffff"> <?php } elseif ($growth->pass == "Inconclusive"){ ?><td style="background-color:#ffff99"> <?php } else { ?><td>  <?php }; ?><?= h($growth->pass) ?></td>
                                        <td><?= h($growth->started) ?></td>
                                        <td><?= h($growth->started_by) ?></td>
                                        <td><?= h($growth->finished) ?></td>                
                                        <td><?= h($growth->finished_by) ?></td>
                                        <td class="actions">
                                        <?= '<span data-toggle="tooltip" title="View">'. $this->Html->link('<span class="pad-action-glyph glyphicon glyphicon-eye-open"></span>', ['controller'=> 'QcGrowths', 'action' => 'view', $growth->id],  array('escape' => false, 'class' => 'label label-primary action-pad')) . '</span>' ?>
                                        <?= '<span data-toggle="tooltip" title="Edit">'. $this->Html->link('<span class="pad-action-glyph glyphicon glyphicon-pencil"></span>', ['controller'=> 'QcGrowths', 'action' => 'edit', $growth->id], array('escape' => false, 'class' => 'label label-success action-pad')) . '</span>' ?>
                                        </td>   
                                    </tr>
                            <?php };}; ?>   
                            <?php if (!empty($qualityControl->qc_karyotypes)) {
                                foreach ($qualityControl->qc_karyotypes as $karyo) { ?>
                                    <tr>
                                        <td>Karyotypes</td>
                                        <?php if ($karyo->pass == "Passed") { ?><td style="background-color:palegreen"> <?php } elseif ($karyo->pass == "Failed"){ ?><td style="background-color:#cc0000;color:#ffffff"> <?php } elseif ($karyo->pass == "Inconclusive"){ ?><td style="background-color:#ffff99"> <?php } else { ?><td>  <?php }; ?><?= h($karyo->pass) ?></td>
                                        <td><?= h($karyo->started) ?></td>
                                        <td><?= h($karyo->started_by) ?></td>
                                        <td><?= h($karyo->finished) ?></td>                
                                        <td><?= h($karyo->finished_by) ?></td>
                                        <td class="actions">
                                        <?= '<span data-toggle="tooltip" title="View">'. $this->Html->link('<span class="pad-action-glyph glyphicon glyphicon-eye-open"></span>', ['controller'=> 'QcKaryotypes', 'action' => 'view', $karyo->id],  array('escape' => false, 'class' => 'label label-primary action-pad')) . '</span>' ?>
                                        <?= '<span data-toggle="tooltip" title="Edit">'. $this->Html->link('<span class="pad-action-glyph glyphicon glyphicon-pencil"></span>', ['controller'=> 'QcKaryotypes', 'action' => 'edit', $karyo->id], array('escape' => false, 'class' => 'label label-success action-pad')) . '</span>' ?>
                                        </td>                                           
                                    </tr>
                            <?php };}; ?>         
                            <?php if (!empty($qualityControl->qc_microinjections)) {
                                foreach ($qualityControl->qc_microinjections as $micro) { ?>
                                    <tr>
                                        <td>Microinjections</td>
                                        <?php if ($micro->pass == "Passed") { ?><td style="background-color:palegreen"> <?php } elseif ($micro->pass == "Failed"){ ?><td style="background-color:#cc0000;color:#ffffff"> <?php } elseif ($micro->pass == "Inconclusive"){ ?><td style="background-color:#ffff99"> <?php } else { ?><td>  <?php }; ?><?= h($micro->pass) ?></td>
                                        <td><?= h($micro->started) ?></td>
                                        <td><?= h($micro->started_by) ?></td>
                                        <td><?= h($micro->finished) ?></td>                
                                        <td><?= h($micro->finished_by) ?></td>
                                        <td class="actions">
                                        <?= '<span data-toggle="tooltip" title="View">'. $this->Html->link('<span class="pad-action-glyph glyphicon glyphicon-eye-open"></span>', ['controller'=> 'QcMicroinjections', 'action' => 'view', $micro->id],  array('escape' => false, 'class' => 'label label-primary action-pad')) . '</span>' ?>
                                        <?= '<span data-toggle="tooltip" title="Edit">'. $this->Html->link('<span class="pad-action-glyph glyphicon glyphicon-pencil"></span>', ['controller'=> 'QcMicroinjections', 'action' => 'edit', $micro->id], array('escape' => false, 'class' => 'label label-success action-pad')) . '</span>' ?>
                                        </td>                                           
                                    </tr>
                            <?php };}; ?>     
                            <?php if (!empty($qualityControl->qc_pathogens)) {
                                foreach ($qualityControl->qc_pathogens as $path) { ?>
                                    <tr>
                                        <td>Pathogens</td>
                                        <?php if ($path->pass == "Passed") { ?><td style="background-color:palegreen"> <?php } elseif ($path->pass == "Failed"){ ?><td style="background-color:#cc0000;color:#ffffff"> <?php } elseif ($path->pass == "Inconclusive"){ ?><td style="background-color:#ffff99"> <?php } else { ?><td>  <?php }; ?><?= h($path->pass) ?></td>
                                        <td><?= h($path->started) ?></td>
                                        <td><?= h($path->started_by) ?></td>
                                        <td><?= h($path->finished) ?></td>                
                                        <td><?= h($path->finished_by) ?></td>
                                        <td class="actions">
                                        <?= '<span data-toggle="tooltip" title="View">'. $this->Html->link('<span class="pad-action-glyph glyphicon glyphicon-eye-open"></span>', ['controller'=> 'QcPathogens', 'action' => 'view', $path->id],  array('escape' => false, 'class' => 'label label-primary action-pad')) . '</span>' ?>
                                        <?= '<span data-toggle="tooltip" title="Edit">'. $this->Html->link('<span class="pad-action-glyph glyphicon glyphicon-pencil"></span>', ['controller'=> 'QcPathogens', 'action' => 'edit', $path->id], array('escape' => false, 'class' => 'label label-success action-pad')) . '</span>' ?>
                                        </td>                                           
                                    </tr>
                            <?php };}; ?>
                            <?php if (!empty($qualityControl->qc_resequencings)) {
                                foreach ($qualityControl->qc_resequencings as $reseq) { ?>
                                    <tr>
                                        <td>Resequencings</td>
                                        <?php if ($reseq->pass == "Passed") { ?><td style="background-color:palegreen"> <?php } elseif ($reseq->pass == "Failed"){ ?><td style="background-color:#cc0000;color:#ffffff"> <?php } elseif ($reseq->pass == "Inconclusive"){ ?><td style="background-color:#ffff99"> <?php } else { ?><td>  <?php }; ?><?= h($reseq->pass) ?></td>
                                        <td><?= h($reseq->started) ?></td>
                                        <td><?= h($reseq->started_by) ?></td>
                                        <td><?= h($reseq->finished) ?></td>                
                                        <td><?= h($reseq->finished_by) ?></td>
                                        <td class="actions">
                                        <?= '<span data-toggle="tooltip" title="View">'. $this->Html->link('<span class="pad-action-glyph glyphicon glyphicon-eye-open"></span>', ['controller'=> 'QcResequencings', 'action' => 'view', $reseq->id],  array('escape' => false, 'class' => 'label label-primary action-pad')) . '</span>' ?>
                                        <?= '<span data-toggle="tooltip" title="Edit">'. $this->Html->link('<span class="pad-action-glyph glyphicon glyphicon-pencil"></span>', ['controller'=> 'QcResequencings', 'action' => 'edit', $reseq->id], array('escape' => false, 'class' => 'label label-success action-pad')) . '</span>' ?>
                                        </td>   
                                    </tr>
                            <?php };}; ?>   
                            <?php if (!empty($qualityControl->qc_tmks)) {
                                foreach ($qualityControl->qc_tmks as $tmk) { ?>
                                    <tr>
                                        <td>TaqMan Karyotypes</td>
                                        <?php if ($tmk->pass == "Passed") { ?><td style="background-color:palegreen"> <?php } elseif ($tmk->pass == "Failed"){ ?><td style="background-color:#cc0000;color:#ffffff"> <?php } elseif ($tmk->pass == "Inconclusive"){ ?><td style="background-color:#ffff99"> <?php } else { ?><td>  <?php }; ?><?= h($tmk->pass) ?></td>
                                        <td><?= h($tmk->started) ?></td>
                                        <td><?= h($tmk->started_by) ?></td>
                                        <td><?= h($tmk->finished) ?></td>                
                                        <td><?= h($tmk->finished_by) ?></td>
                                        <td class="actions">
                                        <?= '<span data-toggle="tooltip" title="View">'. $this->Html->link('<span class="pad-action-glyph glyphicon glyphicon-eye-open"></span>', ['controller'=> 'QcTmks', 'action' => 'view', $tmk->id],  array('escape' => false, 'class' => 'label label-primary action-pad')) . '</span>' ?>
                                        <?= '<span data-toggle="tooltip" title="Edit">'. $this->Html->link('<span class="pad-action-glyph glyphicon glyphicon-pencil"></span>', ['controller'=> 'QcTmks', 'action' => 'edit', $tmk->id], array('escape' => false, 'class' => 'label label-success action-pad')) . '</span>' ?>
                                        </td>                                           
                                    </tr>
                            <?php };}; ?>                  
                        </tbody>
                    </table>            
                </div>
            </div>
        </div>
        <?php }; ?> 
    </div>    
    <?php if (!empty($qualityControl->qc_customer_invivos)) { ?>
        <a class="accord-head collapsed accord-head" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
            <div class="panel-heading alert-info" role="tab" id="headingOne">
              <h4 class="panel-title">
                  QC Customer In Vivos <sup>
                            (<?php 
                            $total=0;
                            foreach ($qualityControl->qc_customer_invivos as $inVivo) {
                                $total += count($inVivo); };
                            echo $total; ?>)
                            </sup><span class="caret"></span>
              </h4>
            </div>
            </a>
            <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                <div class='container-fluid'>
                    <?php foreach ($qualityControl->qc_customer_invivos as $inVivo) { ?>
                        <div class='row'>          
                            <div class='col-xs-12'><strong><?= __('Order ID') ?>: </strong><?= h($inVivo->order_id) ?></div>
                        </div>
                        <div class='row'>  
                            <div class='col-xs-12'><strong><?= __('Starting Product') ?>: </strong><?= h($inVivo->starting_product) ?></div>
                        </div>
                        <div class='row'>  
                            <div class='col-xs-12'><strong><?= __('Injection Outcome') ?>: </strong><?= h($inVivo->injection_outcome) ?></div>
                        </div>
                        <div class='row'>          
                            <div class='col-xs-12'><strong><?= __('Germline Outcome') ?>: </strong><?= h($inVivo->germline_outcome) ?></div>
                        </div>
                        <div class='row'>  
                            <div class='col-xs-12'><strong><?= __('Notes') ?>: </strong><?= h($inVivo->notes) ?></div>
                        </div>
                        <div class='row'>  
                            <div class='col-xs-12'><strong><?= __('Added By') ?>: </strong><?= h($inVivo->added_by) ?></div>
                        </div>
                        <div class='row'>  
                            <div class='col-xs-12'><strong><?= __('Updated By') ?>: </strong><?= h($inVivo->updated_by) ?></div>
                        </div>   
                    <?php }; ?>
                </div>
            </div>
        </div>
    <?php }; ?>
    
    <?php if ($qualityControl->qc_genotypes) { ?>
    <br>
    <div class="panel panel-default horizontal-table">
    <a class="accord-head collapsed accord-head" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
        <div class="panel-heading alert-info" role="tab" id="headingTwo">
          <h4 class="panel-title">
              QC Genotypes <sup>
                        (<?php 
                        $total=0;
                        foreach ($qualityControl->qc_genotypes as $geno) {
                                $total += count($geno); };
                        echo $total; ?>)
                        </sup><span class="caret"></span>
          </h4>
        </div>
        </a>
        <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
            <?php foreach ($qualityControl->qc_genotypes as $geno)  { ?>
                <div class='container-fluid'>
                    <div class='row'>
                        <div class='col-xs-6'>
                            <div class='row'>          
                                <div class='col-xs-12'><strong><?= __('Used Positive Control') ?>: </strong><?= h($geno->positive_control) ?></div>
                            </div>
                            <div class='row'>          
                                <div class='col-xs-12'><strong><?= __("5' Junction") ?>: </strong><?= h($geno->test5) ?> <em><?= h($geno->date5) ?></em></div>
                            </div>
                            <div class='row'>          
                                <div class='col-xs-12'><strong><?= __("3' loxP junction") ?>: </strong><?= h($geno->test3) ?> <em><?= h($geno->date3) ?></em></div>
                            </div>
                            <div class='row'>          
                                <div class='col-xs-12'><strong><?= __('TaqMan loxP') ?>: </strong><?= h($geno->test_loxp) ?> <em><?= h($geno->date_loxp) ?></em></div>
                            </div>
                            <div class='row'>          
                                <div class='col-xs-12'><strong><?= __('Copy#=1') ?>: </strong><?= h($geno->testcopy1) ?></div>
                            </div>
                            <div class='row'>          
                                <div class='col-xs-12'><strong><?= __('Copy#') ?>: </strong><?= h($geno->testcopy1value) ?></div>
                            </div>
                            <div class='row'>          
                                <div class='col-xs-12'><strong><?= __("5' LRPCR") ?>: </strong><?= h($geno->testLRPCR5) ?> <em><?= h($geno->dateLRPCR5) ?></em></div>
                            </div>
                            <div class='row'>          
                                <div class='col-xs-12'><strong><?= __("5' Vector Integrity") ?>: </strong><?= h($geno->test_integrity5) ?> <em><?= h($geno->date_integrity5) ?></em></div>
                            </div>
                            <div class='row'>          
                                <div class='col-xs-12'><strong><?= __('Genome Integrity') ?>: </strong><?= h($geno->test_genome) ?> <em><?= h($geno->date_genome) ?></em></div>
                            </div>
                            <div class='row'>          
                                <div class='col-xs-12'><strong><?= __('Y Chromosome Lost') ?>: </strong><?= h($geno->lost_y) ?> <em><?= h($geno->date_y) ?></em></div>
                            </div>
                            <div class='row'>          
                                <div class='col-xs-12'><strong><?= __('Clone Identity') ?>: </strong><?= h($geno->test_identity) ?></div>
                            </div>
                        </div>
                        <div class='col-xs-6'>
                            <div class='row'>          
                                <div class='col-xs-12'><strong><?= __('Pass?') ?>: </strong><?= h($geno->pass) ?></div>
                            </div>
                            <div class='row'>          
                                <div class='col-xs-12'><strong><?= __('Comments') ?>: </strong><?= h($geno->comments) ?></div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php }; ?>
        </div>
    </div>
    <?php }; ?>
    <?php if (!empty($qualityControl->qc_germlines)) { ?>
    <br>
    <div class="panel panel-default horizontal-table">
    <a class="accord-head collapsed accord-head" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
        <div class="panel-heading alert-info" role="tab" id="headingThree">
          <h4 class="panel-title">
              QC Germlines <sup>
                (<?php 
                $total=0;
                foreach ($qualityControl->qc_germlines as $germ) {
                    $total += count($germ); };
                echo $total; ?>)
                </sup><span class="caret"></span>
          </h4>
        </div>
        </a>
        <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
            <?php foreach ($qualityControl->qc_germlines as $germ) { ?>
                        <div class='container-fluid'>
                            <div class='row'>
                                <div class='col-xs-6'>
                                    <div class='row'>          
                                        <div class='col-xs-12'><strong><?= __("Started") ?>: </strong><?= h($germ->started_by) ?> <em><?= h($germ->started) ?></em></div>
                                    </div>
                                    <div class='row'>          
                                        <div class='col-xs-12'><strong><?= __("Finished") ?>: </strong><?= h($germ->finished_by) ?> <em><?= h($germ->finished) ?></em></div>
                                    </div>
                                    <div class='row'>          
                                        <div class='col-xs-12'><strong><?= __('Pass?') ?>: </strong><?= h($germ->pass) ?></div>
                                    </div>
                                    <div class='row'>          
                                        <div class='col-xs-12'><strong><?= __('Comments') ?>: </strong><?= h($germ->comment) ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
            <?php }; ?>
        </div>
    </div>
    <br>
    <?php }; ?>
    <?php if (!empty($qualityControl->qc_growths)) { ?>
    <div class="panel panel-default horizontal-table">
    <a class="accord-head collapsed accord-head" data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
        <div class="panel-heading alert-info" role="tab" id="headingFour">
          <h4 class="panel-title">
              QC Viability-Growth-Morphology <sup>
                (<?php 
                $total=0;
                foreach ($qualityControl->qc_growths as $growth) {
                    $total += count($growth); };
                echo $total; ?>)
                </sup><span class="caret"></span>
          </h4>
        </div>
        </a>
        <div id="collapseFour" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFour">
            <?php foreach ($qualityControl->qc_growths as $growth) { ?>
                <div class='container-fluid'>
                    <div class='row'>
                        <div class='col-xs-6'>
                            <div class='row'>          
                                <div class='col-xs-12'><strong><?= __("Started") ?>: </strong><?= h($growth->started_by) ?> <em><?= h($growth->started) ?></em></div>
                            </div>
                            <div class='row'>          
                                <div class='col-xs-12'><strong><?= __("Finished") ?>: </strong><?= h($growth->finished_by) ?> <em><?= h($growth->finished) ?></em></div>
                            </div>
                            <div class='row'>          
                                <div class='col-xs-12'><strong><?= __('Pass?') ?>: </strong><?= h($growth->pass) ?></div>
                            </div>
                            <div class='row'>          
                                <div class='col-xs-12'><strong><?= __('Comments') ?>: </strong><?= h($growth->comment) ?></div>
                            </div>
                            <div class='row'>          
                                <div class='col-xs-12'><strong><?= __('Confluency') ?>: </strong><?= h($growth->confluency) ?></div>
                            </div>
                            <div class='row'>          
                                <div class='col-xs-12'><strong><?= __('Size') ?>: </strong><?= h($growth->size) ?></div>
                            </div>
                            <div class='row'>          
                                <div class='col-xs-12'><strong><?= __('Shape') ?>: </strong><?= h($growth->shape) ?></div>
                            </div>
                            <div class='row'>          
                                <div class='col-xs-12'><strong><?= __('Texture') ?>: </strong><?= h($growth->texture) ?></div>
                            </div>                                    
                            <div class='row'>          
                                <div class='col-xs-12'><strong><?= __('Color') ?>: </strong><?= h($growth->color) ?></div>
                            </div>
                            <div class='row'>          
                                <div class='col-xs-12'><strong><?= __('Dead Cells') ?>: </strong><?= h($growth->dead_cells) ?></div>
                            </div>
                            <div class='row'>          
                                <div class='col-xs-12'><strong><?= __('QC Type') ?>: </strong><?= h($growth->qc_type) ?></div>
                            </div>
                            <div class='row'>          
                                <div class='col-xs-12'><strong><?= __('Image Name') ?>: </strong><?= h($growth->image_name) ?></div>
                            </div>                                  
                        </div>
                    </div>
                </div>
            <?php }; ?>
        </div>
    </div>
    <br>
    <?php }; ?>
    <?php if (!empty($qualityControl->qc_karyotypes)) { ?>
    <div class="panel panel-default horizontal-table">
    <a class="accord-head collapsed accord-head" data-toggle="collapse" data-parent="#accordion" href="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
        <div class="panel-heading alert-info" role="tab" id="headingFive">
          <h4 class="panel-title">
              QC Karyotypes <sup>
                        (<?php 
                        $total=0;
                        foreach ($qualityControl->qc_karyotypes as $karyo) {
                            $total += count($karyo); };
                        echo $total; ?>)
                        </sup><span class="caret"></span>
          </h4>
        </div>
        </a>
        <div id="collapseFive" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFive">
            <?php foreach ($qualityControl->qc_karyotypes as $karyo) { ?>
                <div class='container-fluid'>
                    <div class='row'>
                        <div class='col-xs-6'>
                            <div class='row'>          
                                <div class='col-xs-12'><strong><?= __("Started") ?>: </strong><?= h($karyo->started_by) ?> <em><?= h($karyo->started) ?></em></div>
                            </div>
                            <div class='row'>          
                                <div class='col-xs-12'><strong><?= __("Finished") ?>: </strong><?= h($karyo->finished_by) ?> <em><?= h($karyo->finished) ?></em></div>
                            </div>
                            <div class='row'>          
                                <div class='col-xs-12'><strong><?= __('Pass?') ?>: </strong><?= h($karyo->pass) ?></div>
                            </div>
                            <div class='row'>          
                                <div class='col-xs-12'><strong><?= __('Comments') ?>: </strong><?= h($karyo->comment) ?></div>
                            </div>
                            <div class='row'>          
                                <div class='col-xs-12'><strong><?= __('Euploid') ?>: </strong><?= h($karyo->euploid) ?></div>
                            </div>                               
                        </div>
                    </div>
                </div>
            <?php }; ?>
        </div>
    </div>
    <br>
    <?php }; ?>
    <?php if (!empty($qualityControl->qc_microinjections)) { ?>
    <div class="panel panel-default horizontal-table">
    <a class="accord-head collapsed accord-head" data-toggle="collapse" data-parent="#accordion" href="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
        <div class="panel-heading alert-info" role="tab" id="headingSix">
          <h4 class="panel-title">
              QC Microinjections <sup>
                (<?php 
                $total=0;
                foreach ($qualityControl->qc_microinjections as $micro) {
                    $total += count($micro); };
                echo $total; ?>)
                </sup><span class="caret"></span>
          </h4>
        </div>
        </a>
        <div id="collapseSix" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingSix">
            <?php foreach ($qualityControl->qc_microinjections as $micro) { ?>
                <div class='container-fluid'>
                    <div class='row'>
                        <div class='col-xs-6'>
                            <div class='row'>          
                                <div class='col-xs-12'><strong><?= __("Started") ?>: </strong><?= h($micro->started_by) ?> <em><?= h($micro->started) ?></em></div>
                            </div>
                            <div class='row'>          
                                <div class='col-xs-12'><strong><?= __("Finished") ?>: </strong><?= h($micro->finished_by) ?> <em><?= h($micro->finished) ?></em></div>
                            </div>
                            <div class='row'>          
                                <div class='col-xs-12'><strong><?= __('Pass?') ?>: </strong><?= h($micro->pass) ?></div>
                            </div>
                            <div class='row'>          
                                <div class='col-xs-12'><strong><?= __('Comments') ?>: </strong><?= h($micro->comment) ?></div>
                            </div>
                            <div class='row'>          
                                <div class='col-xs-12'><strong><?= __('Birthdate') ?>: </strong><?= h($micro->birthdate) ?></div>
                            </div>    
                            <div class='row'>          
                                <div class='col-xs-12'><strong><?= __('BL') ?>: </strong><?= h($micro->bl) ?></div>
                            </div>
                            <div class='row'>          
                                <div class='col-xs-12'><strong><?= __('Parent Strain') ?>: </strong><?= h($micro->parent_strain) ?></div>
                            </div>
                            <div class='row'>          
                                <div class='col-xs-12'><strong><?= __('Injection Type') ?>: </strong><?= h($micro->injection_type) ?></div>
                            </div> 
                            <div class='row'>          
                                <div class='col-xs-12'><strong><?= __('Number Recipients') ?>: </strong><?= h($micro->number_recipients) ?></div>
                            </div>                                                                                                         
                        </div>
                        <div class='col-xs-6'>
                            <div class='row'>          
                                <div class='col-xs-12'><strong><?= __('Number of Pups') ?>: </strong><?= h($micro->npups) ?></div>
                            </div>
                            <div class='row'>          
                                <div class='col-xs-12'><strong><?= __('Number of Males') ?>: </strong><?= h($micro->nmale) ?></div>
                            </div> 
                            <div class='row'>          
                                <div class='col-xs-12'><strong><?= __('Number of Pups Born') ?>: </strong><?= h($micro->number_pups_born) ?></div>
                            </div>     
                            <div class='row'>          
                                <div class='col-xs-12'><strong><?= __('Chimerism') ?>: </strong><?= h($micro->chimerism) ?></div>
                            </div>
                            <div class='row'>          
                                <div class='col-xs-12'><strong><?= __('Max Chimerism') ?>: </strong><?= h($micro->max_chimerism) ?></div>
                            </div>
                            <div class='row'>          
                                <div class='col-xs-12'><strong><?= __('Number Injected') ?>: </strong><?= h($micro->number_injected) ?></div>
                            </div>       
                            <div class='row'>          
                                <div class='col-xs-12'><strong><?= __('Number Litters') ?>: </strong><?= h($micro->number_litters) ?></div>
                            </div>                                                                  
                        </div>
                    </div>
                </div>
            <?php }; ?>
        </div>
    </div>
    <br>
    <?php }; ?>
    <?php if (!empty($qualityControl->qc_pathogens)) { ?>
    <div class="panel panel-default horizontal-table">
    <a class="accord-head collapsed accord-head" data-toggle="collapse" data-parent="#accordion" href="#collapseSeven" aria-expanded="false" aria-controls="collapseSeven">
        <div class="panel-heading alert-info" role="tab" id="headingSeven">
          <h4 class="panel-title">
              QC Pathogens <sup>
                    (<?php 
                    $total=0;
                    foreach ($qualityControl->qc_pathogens as $path) {
                       $total += count($path); };
                    echo $total; ?>)
                    </sup><span class="caret"></span>
          </h4>
        </div>
        </a>
        <div id="collapseSeven" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingSeven">
            <?php foreach ($qualityControl->qc_pathogens as $path) { ?>
                <div class='container-fluid'>
                    <div class='row'>
                        <div class='col-xs-6'>
                            <div class='row'>          
                                <div class='col-xs-12'><strong><?= __("Started") ?>: </strong><?= h($path->started_by) ?> <em><?= h($path->started) ?></em></div>
                            </div>
                            <div class='row'>          
                                <div class='col-xs-12'><strong><?= __("Finished") ?>: </strong><?= h($path->finished_by) ?> <em><?= h($path->finished) ?></em></div>
                            </div>
                            <div class='row'>          
                                <div class='col-xs-12'><strong><?= __('Pass?') ?>: </strong><?= h($path->pass) ?></div>
                            </div>
                            <div class='row'>          
                                <div class='col-xs-12'><strong><?= __('Comments') ?>: </strong><?= h($path->comment) ?></div>
                            </div>
                            <div class='row'>          
                                <div class='col-xs-12'><strong><?= __('Mycoplasma') ?>: </strong><?= h($path->mycoplasma) ?></div>
                            </div>            
                            <div class='row'>          
                                <div class='col-xs-12'><strong><?= __('Parvovirus') ?>: </strong><?= h($path->parvovirus) ?></div>
                            </div>
                            <div class='row'>          
                                <div class='col-xs-12'><strong><?= __('Other') ?>: </strong><?= h($path->other) ?></div>
                            </div>                                                        
                        </div>
                    </div>
                </div>
            <?php }; ?>
        </div>
    </div>
    <br>
    <?php }; ?>
    <?php if (!empty($qualityControl->qc_resequencings)) { ?>
    <div class="panel panel-default horizontal-table">
    <a class="accord-head collapsed accord-head" data-toggle="collapse" data-parent="#accordion" href="#collapseEight" aria-expanded="false" aria-controls="collapseEight">
        <div class="panel-heading alert-info" role="tab" id="headingEight">
          <h4 class="panel-title">
              QC Resequencing <sup>
                (<?php 
                $total=0;
                foreach ($qualityControl->qc_resequencings as $reseq) {
                    $total += count($reseq); };
                echo $total; ?>)
                </sup><span class="caret"></span>
          </h4>
        </div>
        </a>
        <div id="collapseEight" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingEight">
            <?php foreach ($qualityControl->qc_resequencings as $reseq) { ?>
                <div class='container-fluid'>
                    <div class='row'>
                        <div class='col-xs-6'>
                            <div class='row'>          
                                <div class='col-xs-12'><strong><?= __("Started") ?>: </strong><?= h($reseq->started_by) ?> <em><?= h($reseq->started) ?></em></div>
                            </div>
                            <div class='row'>          
                                <div class='col-xs-12'><strong><?= __("Finished") ?>: </strong><?= h($reseq->finished_by) ?> <em><?= h($reseq->finished) ?></em></div>
                            </div>
                            <div class='row'>          
                                <div class='col-xs-12'><strong><?= __('Pass?') ?>: </strong><?= h($reseq->pass) ?></div>
                            </div>
                            <div class='row'>          
                                <div class='col-xs-12'><strong><?= __('Comments') ?>: </strong><?= h($reseq->comment) ?></div>
                            </div>
                            <div class='row'>          
                                <div class='col-xs-12'><strong><?= __('Result') ?>: </strong><?= h($reseq->result) ?></div>
                            </div>            
                            <div class='row'>          
                                <div class='col-xs-12'><strong><?= __('MGAL Sequence') ?>: </strong><?= h($reseq->MGAL_sequence) ?></div>
                            </div>
                            <div class='row'>          
                                <div class='col-xs-12'><strong><?= __('MGAL Expected') ?>: </strong><?= h($reseq->MGAL_expected) ?></div>
                            </div>            
                            <div class='row'>          
                                <div class='col-xs-12'><strong><?= __('MGAL ID Location') ?>: </strong><?= h($reseq->MGAL_id_location) ?></div>
                            </div>
                            <div class='row'>          
                                <div class='col-xs-12'><strong><?= __('Blast Result') ?>: </strong><?= h($reseq->blast_result) ?></div>
                            </div>                                                        
                        </div>
                    </div>
                </div>
            <?php }; ?>
        </div>
    </div>
    <br>
    <?php }; ?>
    <?php if (!empty($qualityControl->qc_tmks)) { ?>
    <div class="panel panel-default horizontal-table">
    <a class="accord-head collapsed accord-head" data-toggle="collapse" data-parent="#accordion" href="#collapseNine" aria-expanded="false" aria-controls="collapseNine">
        <div class="panel-heading alert-info" role="tab" id="headingNine">
          <h4 class="panel-title">
              QC TaqMan Karyotypes <sup>
                (<?php 
                $total=0;
                foreach ($qualityControl->qc_tmks as $tmk) {
                    $total += count($tmk); };
                echo $total; ?>)
                </sup><span class="caret"></span>
          </h4>
        </div>
        </a>
        <div id="collapseNine" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingNine">
            <?php foreach ($qualityControl->qc_tmks as $tmk) { ?>
                <div class='container-fluid'>
                    <div class='row'>
                        <div class='col-xs-6'>
                            <div class='row'>          
                                <div class='col-xs-12'><strong><?= __("Started") ?>: </strong><?= h($tmk->started_by) ?> <em><?= h($tmk->started) ?></em></div>
                            </div>
                            <div class='row'>          
                                <div class='col-xs-12'><strong><?= __("Finished") ?>: </strong><?= h($tmk->finished_by) ?> <em><?= h($tmk->finished) ?></em></div>
                            </div>
                            <div class='row'>          
                                <div class='col-xs-12'><strong><?= __('Pass?') ?>: </strong><?= h($tmk->pass) ?></div>
                            </div>
                            <div class='row'>          
                                <div class='col-xs-12'><strong><?= __('Comments') ?>: </strong><?= h($tmk->comment) ?></div>
                            </div>
                            <div class='row'>          
                                <div class='col-xs-12'><strong><?= __('Euploid') ?>: </strong><?= h($tmk->euploid) ?></div>
                            </div> 
                        </div>
                        <div class='col-xs-6'>
                            <div class='row'>          
                                <div class='col-xs-12'><strong><?= __('Chromosome 1') ?>: </strong><?= h($tmk->ch1) ?></div>
                            </div>
                            <div class='row'>          
                                <div class='col-xs-12'><strong><?= __('Chromosome 2') ?>: </strong><?= h($tmk->ch2) ?></div>
                            </div>            
                            <div class='row'>          
                                <div class='col-xs-12'><strong><?= __('Chromosome 3') ?>: </strong><?= h($tmk->ch3) ?></div>
                            </div>
                            <div class='row'>          
                                <div class='col-xs-12'><strong><?= __('Chromosome 4') ?>: </strong><?= h($tmk->ch4) ?></div>
                            </div>  
                            <div class='row'>          
                                <div class='col-xs-12'><strong><?= __('Chromosome 5') ?>: </strong><?= h($tmk->ch5) ?></div>
                            </div>
                            <div class='row'>          
                                <div class='col-xs-12'><strong><?= __('Chromosome 6') ?>: </strong><?= h($tmk->ch6) ?></div>
                            </div>            
                            <div class='row'>          
                                <div class='col-xs-12'><strong><?= __('Chromosome 7') ?>: </strong><?= h($tmk->ch7) ?></div>
                            </div>
                            <div class='row'>          
                                <div class='col-xs-12'><strong><?= __('Chromosome 8') ?>: </strong><?= h($tmk->ch8) ?></div>
                            </div>   
                            <div class='row'>          
                                <div class='col-xs-12'><strong><?= __('Chromosome 9') ?>: </strong><?= h($tmk->ch9) ?></div>
                            </div>
                            <div class='row'>          
                                <div class='col-xs-12'><strong><?= __('Chromosome 10') ?>: </strong><?= h($tmk->ch10) ?></div>
                            </div>            
                            <div class='row'>          
                                <div class='col-xs-12'><strong><?= __('Chromosome 11') ?>: </strong><?= h($tmk->ch11) ?></div>
                            </div>
                            <div class='row'>          
                                <div class='col-xs-12'><strong><?= __('Chromosome 12') ?>: </strong><?= h($tmk->ch12) ?></div>
                            </div>
                            <div class='row'>          
                                <div class='col-xs-12'><strong><?= __('Chromosome 13') ?>: </strong><?= h($tmk->ch13) ?></div>
                            </div>
                            <div class='row'>          
                                <div class='col-xs-12'><strong><?= __('Chromosome 14') ?>: </strong><?= h($tmk->ch14) ?></div>
                            </div>            
                            <div class='row'>          
                                <div class='col-xs-12'><strong><?= __('Chromosome 15') ?>: </strong><?= h($tmk->ch15) ?></div>
                            </div>
                            <div class='row'>          
                                <div class='col-xs-12'><strong><?= __('Chromosome 16') ?>: </strong><?= h($tmk->ch16) ?></div>
                            </div>
                            <div class='row'>          
                                <div class='col-xs-12'><strong><?= __('Chromosome 17') ?>: </strong><?= h($tmk->ch17) ?></div>
                            </div>
                            <div class='row'>          
                                <div class='col-xs-12'><strong><?= __('Chromosome 18') ?>: </strong><?= h($tmk->ch18) ?></div>
                            </div>            
                            <div class='row'>          
                                <div class='col-xs-12'><strong><?= __('Chromosome 19') ?>: </strong><?= h($tmk->ch19) ?></div>
                            </div>
                            <div class='row'>          
                                <div class='col-xs-12'><strong><?= __('Chromosome X') ?>: </strong><?= h($tmk->chX) ?></div>
                            </div>                                                           
                        </div>
                    </div>
                </div>
            <?php }; ?>
        </div>
    </div>
    <?php }; ?>
    </div>
</div>
