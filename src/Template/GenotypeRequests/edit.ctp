<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $genotypeRequest->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $genotypeRequest->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Genotype Requests'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Jobs'), ['controller' => 'Jobs', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Job'), ['controller' => 'Jobs', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Genotypings'), ['controller' => 'Genotypings', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Genotyping'), ['controller' => 'Genotypings', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="genotypeRequests form large-9 medium-8 columns content">
    <?= $this->Form->create($genotypeRequest) ?>
    <fieldset>
        <legend><?= __('Edit Genotype Request') ?></legend>
        <?php
            echo $this->Form->input('job_id', ['options' => $jobs, 'empty' => true]);
            echo $this->Form->input('sample_type');
            echo $this->Form->input('user_id', ['options' => $users, 'empty' => true]);
            echo $this->Form->input('collection_date', ['empty' => true]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
