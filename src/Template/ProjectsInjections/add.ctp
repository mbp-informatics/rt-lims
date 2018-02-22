<?php
/**
  * @var \App\View\AppView $this
  */
?>
<div class="projectsInjections form large-9 medium-8 columns content">
    <?= $this->Form->create($projectsInjection) ?>
    <fieldset>
        <legend><?= __('Add Projects Injection') ?></legend>
        <?php
            echo $this->Form->input('project_id', ['options' => $projects, 'empty' => true, 'label'=>'RT-LIMS Project ID']);
            echo $this->Form->input('injection_id', ['options' => $injections, 'empty' => true, 'label'=>'Injection ID']);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
<script>
$( document ).ready(function() {
    var $select = $('#project-id').selectize({ //prepare selectize object (projects dropdown) for later use
        placeholder:"Select from dropdown or start typing..."
    });
    var $select = $('#injection-id').selectize({ //prepare selectize object (projects dropdown) for later use
        placeholder:"Select from dropdown or start typing..."
    });
});
</script>
