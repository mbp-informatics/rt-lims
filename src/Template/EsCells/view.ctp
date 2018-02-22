<div class="esCells view large-9 medium-8 columns content">
    <h3><?= __('ES Cell')." #".h($esCell->id) ?></h3>
    <div class='alert alert-info' role='alert'>ES Cell Information</div>
    <div class='container-fluid'>
        <div class='row'>
            <div class='col-xs-3'><strong><?= __('Inventory Vial') ?>: </strong><?= $esCell->has('inventory_vial') ? $this->Html->link($esCell->inventory_vial->label, ['controller' => 'InventoryVials', 'action' => 'view', $esCell->inventory_vial->id]) : '' ?></div>
            <div class='col-xs-3'><strong><?= __('Parent ES Cell') ?>: </strong><?= $esCell->has('parent_es_cell') ? $this->Html->link($esCell->parent_es_cell->id, ['controller' => 'EsCells', 'action' => 'view', $esCell->parent_es_cell->id]) : '' ?></div>
            <div class='col-xs-3'><strong><?= __('DNA') ?>: </strong><?= $this->Number->format($esCell->dna) ?></div>
            <div class='col-xs-3'><strong><?= __('Quality Control') ?>: </strong><?= $esCell->has('quality_control') ? $this->Html->link($esCell->quality_control->pass . ', ' . $esCell->quality_control->id, ['controller' => 'QualityControls', 'action' => 'view', $esCell->quality_control->id]) : '' ?></div>
        </div>
        <div class='row'>
            <div class='col-xs-4'><strong><?= __('MRA Treated') ?>: </strong><?= $this->Number->format($esCell->mra_treated) ?></div>
            <div class='col-xs-4'><strong><?= __('Passage') ?>: </strong><?= $this->Number->format($esCell->passage) ?></div>
            <div class='col-xs-4'><strong><?= __('Status') ?>: </strong><?= $esCell->status ? __('Yes') : __('No'); ?></div>
        </div>
        <div class='row'>
            <div class='col-xs-3'><strong><?= __('Frozen By') ?>: </strong><?= h($esCell->frozen_by) ?></div>
            <div class='col-xs-3'><strong><?= __('Frozen Date') ?>: </strong><?= h($esCell->frozen_date) ?></div>
            <div class='col-xs-3'><strong><?= __('Disposal By') ?>: </strong><?= h($esCell->disposal_by) ?></div>
            <div class='col-xs-3'><strong><?= __('Disposal Date') ?>: </strong><?= h($esCell->disposal_date) ?></div>
        </div>
    </div>
    <div class='alert alert-info' role='alert'>Meta</div>
    <div class='container-fluid'>
        <div class='row'>
            <div class='col-xs-3'><strong><?= __('Created') ?>: </strong><?= h($esCell->created) ?></div>
            <div class='col-xs-3'><strong><?= __('Modified') ?>: </strong><?= h($esCell->modified) ?></div>
        </div>
    <hr>
    <div class="related">
        <?php if (!empty($esCell->child_es_cells)): ?>
        <h4><?= __('Related Es Cells') ?></h4>
        <table class="data-table table stripe order-column">
            <tr>
                <th><?= __('ID') ?></th>
                <th><?= __('Inventory Vial ID') ?></th>
                <th><?= __('Frozen Date') ?></th>
                <th><?= __('Passage') ?></th>
                <th><?= __('Parent ID') ?></th>
                <th><?= __('Status') ?></th>
                <th><?= __('Mra Treated') ?></th>
                <th><?= __('Myco Pos') ?></th>
                <th><?= __('Created') ?></th>
                <th><?= __('Modified') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($esCell->child_es_cells as $childEsCells): ?>
            <tr>
                <td><?= h($childEsCells->id) ?></td>
                <td><?= h($childEsCells->inventory_vial_id) ?></td>
                <td><?= h($childEsCells->frozen_date) ?></td>
                <td><?= h($childEsCells->passage) ?></td>
                <td><?= h($childEsCells->parent_id) ?></td>
                <td><?= h($childEsCells->status) ?></td>
                <td><?= h($childEsCells->mra_treated) ?></td>
                <td><?= h($childEsCells->myco_pos) ?></td>
                <td><?= h($childEsCells->created) ?></td>
                <td><?= h($childEsCells->modified) ?></td>
                <td class="actions">
                    <?= '<span data-toggle="tooltip" title="View">'. $this->Html->link('<span class="pad-action-glyph glyphicon glyphicon-eye-open"></span>', ['action' => 'view', $esCell->id],  array('escape' => false, 'class' => 'label label-primary action-pad')) . '</span>' ?>
                    <?= '<span data-toggle="tooltip" title="Edit">'. $this->Html->link('<span class="pad-action-glyph glyphicon glyphicon-pencil"></span>', ['action' => 'edit', $esCell->id], array('escape' => false, 'class' => 'label label-success action-pad')) . '</span>' ?>
                    <?= '<span data-toggle="tooltip" title="Delete">'. $this->Form->postLink('<span class="pad-action-glyph glyphicon glyphicon glyphicon-trash"></span> ', ['action' => 'delete', $esCell->id], ['escape' => false, 'class' => 'label label-danger action-pad', 'confirm' => __('Are you sure you want to delete # {0}?', $esCell->id)]) . '</span>' ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
    </div>


    <?php echo $this->Html->link('<span class="glyphicon glyphicon-plus"></span> ' . __('Add QC Testing for this Vial'),
        [
        'controller' => 'QualityControls',
        'action' => 'add',
        $esCell->id,
        ], array(
            'escape' => false,
            'class' => 'btn btn-success pad-button'
            ));    
?>
</div>
