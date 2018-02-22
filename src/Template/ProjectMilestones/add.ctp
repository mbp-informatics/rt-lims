<div class="projectMilestones form large-9 medium-8 columns content">
    <?= $this->Form->create($projectMilestone) ?>
    <fieldset>
        <legend><?= __('Add Project Milestone') ?></legend>
        <?php
            echo $this->Form->input('project_id', ['options' => $projects, 'empty' => true]);
            echo $this->Form->input('project_status_id', ['options' => $projectStatuses, 'empty' => true]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit'),
        array(
            'class' => 'btn btn-success',
            'div' => false
            )); ?>
    <?= $this->Form->end() ?>
</div>
