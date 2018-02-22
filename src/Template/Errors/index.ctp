<?php
/**
  * @var \App\View\AppView $this
  */
?>
<div class="errors index large-9 medium-8 columns content horizontal-table">
    <h3><?= __('Errors') ?></h3>
    <table class="data-table table stripe order-column">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('entity_id_no') ?></th>
                <th scope="col"><?= $this->Paginator->sort('error_type') ?></th>
                <th scope="col"><?= $this->Paginator->sort('error') ?></th>
                <th scope="col"><?= $this->Paginator->sort('user_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($errors as $error): ?>
            <tr>
                <td><?= $this->Number->format($error->id) ?></td>
                <td><?= h($error->entity_id_no) ?></td>
                <td><?= h($error->error_type) ?></td>
                <td><?= h($error->error) ?></td>
                <td><?= $error->has('user') ? $this->Html->link($error->user->name, ['controller' => 'Users', 'action' => 'view', $error->user->id]) : '' ?></td>
                <td><?= h($error->created) ?></td>
                <td class="actions">
                    <span class="glyphicon glyphicon-zoom-in"></span>
                    <?= $this->Html->link(__('View var dump'), ['action' => 'view', $error->id]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <strong>Note:</strong> "Entity Id No" is,, for example, Injection ID when adding an injection.
</div>
