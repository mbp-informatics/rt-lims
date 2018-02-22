<hr/>
        <?= $this->Html->link('<span class="glyphicon glyphicon-list-alt"></span> ' .__('List Embryo Transfers'), ['controller' => 'EmbryoTransfers', 'action' => 'index'], array('escape' => false, 'class' => 'btn btn-warning pad-button')) ?>
<?php echo $this->CustomForm->displaySearchBox() ?>
<hr/>
<div class="recipients index large-9 medium-8 columns content">
    <h3><?= __('Recipients') ?></h3>
    <table class="table stripe order-column">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('id') ?></th>
                <th><?= $this->Paginator->sort('ear_mark') ?></th>
                <th><?= $this->Paginator->sort('weight') ?></th>
                <th><?= $this->Paginator->sort('dob') ?></th>
                <th><?= $this->Paginator->sort('embryo_stage') ?></th>
                <th><?= $this->Paginator->sort('anesthetic_vol') ?></th>
                <th><?= $this->Paginator->sort('analgesic_vol') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($recipients as $recipient): ?>
            <tr>
                <td><?= $this->Number->format($recipient->id) ?></td>
                <td><?= h($recipient->ear_mark) ?></td>
                <td><?= $this->Number->format($recipient->weight) ?></td>
                <td><?= h($recipient->dob) ?></td>
                <td><?= h($recipient->embryo_stage) ?></td>
                <td><?= $this->Number->format($recipient->anesthetic_vol) ?></td>
                <td><?= $this->Number->format($recipient->analgesic_vol) ?></td>
                <td class="actions">
                    <?= '<span data-toggle="tooltip" title="View">'. $this->Html->link('<span class="pad-action-glyph glyphicon glyphicon-eye-open"></span>', ['action' => 'view', $recipient->id],  array('escape' => false, 'class' => 'label label-primary action-pad')) . '</span>' ?>
                    <?= '<span data-toggle="tooltip" title="Edit">'. $this->Html->link('<span class="pad-action-glyph glyphicon glyphicon-pencil"></span>', ['action' => 'edit', $recipient->id], array('escape' => false, 'class' => 'label label-success action-pad')) . '</span>' ?>
                    <?= '<span data-toggle="tooltip" title="Delete">'. $this->Form->postLink('<span class="pad-action-glyph glyphicon glyphicon glyphicon-trash"></span> ', ['action' => 'delete', $recipient->id], ['escape' => false, 'class' => 'label label-danger action-pad', 'confirm' => __('Are you sure you want to delete # {0}?', $recipient->id)]) . '</span>' ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
  <hr/>
    <div class="pull-right">
        <?php echo $this->Paginator->numbers(); ?>
    </div>