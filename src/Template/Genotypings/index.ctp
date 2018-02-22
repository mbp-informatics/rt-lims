<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Genotyping'), ['action' => 'add']) ?></li>
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
<div class="genotypings index large-9 medium-8 columns content">
    <h3><?= __('Genotypings') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('source') ?></th>
                <th scope="col"><?= $this->Paginator->sort('ivf_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('sperm_cryo_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('embryo_cryo_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('genotype_request_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('male_id_no') ?></th>
                <th scope="col"><?= $this->Paginator->sort('genotype') ?></th>
                <th scope="col"><?= $this->Paginator->sort('note') ?></th>
                <th scope="col"><?= $this->Paginator->sort('embryo_count') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($genotypings as $genotyping): ?>
            <tr>
                <td><?= $this->Number->format($genotyping->id) ?></td>
                <td><?= h($genotyping->source) ?></td>
                <td><?= $genotyping->has('ivf') ? $this->Html->link($genotyping->ivf->id, ['controller' => 'Ivfs', 'action' => 'view', $genotyping->ivf->id]) : '' ?></td>
                <td><?= $genotyping->has('sperm_cryo') ? $this->Html->link($genotyping->sperm_cryo->id, ['controller' => 'SpermCryos', 'action' => 'view', $genotyping->sperm_cryo->id]) : '' ?></td>
                <td><?= $genotyping->has('embryo_cryo') ? $this->Html->link($genotyping->embryo_cryo->id, ['controller' => 'EmbryoCryos', 'action' => 'view', $genotyping->embryo_cryo->id]) : '' ?></td>
                <td><?= $genotyping->has('genotype_request') ? $this->Html->link($genotyping->genotype_request->id, ['controller' => 'GenotypeRequests', 'action' => 'view', $genotyping->genotype_request->id]) : '' ?></td>
                <td><?= h($genotyping->male_id_no) ?></td>
                <td><?= h($genotyping->genotype) ?></td>
                <td><?= h($genotyping->note) ?></td>
                <td><?= $this->Number->format($genotyping->embryo_count) ?></td>
                <td><?= h($genotyping->created) ?></td>
                <td><?= h($genotyping->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $genotyping->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $genotyping->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $genotyping->id], ['confirm' => __('Are you sure you want to delete # {0}?', $genotyping->id)]) ?>
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
