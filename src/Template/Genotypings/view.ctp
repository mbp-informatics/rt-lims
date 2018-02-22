<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Genotyping'), ['action' => 'edit', $genotyping->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Genotyping'), ['action' => 'delete', $genotyping->id], ['confirm' => __('Are you sure you want to delete # {0}?', $genotyping->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Genotypings'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Genotyping'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Ivfs'), ['controller' => 'Ivfs', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Ivf'), ['controller' => 'Ivfs', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Sperm Cryos'), ['controller' => 'SpermCryos', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Sperm Cryo'), ['controller' => 'SpermCryos', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Embryo Cryos'), ['controller' => 'EmbryoCryos', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Embryo Cryo'), ['controller' => 'EmbryoCryos', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Genotype Requests'), ['controller' => 'GenotypeRequests', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Genotype Request'), ['controller' => 'GenotypeRequests', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="genotypings view large-9 medium-8 columns content">
    <h3><?= h($genotyping->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Source') ?></th>
            <td><?= h($genotyping->source) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Ivf') ?></th>
            <td><?= $genotyping->has('ivf') ? $this->Html->link($genotyping->ivf->id, ['controller' => 'Ivfs', 'action' => 'view', $genotyping->ivf->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Sperm Cryo') ?></th>
            <td><?= $genotyping->has('sperm_cryo') ? $this->Html->link($genotyping->sperm_cryo->id, ['controller' => 'SpermCryos', 'action' => 'view', $genotyping->sperm_cryo->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Embryo Cryo') ?></th>
            <td><?= $genotyping->has('embryo_cryo') ? $this->Html->link($genotyping->embryo_cryo->id, ['controller' => 'EmbryoCryos', 'action' => 'view', $genotyping->embryo_cryo->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Genotype Request') ?></th>
            <td><?= $genotyping->has('genotype_request') ? $this->Html->link($genotyping->genotype_request->id, ['controller' => 'GenotypeRequests', 'action' => 'view', $genotyping->genotype_request->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Male Id No') ?></th>
            <td><?= h($genotyping->male_id_no) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Genotype') ?></th>
            <td><?= h($genotyping->genotype) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Note') ?></th>
            <td><?= h($genotyping->note) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($genotyping->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Embryo Count') ?></th>
            <td><?= $this->Number->format($genotyping->embryo_count) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($genotyping->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($genotyping->modified) ?></td>
        </tr>
    </table>
</div>
