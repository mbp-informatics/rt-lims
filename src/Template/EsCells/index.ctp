<!-- <hr/>
    <?= $this->Html->link('<span class="glyphicon glyphicon-plus"></span> '.__('New ES Cell'), ['action' => 'add'], array('escape' => false, 'class' => 'btn btn-warning pad-button')) ?>
<hr/>
<div class="esCells index large-9 medium-8 columns content horizontal-table">
    <h3><?= __('Es Cells') ?></h3>
    <table class="data-table table stripe order-column">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('id', ['label'=>'ID']) ?></th>
                <th><?= $this->Paginator->sort('dna', ['label'=>'DNA']) ?></th>
                <th><?= $this->Paginator->sort('frozen_date') ?></th>
                <th><?= $this->Paginator->sort('frozen_by') ?></th>
                <th><?= $this->Paginator->sort('passage') ?></th>
                <th><?= $this->Paginator->sort('parent_id', ['label'=>'Parent ES Cell']) ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($esCells as $esCell): ?>
            <tr>
                <td><?= h($esCell->id) ?></td>
                <td><?= h($esCell->dna) ?></td>
                <td><?= h($esCell->frozen_date) ?></td>
                <td><?= h($esCell->frozen_by) ?></td>
                <td><?= h($esCell->passage) ?></td>
                <td><?= $esCell->has('parent_es_cell') ? $this->Html->link($esCell->parent_es_cell->id, ['controller' => 'EsCells', 'action' => 'view', $esCell->parent_es_cell->id]) : '' ?></td>
                <td class="actions">
                    <?= '<span data-toggle="tooltip" title="View">'. $this->Html->link('<span class="pad-action-glyph glyphicon glyphicon-eye-open"></span>', ['action' => 'view', $esCell->id],  array('escape' => false, 'class' => 'label label-primary action-pad')) . '</span>' ?>
                    <?= '<span data-toggle="tooltip" title="Edit">'. $this->Html->link('<span class="pad-action-glyph glyphicon glyphicon-pencil"></span>', ['action' => 'edit', $esCell->id], array('escape' => false, 'class' => 'label label-success action-pad')) . '</span>' ?>
                    <?= '<span data-toggle="tooltip" title="Delete">'. $this->Form->postLink('<span class="pad-action-glyph glyphicon glyphicon glyphicon-trash"></span> ', ['action' => 'delete', $esCell->id], ['escape' => false, 'class' => 'label label-danger action-pad', 'confirm' => __('Are you sure you want to delete # {0}?', $esCell->id)]) . '</span>' ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
 -->
<script>
$(document).ready(function() {
    var selectorStr = '.data-table';
    var injectObj = [
        {
            'column':'actions', 
            'string': `
                "<span data-toggle='tooltip' title='View'><a href='/es-cells/view/"+ row.id_action +"' class='label label-primary action-pad'><span class='pad-action-glyph glyphicon glyphicon-eye-open'></span></a></span>"+
                "<span data-toggle='tooltip' title='Edit'><a href='/es-cells/edit/"+ row.id_action +"' class='label label-success action-pad'><span class='pad-action-glyph glyphicon glyphicon-pencil'></span></a></span>"
            `
        }
    ];
    var columns = ['id', 'dna', 'frozen_date', 'frozen_by', 'passage', 'parent_id', 'actions'];
    iniDataTableServerSide(selectorStr, columns, injectObj, null, null, {"iDisplayLength": 25});
});//end document ready
</script>

<?= $this->Html->link('<span class="glyphicon glyphicon-plus"></span> '.__('New ES Cell'), ['action' => 'add'], array('escape' => false, 'class' => 'btn btn-warning pad-button')) ?>
<hr/>
<div class="embryoCryos index large-9 medium-8 columns content horizontal-table">
    <h3><?= __('ES Cells') ?></h3>
    <table class="data-table table stripe order-column">
        <thead>
            <tr>
                <th>ES Cell ID</th>
                <th>DNA</th>
                <th>Frozen Date</th>
                <th>Frozen By</th>
                <th>Passage</th>
                <th>Parent ES Cell</th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
    </table>
    <hr/>
    <?= $this->CustomForm->displayAdvancedSearchInput($modelFields); ?>
    </hr>
</div>
