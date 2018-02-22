<?= $this->CustomForm->iniConfirmExit('#job-request-form') ?>
<div class="jobs form large-9 medium-8 columns content">
    <div class='container-fluid'>
    <div style="margin-bottom:20px;">
        <?php
         echo '<span data-toggle="tooltip" title="Delete">' . $this->Form->postLink('<span class="glyphicon glyphicon-trash"></span> Delete Job Request ',
                                            ['action' => 'delete',$job->id],
                                            array(
                                                'escape' => false,
                                                'class' => 'btn btn-danger pull-right',
                                                'confirm' => __('Are you sure you want to delete # {0}?', $job->id)
                                            )) . '</span>';
        ?>
    </div>
<div class="clearfix"></div>
    <?= $this->Form->create($job, ['id'=>'job-request-form']) ?>
        <fieldset>
            <legend><?= __('Edit Job Request #' . $job->id ) ?></legend>
            <div class="important" style="margin-bottom:20px;">
                <div class='row'>
                    <div class='col-sm-3'>
                        <?php 
                            if ($job->job_status == 'New') {
                                    $new = 'checked'; $open = ''; $closed = '';
                                } elseif ($job->job_status == 'Open') {
                                    $new = ''; $open = 'checked'; $closed = '';
                                } else {
                                    $new = ''; $open = ''; $closed = 'checked';
                                }
                        ?>
                        <label class="control-label" for="job_status">Job Status </label>
                        <div class="switch-toggle well">
                            <input id="new" name="job_status" type="radio" value="New" <?= $new ?> >
                            <label class="pointer" for="new">New</label>
                            <input id="open" name="job_status" value="Open" type="radio" <?= $open ?> >
                            <label class="pointer" for="open">Open</label>
                            <input id="closed" name="job_status" value="Closed" type="radio" <?= $closed ?> >
                            <label class="pointer" for="closed">Closed</label>
                            <a class="progress-bar"></a>
                        </div>
                    </div>
                    <div class='col-sm-4'><?php echo $this->Form->input('job_astatus_id', [
                                'options' => $jobAstatuses,
                                'label' => 'Job Status 1',
                                'empty' => true
                                ]); ?></div>
                    <div class='col-sm-4'><?php echo $this->Form->input('job_bstatus_id', [
                                'options' => $jobBstatuses,
                                'label' => 'Job Status 2',
                                'empty' => true
                                ]); ?></div>
                </div>
            </div>

        <?php if ($job->is_injection_request) { ?>
        <div class="module related horizontal-table job-source">
            <div class='col-xs-4 '>
                <?php echo $this->Form->input('job_source', [
                    'options' => ['KOMP' => 'KOMP', 'MMRRC' => 'MMRRC', 'MBP' => 'MBP'],
                    'label' => 'Job Source',
                    'empty' => true
                ]); ?></div>
                <div class='col-xs-4 '>
                <?php echo $this->customForm->displayMgiGenesDropdown(); ?></div>
                <div class='col-xs-4 '>
                <?php echo $this->Form->input('cell_clone_line', [
                    'label' => 'Cell/Clone line',
                    'empty' => true
                ]); ?></div>
            <div class="clearfix"></div>
        </div>
        <br/>
        <div class='row'>
            <div class='col-xs-4'><?php echo $this->CustomForm->displayField(
                    'et_location', 
                    ['M3' => 'M3', 'MBP' => 'MBP'],
                    true,
                    ['empty'=>true, 'label' => 'Facility']
                ); ?></div>
            <div class='col-xs-4'><?php echo $this->Form->input('inj_parental_line',['label' => 'Parental Line']); ?></div>
            <div class='col-xs-4'><?php echo $this->Form->input('inj_preferred_donor',['label' => 'Preferred Donor']); ?></div>
        </div>
        <div class='row'>
            <div class='col-xs-4'>
                <label class="control-label" for="inj_injection_type">Injection Type</label>
                <div class="switch-toggle well">
                    <input id="inj_injection_type-basic" name="inj_injection_type" type="radio" value="Basic" checked>
                    <label class="pointer" for="inj_injection_type-basic">Basic</label>
                    <input id="inj_injection_type-guaranteed" name="inj_injection_type" value="Guaranteed" type="radio">
                    <label class="pointer" for="inj_injection_type-guaranteed">Guaranteed</label>
                    <a class="progress-bar"></a>
                </div>
            </div>
            <div class='col-xs-4'>
                <label class="control-label" for="inj_repeat">Repeat?</label>
                <div class="switch-toggle well">
                    <input id="inj_repeat-yes" name="inj_repeat" type="radio" value="1">
                    <label class="pointer" for="inj_repeat-yes">Yes</label>
                    <input id="inj_repeat-no" name="inj_repeat" value="0" type="radio" checked>
                    <label class="pointer" for="inj_repeat-no">No</label>
                    <a class="progress-bar"></a>
                </div>
            </div>
        </div>
        <br/>
        <?php } ?>


            <div class='row'>
                <?php
                    $tmpDate = '';
                    if (isset($job->request_date)) {
                      $tmpDate = $job->request_date->format('Y-m-d');
                } ?>  
                <div class='col-sm-4'><?php echo $this->CustomForm->displayDatepickerField('request_date', ['empty'=>true, 'value' => $tmpDate, 'label'=>'Request Date (YYYY-MM-DD)']); ?></div>
                <?php
                    $tmpDate = '';
                    if (isset($job->reopened_date)) {
                      $tmpDate = $job->reopened_date->format('Y-m-d');
                } ?>  
                <div class='col-sm-4'><?php echo $this->CustomForm->displayDatepickerField('reopened_date', ['empty'=>true, 'value' => $tmpDate, 'label'=>'Reopened Date (YYYY-MM-DD)']); ?></div>
                <?php
                    $tmpDate = '';
                    if (isset($job->closed_date)) {
                      $tmpDate = $job->closed_date->format('Y-m-d');
                } ?>  
                <div class='col-sm-4'><?php echo $this->CustomForm->displayDatepickerField('closed_date', ['empty'=>true, 'value' => $tmpDate, 'label'=>'Closed Date (YYYY-MM-DD)']); ?></div>
            </div>
            <div class='row'>
                <div class='col-sm-4'><?php echo $this->CustomForm->displayField(
                            'membership', 
                            $this->CustomForm->getMembershipList(),
                            true,
                            ['empty'=>true]
                        ); ?></div>
                <div class='col-sm-4'><?php echo $this->CustomForm->displayField(
                            'komp_source', 
                            $this->CustomForm->getKompSourceList(),
                            true,
                            ['empty'=>true]
                        ); ?></div>
                <div class='col-sm-4'><?php echo $this->Form->input('mosaic_id_no',['label' => 'Mosaic ID']);  ?></div>
            </div>
            <div class="row">
                <div class='col-sm-4'><?php echo $this->CustomForm->displayField(
                        'mcrl_recharge', 
                        $this->CustomForm->getMcrlRechargeList(),
                        true,
                        ['empty'=>true, 'label' => 'MICL Recharge']
                    ); ?></div>
                <div class='col-sm-4'><?php echo $this->CustomForm->displayField(
                        'mvp_recharge', 
                        $this->CustomForm->getMvpRechargeList(),
                        true,
                        ['empty'=>true, 'label' => 'MVP Recharge']
                    ); ?></div>
                <div class='col-sm-4'><?php echo $this->CustomForm->displayField(
                        'mgel_recharge', 
                        $this->CustomForm->getMgelRechargeList(),
                        true,
                        ['empty'=>true, 'label' => 'MGEL Recharge']
                    ); ?></div>
            </div>
            <div class='row'>
                <div class='col-sm-3'>
                    <?php 
                        if ($job->billed) {
                                $open = 'checked'; $closed = '';
                            } else {
                                $open = ''; $closed = 'checked';
                            }
                    ?>
                    <label class="control-label" for="billed">Will be Billed?</label>
                    <div class="switch-toggle well">
                        <input id="billed-yes" name="billed" type="radio" value="1" <?= $open ?> >
                        <label class="pointer" for="billed-yes">Yes</label>
                        <input id="billed-no" name="billed" value="0" type="radio" <?= $closed ?> >
                        <label class="pointer" for="billed-no">No</label>
                        <a class="progress-bar"></a>
                    </div>
                </div>
                <div class='col-sm-3'><?php echo $this->Form->input('order_no',['label' => 'Order #']); ?></div>
                <div class='col-sm-3'><?php echo $this->Form->input('billing_id_no',['label' => 'Billing ID']); ?></div>
                <div class='col-xs-3'><?php echo $this->Form->input('import_id_no',['label' => 'Import #']); ?></div>
            </div>

            <div class='alert alert-info' role='alert'>Job Request Details</div>
            <div class='row'>
                <div class='col-xs-12'><?php echo $this->Form->input('strain_name'); ?></div>
            </div>
            <div class='row'>
                <div class='col-xs-12'><?php echo $this->Form->input('strain_note'); ?></div>
            </div>
            <div class='row'>
                <div class='col-xs-12'><?php echo $this->Form->input('previous_name',['label' => 'Previous Strain Name']); ?></div>  
            </div>
            <div class="row">
                <div class='col-sm-4'><?php echo $this->Form->input('mmrrc_no',['label' => 'MMRRC ID']); ?></div>
                <div class='col-sm-4'><?php echo $this->Form->input('bl_no',['label' => 'BL#']); ?></div>           
                <div class='col-sm-4'><?php echo $this->Form->input('pn_cr_no',['label' => 'PN/CR#']); ?></div>
            </div>
            <hr/>
            <div class='row'>
                <div class='col-sm-6'><?php echo $this->Form->input('esc_clone_id_no',['label' => 'ESC Clone ID']); ?></div>
                <div class='col-sm-6'><?php echo $this->Form->input('esc_line'); ?></div>
            </div>
            <div class="row">
                <div class='col-sm-6'><?php echo $this->CustomForm->displayField(
                        'genotype', 
                        $this->CustomForm->getGenotypeList(),
                        true,
                        ['empty'=>true]
                    ); ?></div>
            <?php 
                if ($job->sexlinked == 'Y-linked') {
                        $no = ''; $x = ''; $y = 'checked';
                    } elseif ($job->sexlinked == 'X-linked') {
                        $no = ''; $x = 'checked'; $y = '';
                    } else {
                        $no = 'checked'; $x = ''; $y = '';
                    }
            ?>
            <div class='col-sm-6'>           
                <label class="control-label" for="sexlinked">Sexlinked?</label>
                <div class="switch-toggle well">                   
                    <input type="radio" name="sexlinked" value="No" id="sexlinked-no" <?= $no ?> >
                    <label class="pointer" for="sexlinked-no"> No</label>
                    <input type="radio" name="sexlinked" value="X-linked" id="sexlinked-x-linked" <?= $x ?> > 
                    <label class="pointer" for="sexlinked-x-linked">X-linked </label>
                    <input type="radio" name="sexlinked" value="Y-linked" id="sexlinked-y-linked" <?= $y ?> >
                    <label class="pointer" for="sexlinked-y-linked">Y-linked   </label>
                    <a class="progress-bar"></a>
                </div>
            </div>
            </div>
            <hr/>
            <div class='row'>
            <div class='col-sm-3'><?php echo $this->CustomForm->displayField(
                    'background', 
                    $this->CustomForm->getBackgroundList(),
                    true,
                    ['empty'=>true]
                );   ?></div>
                <div class='col-sm-3'><?php echo $this->CustomForm->displayField(
                        'egg_donors', 
                        $this->CustomForm->getDonorStrainList(),
                        true,
                        ['empty'=>true]
                    ); ?></div>
                <div class='col-sm-3'><?php echo $this->CustomForm->displayField(
                        'et_location', 
                        ['M3' => 'M3', 'MBP' => 'MBP'],
                        true,
                        ['empty'=>true, 'label' => 'ET Location']
                    ); ?></div>
                <div class='col-sm-3'><?php echo $this->Form->input('recipient_no',['label' => 'Recipient #']); ?></div>
            </div>
            <div class="row">
            <div class='col-sm-12'><?php echo $this->Form->input('method_note',['label' => 'Method or Note', 'type' => 'textarea']); ?></div>
            </div>
            <div class='alert alert-info' role='alert'>Animal Information</div>
            <div class='row'>
                <div class='col-sm-4'><?php echo $this->CustomForm->displayField(
                        'housing', 
                        $this->CustomForm->getHousingLocationList(),
                        true,
                        ['empty'=>true, 'label'=>'Housing location']
                    ); ?></div>
                <div class='col-sm-4'><?php echo $this->Form->input('chimeras'); ?></div>
                <div class='col-sm-4'><?php echo $this->CustomForm->displayField(
                        'chimera_fertility', 
                        $this->CustomForm->getChimeraFertilityList(),
                        true,
                        ['empty'=>true]
                    ); ?></div>
            </div>
            <hr/>
            <div class="row">
                <div class='col-sm-6'><?php echo $this->Form->input('males_no'); ?></div>
                <div class='col-sm-6'><?php echo $this->Form->input('males_id_dob',['label' => 'Males ID/DOB']); ?></div>
            </div>
            <div class='row'>
                <div class='col-sm-6'><?php echo $this->Form->input('females_no'); ?></div>
                <div class='col-sm-6'><?php echo $this->Form->input('females_id_dob',['label' => 'Females ID/DOB']); ?></div>
            </div>
            <div class='alert alert-info' role='alert'>Genotyping</div>      
            <div class='row'>
                <div class='col-sm-3'>
                    <?php 
                        if ($job->donor_genotyping) {
                                $open = 'checked'; $closed = '';
                            } else {
                                $open = ''; $closed = 'checked';
                            }
                    ?>
                    <label class="control-label" for="donor_genotyping">Sperm Donor Genotyping? </label>
                    <div class="switch-toggle well">
                        <input id="donor_genotyping-yes" name="donor_genotyping" type="radio" value="1" <?= $open ?> >
                        <label class="pointer" for="donor_genotyping-yes">Yes</label>
                        <input id="donor_genotyping-no" name="donor_genotyping" value="0" type="radio" <?= $closed ?> >
                        <label class="pointer" for="donor_genotyping-no">No</label>
                        <a class="progress-bar"></a>
                    </div>
                </div>
                <div class='col-sm-3'>
                    <?php 
                        if ($job->egg_donor_genotyping) {
                                $open = 'checked'; $closed = '';
                            } else {
                                $open = ''; $closed = 'checked';
                            }
                    ?>
                    <label class="control-label" for="egg_donor_genotyping">Egg Donor Genotyping? </label>
                    <div class="switch-toggle well">
                        <input id="egg_donor_genotyping-yes" name="egg_donor_genotyping" type="radio" value="1" <?= $open ?> >
                        <label class="pointer" for="egg_donor_genotyping-yes">Yes</label>
                        <input id="egg_donor_genotyping-no" name="egg_donor_genotyping" value="0" type="radio" <?= $closed ?> >
                        <label class="pointer" for="egg_donor_genotyping-no">No</label>
                        <a class="progress-bar"></a>
                    </div>
                </div>                
                <div class='col-sm-3'>
                    <?php 
                        if ($job->targeting_conf) {
                                $open = 'checked'; $closed = '';
                            } else {
                                $open = ''; $closed = 'checked';
                            }
                    ?>
                    <label class="control-label" for="targeting_conf">Targeting confirmation? </label>
                    <div class="switch-toggle well">
                        <input id="targeting-conf-yes" name="targeting_conf" type="radio" value="1" <?= $open ?> >
                        <label class="pointer" for="targeting-conf-yes">Yes</label>
                        <input id="targeting-conf-no" name="targeting_conf" value="0" type="radio" <?= $closed ?> >
                        <label class="pointer" for="targeting-conf-no">No</label>
                        <a class="progress-bar"></a>
                    </div>
                </div>
                <div class='col-sm-3'>
                    <?php 
                        if ($job->muga_sample) {
                                $open = 'checked'; $closed = '';
                            } else {
                                $open = ''; $closed = 'checked';
                            }
                    ?>
                    <label class="control-label" for="muga_sample">MUGA Sample Required? </label>
                    <div class="switch-toggle well">
                        <input id="muga_sample-yes" name="muga_sample" type="radio" value="1" <?= $open ?> >
                        <label class="pointer" for="muga_sample-yes">Yes</label>
                        <input id="muga_sample-no" name="muga_sample" value="0" type="radio" <?= $closed ?> >
                        <label class="pointer" for="muga_sample-no">No</label>
                        <a class="progress-bar"></a>
                    </div>
                </div>
                <div class='col-sm-3'><?php echo $this->CustomForm->displayField(
                        'where_geno', 
                        ['PI Lab' => 'PI Lab', 'MGEL' => 'MGEL', 'None' => 'None'],
                        true,
                        ['empty'=>true, 'label' => 'Genotyping of Derived Pups']
                    ) ?></div>
            </div>
            <div class="row">
                <div class='col-sm-12'><?php echo $this->Form->input('mcrl_note',['label' => 'MCRL note', 'type' => 'textarea']); ?></div>
            </div>
            </div>

            <?php
                echo $this->Form->hidden('user_id', [
                    'options' => $users,
                    'default' => $this->request->session()->read('Auth.User.id')
                    ]);
            ?>
        </fieldset>
    </div>

    <script>
        document.getElementById('job-astatus-id').onchange = function() {
            var index = document.getElementById('job-astatus-id').value;
            var selectedText = document.getElementById('job-astatus-id').options[index].text;
            var res = selectedText.search('scheduled');
            if (res > 0){
                document.getElementById('open').checked = true;
            }
        }
        document.getElementById('job-bstatus-id').onchange = function() {
            var index = document.getElementById('job-bstatus-id').value;
            var selectedText = document.getElementById('job-bstatus-id').options[index].text;
            var res = selectedText.search('closed');
            if (res > 0){
                document.getElementById('closed').checked = true;
            }
        }
    </script>
<hr/>
    <?= $this->Form->button(__('Save'),
        array(
            'class' => 'btn btn-success',
            'div' => false
            ));
         echo $this->Html->link('' . __('Go back'), ['controller' => 'Jobs', 'action' => 'index'], array(
                'escape' => false,
                'class' => 'btn btn-default',
                'style' => 'margin-left:10px'

            ));
    ?>
    <?= $this->Form->end() ?>
</div>

