<?php
/**
  * @var \App\View\AppView $this
  */
?>
<div class="projectsGenes form large-9 medium-8 columns content">
    <?= $this->Form->create($projectsGene) ?>
    <fieldset>
        <legend><?= __('Add Projects Gene') ?></legend>
        <?php
            echo $this->Form->input('project_id', ['options' => $projects, 'empty' => true, 'label'=>'RT-LIMS Project ID']);
            echo $this->customForm->displayMgiGenesDropdown();
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
});
</script>