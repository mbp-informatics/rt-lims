<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Kompvials Job'), ['action' => 'edit', $kompvialsJob->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Kompvials Job'), ['action' => 'delete', $kompvialsJob->id], ['confirm' => __('Are you sure you want to delete # {0}?', $kompvialsJob->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Kompvials Jobs'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Kompvials Job'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Jobs'), ['controller' => 'Jobs', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Job'), ['controller' => 'Jobs', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="kompvialsJobs view large-9 medium-8 columns content">
    <h3><?= h($kompvialsJob->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Job') ?></th>
            <td><?= $kompvialsJob->has('job') ? $this->Html->link($kompvialsJob->job->id, ['controller' => 'Jobs', 'action' => 'view', $kompvialsJob->job->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('User') ?></th>
            <td><?= $kompvialsJob->has('user') ? $this->Html->link($kompvialsJob->user->name, ['controller' => 'Users', 'action' => 'view', $kompvialsJob->user->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($kompvialsJob->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Komp Vial Id') ?></th>
            <td><?= $this->Number->format($kompvialsJob->komp_vial_id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($kompvialsJob->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($kompvialsJob->modified) ?></td>
        </tr>
    </table>
</div>
