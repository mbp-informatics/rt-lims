<div class="jobTypes form large-9 medium-8 columns content">
    <?= $this->Form->create($jobType) ?>
    <div style="border-bottom:1px solid #aaa; margin-bottom:15px">
        <fieldset id='job-type-fieldset'>
            <div class='row' id="0-all-input-fields">
                <div class='col-sm-4'>
                <?php
                    echo $this->Form->input('job_type_name_id', ['options' => $jobTypeNames, 'required' => true, 'empty' => true, 'class' => 'job-names', 'id' => '0-job-type-name-id', 'label' => 'Select job type']);
                ?>
                </div>
                <div class='col-sm-4'>
                <?php echo $this->CustomForm->displayDatepickerField('scheduled_date1', ['empty'=>true]); ?>
                </div>
                <div class='col-sm-4'>
                <?php echo $this->CustomForm->displayDatepickerField('scheduled_date2', ['empty'=>true]); ?>
                </div>
            </div>
            <?php
                echo $this->Form->hidden('job_id', [
                    'options' => $jobs,
                    'empty' => false,
                    'default' => $job_id[0],
                    'label' => 'Job ID'
                    ]);
                echo $this->Form->hidden('user_id', [
                    'label' => 'Added by',
                    'options' => $users,
                    'empty' => false,
                    'default' => $this->request->session()->read('Auth.User.id'),
                    ]);
            ?>
            
    </fieldset>


    </div>
    <?= $this->Form->button(__('Submit'),
        array(
            'class' => 'btn btn-success',
            'div' => false
            ));
    ?>
    <?= $this->Form->end() ?>
</div>
