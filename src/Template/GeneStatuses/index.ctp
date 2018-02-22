<?php
/**
  * @var \App\View\AppView $this
  */
?>
<?= $this->Html->link('<span class="glyphicon glyphicon-pencil"></span> '.__('Add Status'), ['action' => 'add'], array('escape' => false, 'class' => 'btn btn-warning pad-button'));  ?>
<hr/>
<div class="geneStatuses index large-9 medium-8 columns content horizontal-table">
    <h3><?= __('Gene Statuses') ?></h3>
    <table cellpadding="0" cellspacing="0" class="table table-striped">
        <thead>
            <tr>
                <th scope="col">id</th>
                <th scope="col">gene_status</th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($geneStatuses as $geneStatus): ?>
            <tr>
                <td><?= $this->Number->format($geneStatus->id) ?></td>
                <td><?= h($geneStatus->gene_status) ?></td>
                 <td class="actions">
                    <?= '<span data-toggle="tooltip" title="Delete">'. $this->Form->postLink('<span class="pad-action-glyph glyphicon glyphicon glyphicon-trash"></span> ', ['action' => 'delete', $geneStatus->id], ['escape' => false, 'class' => 'label label-danger action-pad', 'confirm' => __('Are you sure you want to delete # {0}?', $geneStatus->id)]) . '</span>' ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
