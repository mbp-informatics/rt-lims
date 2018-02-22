<hr/>
    <?= $this->Html->link('<span class="glyphicon glyphicon-plus"></span> '.__('New Qc Customer Invivo'), ['action' => 'add'], array('escape' => false, 'class' => 'btn btn-warning pad-button')) ?>
        <?= $this->Html->link('<span class="glyphicon glyphicon-list-alt"></span> ' .__('List Users'), ['controller' => 'Users', 'action' => 'index'], array('escape' => false, 'class' => 'btn btn-warning pad-button')) ?>
        <?= $this->Html->link('<span class="glyphicon glyphicon-plus"></span> '.__('New User'), ['controller' => 'Users', 'action' => 'add'], array('escape' => false, 'class' => 'btn btn-warning pad-button')) ?>
<hr/>
<div class="qcCustomerInvivos index large-9 medium-8 columns content">
    <h3><?= __('Qc Customer Invivos') ?></h3>
    <table class="data-table table stripe order-column">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('id') ?></th>
                <th><?= $this->Paginator->sort('komp_clones_dump_id') ?></th>
                <th><?= $this->Paginator->sort('order_id') ?></th>
                <th><?= $this->Paginator->sort('starting_product') ?></th>
                <th><?= $this->Paginator->sort('injection_outcome') ?></th>
                <th><?= $this->Paginator->sort('germline_outcome') ?></th>
                <th><?= $this->Paginator->sort('updated') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($qcCustomerInvivos as $qcCustomerInvivo): ?>
            <tr>
                <td><?= $this->Number->format($qcCustomerInvivo->id) ?></td>
                <td><?= $this->Number->format($qcCustomerInvivo->komp_clones_dump_id) ?></td>
                <td><?= $this->Number->format($qcCustomerInvivo->order_id) ?></td>
                <td><?= h($qcCustomerInvivo->starting_product) ?></td>
                <td><?= h($qcCustomerInvivo->injection_outcome) ?></td>
                <td><?= h($qcCustomerInvivo->germline_outcome) ?></td>
                <td><?= h($qcCustomerInvivo->updated) ?></td>
                <td class="actions">
                    <?= '<span data-toggle="tooltip" title="View">'. $this->Html->link('<span class="pad-action-glyph glyphicon glyphicon-eye-open"></span>', ['action' => 'view', $qcCustomerInvivo->id],  array('escape' => false, 'class' => 'label label-primary action-pad')) . '</span>' ?>
                    <?= '<span data-toggle="tooltip" title="Edit">'. $this->Html->link('<span class="pad-action-glyph glyphicon glyphicon-pencil"></span>', ['action' => 'edit', $qcCustomerInvivo->id], array('escape' => false, 'class' => 'label label-success action-pad')) . '</span>' ?>
                    <?= '<span data-toggle="tooltip" title="Delete">'. $this->Form->postLink('<span class="pad-action-glyph glyphicon glyphicon glyphicon-trash"></span> ', ['action' => 'delete', $qcCustomerInvivo->id], ['escape' => false, 'class' => 'label label-danger action-pad', 'confirm' => __('Are you sure you want to delete # {0}?', $qcCustomerInvivo->id)]) . '</span>' ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
