<div class="qcGenotypes form large-9 medium-8 columns content">
    <?= $this->Form->create($qcGenotype) ?>
    <div class='container-fluid'>
        <fieldset>
            <?php $passOptions = ['Passed' => 'Passed', 'Failed'=>'Failed', 'Inconclusive'=>'Inconclusive']; ?>
            <?php $morePassOptions = ['Pass' => 'Pass', 'Fail'=>'Fail', 'Inconclusive'=>'Inconclusive', "SA Missing"=> "SA Missing"]; ?>
            <?php $loxpOptions = ['0%' => '0%', '100%'=>'100%', 'Inconclusive'=>'Inconclusive', "Cell Mix"=> "Cell Mix", "No Data Required"=> "No Data Required"]; ?>
            <legend><?= __('Edit QC Genotype') ?></legend>
            <div class='row'>
                <div class='col-xs-3'><?php echo $this->Form->input('quality_control_id', ['options' => $qualityControls, 'empty' => true]); ?></div>
                <!-- <div class='col-xs-3'><?php echo $this->Form->input('inventory_vial_id'); ?></div> -->
                <div class='col-xs-3'><?php echo $this->Form->input('pass', ['options' => $passOptions, 'empty' => true, 'default' => '']); ?></div>
                <div class='col-xs-3'>
                    <label class="control-label" for="positive_control">Used Positive Control? </label>
                    <div class="switch-toggle well">
                        <input id="positive_control-yes" name="positive_control" type="radio" value="Yes">
                        <label class="pointer" for="positive_control-yes">Yes</label>
                        <input id="positive_control-no" name="positive_control" value="No" type="radio" checked>
                        <label class="pointer" for="positive_control-no">No</label>
                        <a class="progress-bar"></a>
                    </div>
                </div>
            </div>
            <div class='row'>
                <div class='col-xs-3'><?php echo $this->CustomForm->displayDatepickerField('started', ['empty'=>true, 'label'=>'Started (YYYY-MM-DD)']); ?></div>
                <div class='col-xs-3'><?php echo $this->Form->input('started_by'); ?></div>
                <div class='col-xs-3'><?php echo $this->CustomForm->displayDatepickerField('finished', ['empty'=>true, 'label'=>'Finished (YYYY-MM-DD)']); ?></div>
                <div class='col-xs-3'><?php echo $this->Form->input('finished_by'); ?></div>
            </div>
            <div class='row'>
                <div class='col-xs-2'><?php echo $this->Form->input('test5', ['options' => $morePassOptions, 'empty'=>true, 'label'=>"5' Junction"]); ?></div>
                <div class='col-xs-3'><?php echo $this->CustomForm->displayDatepickerField('date5', ['empty'=>true, 'label'=>"5' Junction Date (YYYY-MM-DD)"]); ?></div>
                <div class='col-xs-3'><?php echo $this->Form->input('test3', ['options' => $morePassOptions, 'empty'=>true, 'label'=>"3' loxP Junction"]); ?></div>
                <div class='col-xs-4'><?php echo $this->CustomForm->displayDatepickerField('date3', ['empty'=>true, 'label'=>"3' loxP Junction Date (YYYY-MM-DD)"]); ?></div>      
            </div>
            <div class='row'>
                <div class='col-xs-2'><?php echo $this->Form->input('test_loxp', ['options' => $loxpOptions, 'empty'=>true, 'label'=>"TaqMan loxP"]); ?></div>
                <div class='col-xs-3'><?php echo $this->CustomForm->displayDatepickerField('date_loxp', ['empty'=>true, 'label'=>"TaqMan loxP Date (YYYY-MM-DD)"]); ?></div> 
                <div class='col-xs-2'><?php echo $this->Form->input('testcopy1', ['options' => $morePassOptions, 'empty'=>true, 'label'=>"Copy# = 1"]); ?></div>
                <div class='col-xs-2'><?php echo $this->Form->input('testcopy1value', ['label'=>"Copy#"]); ?></div>
                <div class='col-xs-3'><?php echo $this->CustomForm->displayDatepickerField('date_copy', ['empty'=>true, 'label'=>"Copy # Date (YYYY-MM-DD)"]); ?></div> 
            </div>
            <div class='row'>
                <div class='col-xs-2'><?php echo $this->Form->input('testLRPCR5', ['options' => $morePassOptions, 'empty'=>true, 'label'=>"5' LRPCR"]); ?></div>
                <div class='col-xs-3'><?php echo $this->CustomForm->displayDatepickerField('dateLRPCR5', ['empty'=>true, 'label'=>"5' LRPCR Date (YYYY-MM-DD)"]); ?></div> 
                <div class='col-xs-3'><?php echo $this->Form->input('test_integrity5', ['options' => $morePassOptions, 'empty'=>true, 'label'=>"5' Vector Integrity"]); ?></div> 
                <div class='col-xs-4'><?php echo $this->CustomForm->displayDatepickerField('date_integrity5', ['empty'=>true, 'label'=>"5' Integrity Date (YYYY-MM-DD)"]); ?></div>
            </div>
            <div class='row'>
                <div class='col-xs-2'><?php echo $this->Form->input('test_genome', ['options' => $morePassOptions, 'empty'=>true, 'label'=>"Genome Integrity"]); ?></div>
                <div class='col-xs-4'><?php echo $this->CustomForm->displayDatepickerField('date_genome', ['empty'=>true, 'label'=>"Genome Integrity Date (YYYY-MM-DD)"]); ?></div>
                <div class='col-xs-2'><?php echo $this->Form->input('lost_y', ['options' => $morePassOptions, 'empty'=>true, 'label'=>"Y Chromosome Lost"]); ?></div>
                <div class='col-xs-4'><?php echo $this->CustomForm->displayDatepickerField('date_y', ['empty'=>true, 'label'=>"Y Chromosome Lost Date (YYYY-MM-DD)"]); ?></div>
            </div>
            <div class='row'>              
                <div class='col-xs-3'><?php echo $this->Form->input('test_identity', ['options' => $morePassOptions, 'empty'=>true, 'label'=>"Clone Identity"]); ?></div>
                <div class='col-xs-3'><?php echo $this->Form->input('testLRPCR3', ['label'=>"3' LRPCR"]); ?></div>
                <div class='col-xs-3'><?php echo $this->CustomForm->displayDatepickerField('dateLRPCR3', ['empty'=>true, 'label'=>"3' LRPCR Date (YYYY-MM-DD)"]); ?></div> 
            </div>
            <div class='row'>
                <div class='col-xs-2'><?php echo $this->Form->input('loxp_result'); ?></div>
                <div class='col-xs-3'><?php echo $this->CustomForm->displayDatepickerField('date_loxp_result', ['empty'=>true, 'label'=>"loxP Date (YYYY-MM-DD)"]); ?></div>
                <div class='col-xs-3'><?php echo $this->Form->input('prime3_loxp_result'); ?></div>
                <div class='col-xs-4'><?php echo $this->CustomForm->displayDatepickerField('date_3prime_loxp_result', ['empty'=>true, 'label'=>"3' loxP Result Date (YYYY-MM-DD)"]); ?></div>
            </div>
        </fieldset>
        <?php
            echo $this->Form->hidden('user_id', [
                'options' => $users,
                'default' => $this->request->session()->read('Auth.User.id')
                ]);
        ?>
    </div>
    <?= $this->Form->button(__('Submit'),
        array(
            'class' => 'btn btn-success',
            'div' => false
            )); ?>
    <?= $this->Form->end() ?>
</div>
