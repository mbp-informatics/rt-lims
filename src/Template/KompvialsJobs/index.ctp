<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Kompvials Job'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Jobs'), ['controller' => 'Jobs', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Job'), ['controller' => 'Jobs', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="kompvialsJobs index large-9 medium-8 columns content">
    <h3><?= __('Kompvials Jobs') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('job_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('komp_vial_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('user_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($kompvialsJobs as $kompvialsJob): ?>
            <tr>
                <td><?= $this->Number->format($kompvialsJob->id) ?></td>
                <td><?= $kompvialsJob->has('job') ? $this->Html->link($kompvialsJob->job->id, ['controller' => 'Jobs', 'action' => 'view', $kompvialsJob->job->id]) : '' ?></td>
                <td><?= $this->Number->format($kompvialsJob->komp_vial_id) ?></td>
                <td><?= $kompvialsJob->has('user') ? $this->Html->link($kompvialsJob->user->name, ['controller' => 'Users', 'action' => 'view', $kompvialsJob->user->id]) : '' ?></td>
                <td><?= h($kompvialsJob->created) ?></td>
                <td><?= h($kompvialsJob->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $kompvialsJob->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $kompvialsJob->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $kompvialsJob->id], ['confirm' => __('Are you sure you want to delete # {0}?', $kompvialsJob->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
    </div>
</div>
