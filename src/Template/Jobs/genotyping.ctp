
<div class="container">
    <div class="panel-group">
        <div class="panel panel-primary">
            <div class="panel-heading">MCRL Genotyping Form</div>
            <div class="panel-body">
                <div class="container">
                    <div class='row'>
                        <div class='col-xs-4'><strong><?= __('Submission Date') ?>: </strong><?= h($job->request_date) ?></div>
                        <div class='col-xs-4'><strong><?= __('Collection Date') ?>: </strong><?= h($job->pup_genotype_updated_by) ?></div>
                        <div class='col-xs-4'><strong><?= __('Job ID#') ?>: </strong><?= h($job->id) ?></div>
                    </div>
                    <div class='row'>
                        <div class='col-xs-4'><strong><?= __('Submitted By') ?>: </strong><?= h($job->user_id) ?></div>
                        <div class='col-sm-4'></div>
                        <div class='col-xs-4'><strong><?= __('Recharge #') ?>: </strong><?= h($job->mgel_recharge) ?></div>
                    </div>
                    <div class='row'>
                        <div class='col-xs-12'><strong><?= __('Strain Name') ?>: </strong><?= h($job->strain_name) ?></div>
                    </div>
                    <div class='row'>
                        <div class='col-xs-8'><strong><?= __('MMRRC/Clone ID') ?>: </strong><?= h($job->mmrrc_no) ?></div>
                        <div class='col-xs-4'><strong><?= __('If chimera sperm, BL#') ?>: </strong><?= h($job->bl_no) ?></div>
                    </div>
                    <div class='row'>
                        <div class='col-xs-8'><strong><?= __('Targeting Confirmation Requested?') ?>: </strong><?= $job->targeting_conf ? __('<span class="bool-yes glyphicon glyphicon-ok"> Yes</span>') : __('<span class="bool-no glyphicon glyphicon-remove"> No</span>'); ?></div>
                    </div>
                    <div class='row'>
                        <div class='col-xs-8'><strong><?= __('Note or Status') ?>: </strong><?= h($job->strain_note) ?></div>
                    </div>
                    <div class='row'>
                        <div class='col-xs-12'><strong><?= __('Comments') ?>: </strong><?= $this->Text->autoParagraph(h($job->comments)); ?></div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Generate a dictionary of values combining IVF, SC, and EC queries -->
        <?php 
            $dictionary = array();
            foreach ($spermCryos as $sc):
                $dictionary[$sc[1]] = array('sc'=>$sc[0], 'genotype'=>$sc[2], 'ec'=>'', 'ivf'=>'', 'donor'=>$sc[1]); //initiate some values to being empty
            endforeach;

            foreach ($embryoCryos as $ec):
                $dictionary[$ec[1]]['ec'] = $ec[0];
                $dictionary[$ec[1]]['donor'] = $ec[1];
                $dictionary[$ec[1]]['ivf'] = '';
                if (empty($dictionary[$ec[1]]['genotype'])) { //check if values exist, if they don't then insert the EC values. Need to initiate some empty values
                    $dictionary[$ec[1]]['genotype'] = $ec[2];
                }
                if (empty($dictionary[$ec[1]]['sc'])) {
                    $dictionary[$ec[1]]['sc'] = '';
                }
            endforeach;

            foreach ($ivfs as $ivf):
                $dictionary[$ivf[1]]['ivf'] = $ivf[0];
                $dictionary[$ivf[1]]['donor'] = $ivf[1];
                if (empty($dictionary[$ivf[1]]['genotype'])) {
                    $dictionary[$ivf[1]]['genotype'] = $ivf[2];
                }
                if (empty($dictionary[$ivf[1]]['sc'])) {
                    $dictionary[$ivf[1]]['sc'] = '';
                }
                if (empty($dictionary[$ivf[1]]['ec'])) {
                    $dictionary[$ivf[1]]['ec'] = '';
                }
            endforeach;     

            echo '<br/>'; 
        ?>
        <div class="related horizontal-table table-responsive">
            <div class="panel panel-primary">
                <div class="panel-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Male ID</th>
                                <th>SC #</th>
                                <th>EC #</th>
                                <th>No. of Embryos</th>
                                <th>IVF/ICSI #</th>
                                <th>Genotype</th>
                                <th>Source</th>
                                <th>Note</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($dictionary as $row): 
                            echo '<tr>';
                            echo '<td>' . $row['donor'] . '</td>';
                            echo '<td>' . $row['sc'] . '</td>';
                            echo '<td>' . $row['ec'] . '</td>';
                            echo '<td></td>';
                            echo '<td>' . $row['ivf'] . '</td>';
                            echo '<td>' . $row['genotype'] . '</td>';
                            echo '<td></td>';
                            echo '<td></td>';
                            echo '</tr>';
                        endforeach; ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>