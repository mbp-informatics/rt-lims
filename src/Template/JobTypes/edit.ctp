<?php
 echo '<span data-toggle="tooltip" title="Delete">' . $this->Form->postLink('<span class="glyphicon glyphicon-trash"></span> Delete Job Type ',
                                    ['action' => 'delete',$jobType->id],
                                    array(
                                        'escape' => false,
                                        'class' => 'btn btn-danger pull-right',
                                        'style' => 'color:#fff;',
                                        'confirm' => __('Are you sure you want to delete Job Type association # {0}? This will NOT delete the Job Type definition', $jobType->id)
                                    )) . '</span>';
?>
<div class="clearfix"></div>
<div class="jobTypes form large-9 medium-8 columns content">
    <?= $this->Form->create($jobType) ?>
    <fieldset>
        <legend><?= __('Edit Job Type') ?></legend>
        <div class='row'>
            <?php
                echo $this->Form->hidden('job_id', [
                    'options' => $jobs,
                    'empty' => false,
                    'default' => $jobType->job_id,
                    'label' => 'Job ID'
                    ]);
            ?>
            <?php echo $this->Form->hidden('user_id', ['options' => $users, 'empty' => true]); ?>
            <div class='col-sm-4'>
                <?php echo $this->Form->input('job_type_name_id', ['options' => $jobTypeNames]); ?>
            </div>
            <div class='col-sm-4'>
                <?php
                    $value = isset($jobType->scheduled_date1) ? $jobType->scheduled_date1->format('Y-m-d') : '';
                    echo $this->CustomForm->displayDatepickerField('scheduled_date1', ['empty'=>true, 'value' => $value]);
                 ?>
            </div>
            <div class='col-sm-4'>
                <?php
                    $value = isset($jobType->scheduled_date2) ? $jobType->scheduled_date2->format('Y-m-d') : '';
                    echo $this->CustomForm->displayDatepickerField('scheduled_date2', ['empty'=>true, 'value' => $value]);
                 ?>
            </div>
        </div>
    </fieldset>
    <?= $this->Form->button(__('Save'),
        array(
            'class' => 'btn btn-success',
            'div' => false
            ));
?>
    <?= $this->Form->end() ?>
</div>
