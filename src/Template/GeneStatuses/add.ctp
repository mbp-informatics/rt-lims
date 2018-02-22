<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Gene Statuses'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Genes Statuses'), ['controller' => 'GenesStatuses', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Genes Status'), ['controller' => 'GenesStatuses', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="geneStatuses form large-9 medium-8 columns content">
    <?= $this->Form->create($geneStatus) ?>
    <fieldset>
        <legend><?= __('Add Gene Status') ?></legend>
        <?php
            echo $this->Form->input('gene_status');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
