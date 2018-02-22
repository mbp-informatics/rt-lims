<?php
 echo '<span data-toggle="tooltip" title="Delete">' . $this->Form->postLink('<span class="glyphicon glyphicon-trash"></span> Delete Job Comment ',
                                    ['action' => 'delete',$jobComment->id],
                                    array(
                                        'escape' => false,
                                        'class' => 'btn btn-danger pull-right',
                                        'style' => 'color:#fff;',
                                        'confirm' => __('Are you sure you want to delete # {0}?', $jobComment->id)
                                    )) . '</span>';
?>
<div class="clearfix"></div>

<div class="jobComments form large-9 medium-8 columns content">
    <?= $this->Form->create($jobComment) ?>
    <fieldset>
        <legend><?= __('Edit Job Comment #' . $jobComment->id) ?></legend>
        <?php
            echo $this->Form->hidden('job_id', [
                'options' => $jobs,
                'empty' => false,
                'default' => $jobComment->job_id,
                'label' => 'Job ID'
                ]);
            echo $this->Form->hidden('user_id', ['options' => $users, 'empty' => true]);
            echo $this->Form->input('comment');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Save'),
        array(
            'class' => 'btn btn-success',
            'div' => false
            ));
         echo $this->Html->link('' . __('Go back'), ['controller' => 'Jobs', 'action' => 'view', $jobComment->job_id], array(
                'escape' => false,
                'class' => 'btn btn-default',
                'style' => 'margin-left:10px'
        ));
    ?> 
    <?= $this->Form->end() ?>
</div>
