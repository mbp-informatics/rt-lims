<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Genotypings'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Ivfs'), ['controller' => 'Ivfs', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Ivf'), ['controller' => 'Ivfs', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Sperm Cryos'), ['controller' => 'SpermCryos', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Sperm Cryo'), ['controller' => 'SpermCryos', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Embryo Cryos'), ['controller' => 'EmbryoCryos', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Embryo Cryo'), ['controller' => 'EmbryoCryos', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Genotype Requests'), ['controller' => 'GenotypeRequests', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Genotype Request'), ['controller' => 'GenotypeRequests', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="genotypings form large-9 medium-8 columns content">
    <?= $this->Form->create($genotyping) ?>
    <fieldset>
        <legend><?= __('Add Genotyping') ?></legend>
        <?php
            echo $this->Form->input('source');
            echo $this->Form->input('ivf_id', ['options' => $ivfs, 'empty' => true]);
            echo $this->Form->input('sperm_cryo_id', ['options' => $spermCryos, 'empty' => true]);
            echo $this->Form->input('embryo_cryo_id', ['options' => $embryoCryos, 'empty' => true]);
            echo $this->Form->input('genotype_request_id', ['options' => $genotypeRequests, 'empty' => true]);
            echo $this->Form->input('male_id_no');
            echo $this->Form->input('genotype');
            echo $this->Form->input('note');
            echo $this->Form->input('embryo_count');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
