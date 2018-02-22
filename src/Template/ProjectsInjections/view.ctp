<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Projects Injection'), ['action' => 'edit', $projectsInjection->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Projects Injection'), ['action' => 'delete', $projectsInjection->id], ['confirm' => __('Are you sure you want to delete # {0}?', $projectsInjection->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Projects Injections'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Projects Injection'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Projects'), ['controller' => 'Projects', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Project'), ['controller' => 'Projects', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Injections'), ['controller' => 'Injections', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Injection'), ['controller' => 'Injections', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="projectsInjections view large-9 medium-8 columns content">
    <h3><?= h($projectsInjection->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Project') ?></th>
            <td><?= $projectsInjection->has('project') ? $this->Html->link($projectsInjection->project->id, ['controller' => 'Projects', 'action' => 'view', $projectsInjection->project->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Injection') ?></th>
            <td><?= $projectsInjection->has('injection') ? $this->Html->link($projectsInjection->injection->id, ['controller' => 'Injections', 'action' => 'view', $projectsInjection->injection->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('User') ?></th>
            <td><?= $projectsInjection->has('user') ? $this->Html->link($projectsInjection->user->name, ['controller' => 'Users', 'action' => 'view', $projectsInjection->user->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($projectsInjection->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($projectsInjection->created) ?></td>
        </tr>
    </table>
</div>
