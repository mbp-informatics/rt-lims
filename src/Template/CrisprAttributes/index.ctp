<hr/>
<?php
echo $this->Html->link('<span class="glyphicon glyphicon-plus"></span> ' . __('New Crispr Attribute'), ['controller' => 'CrisprAttributes', 'action' => 'add'], array('escape' => false, 'class' => 'btn btn-warning pad-button'));
echo $this->Html->link('<span class="glyphicon glyphicon-list-alt"></span> ' . __('List Crispr Designs'), ['controller' => 'CrisprDesigns', 'action' => 'index'], array('escape' => false, 'class' => 'btn btn-warning pad-button'));
echo $this->Html->link('<span class="glyphicon glyphicon-plus"></span> ' . __('New Crispr Design'), ['controller' => 'CrisprDesigns', 'action' => 'add'], array('escape' => false, 'class' => 'btn btn-warning pad-button'));
?>
<hr/>
<div class="crisprAttributes index large-9 medium-8 columns content">
    <h2><?= __('Crispr Attributes') ?></h2>
    <hr/>
    <table class="data-table table stripe order-column">
        <thead>
            <tr>
                <th>ID</th>
                <th>Crispr Design</th>
                <th>Sequence</th>
                <th>Chromosome</th>
                <th>Chr Start</th>
                <th>Chr End</th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($crisprAttributes as $crisprAttribute): ?>
            <tr>
                <td><?= $this->Number->format($crisprAttribute->id) ?></td>
                <td><?= $crisprAttribute->has('crispr_design') ? $this->Html->link($crisprAttribute->crispr_design->name, ['controller' => 'CrisprDesigns', 'action' => 'view', $crisprAttribute->crispr_design->id]) : '' ?></td>
                <td><?= h($crisprAttribute->sequence) ?></td>
                <td><?= h($crisprAttribute->chromosome) ?></td>
                <td><?= $this->Number->format($crisprAttribute->chr_start) ?></td>
                <td><?= $this->Number->format($crisprAttribute->chr_end) ?></td>
                <td class="actions">
                    <?php
                echo '<span data-toggle="tooltip" title="View">' . $this->Html->link('<span class="pad-action-glyph glyphicon glyphicon-eye-open"></span>', ['action' => 'view', $crisprAttribute->id], array('escape' => false, 'class' => 'label label-primary action-pad')) . '</span>';
                echo '<span data-toggle="tooltip" title="Edit">' . $this->Html->link('<span class="pad-action-glyph glyphicon glyphicon-pencil"></span>', ['action' => 'edit', $crisprAttribute->id], array('escape' => false, 'class' => 'label label-success action-pad')) . '</span>';
                echo '<span data-toggle="tooltip" title="Delete">' . $this->Form->postLink('<span class="pad-action-glyph glyphicon glyphicon glyphicon-trash"></span> ',
                                ['action' => 'delete', $crisprAttribute->id],
                                array(
                                    'escape' => false,
                                    'class' => 'label label-danger action-pad',
                                    'confirm' => __('Are you sure you want to delete # {0}?', $crisprAttribute->id)
                                )) . '</span>';
                ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <!--
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
        </ul>
        <p><?= $this->Paginator->counter() ?></p>
    </div>
    -->
</div>
