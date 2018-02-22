<?php
/**
  * @var \App\View\AppView $this
  */
?>
<div class="phenotypes form large-9 medium-8 columns content">
    <?= $this->Form->create($phenotype) ?>
    <fieldset>
        <legend><?= __('Edit Phenotype') ?></legend>
        <?php
            echo $this->Form->input('type');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
