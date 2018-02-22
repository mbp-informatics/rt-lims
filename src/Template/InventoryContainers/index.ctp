    <?= $this->Html->link('<span class="glyphicon glyphicon-plus"></span> '.__('New Inventory Container'), ['action' => 'add'], array('escape' => false, 'class' => 'btn btn-warning pad-button')) ?>
<hr/>
    <p style="margin:25px 0px;"><span class="important"><span class="glyphicon glyphicon-warning-sign"></span> Note: You can only delete <strong>non-empty</strong> containers (i.e. containers that do not contain other containers OR boxes).</span>
                </p>
<div class="inventoryContainers index large-9 medium-8 columns content">
    <h3><?= __('Inventory Containers') ?></h3>
    <table class="data-table table stripe order-column horizontal-table">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('id') ?></th>
                <th style="min-width:200px;">Hierarchy</th>
                <th>Has containers?</th>
                <th>Has boxes?</th>
                <th><?= $this->Paginator->sort('created') ?></th>
                <th><?= $this->Paginator->sort('modified') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($inventoryContainers as $inventoryContainer): ?>
            <tr>
                <td><?= $this->Number->format($inventoryContainer->id) ?></td>
                <td>
                <?php
                    $string = '';
                    if (isset($inventoryContainer->parents)) {
                        $string = $this->customForm->getContainersHierarchy($inventoryContainer->parents);
                    }
                    $string .= "<strong>" . h($inventoryContainer->name) . "</strong>";
                    echo $string;
                ?>
                </td>
                <td><?= !empty($inventoryContainer->child_inventory_containers) ? __('<span class="bool-yes glyphicon glyphicon-ok"> Yes</span>') : __('<span class="bool-no glyphicon glyphicon-remove"> No</span>'); ?></td>
                <td><?= !empty($inventoryContainer->inventory_boxes) ? __('<span class="bool-yes glyphicon glyphicon-ok"> Yes</span>') : __('<span class="bool-no glyphicon glyphicon-remove"> No</span>'); ?></td>
                <td><?= h($inventoryContainer->created) ?></td>
                <td><?= h($inventoryContainer->modified) ?></td>
                <td class="actions" style="text-align:left;">
                    <?= '<span data-toggle="tooltip" title="View">'. $this->Html->link('<span class="pad-action-glyph glyphicon glyphicon-eye-open"></span>', ['action' => 'view', $inventoryContainer->id],  array('escape' => false, 'class' => 'label label-primary action-pad')) . '</span>' ?>
                    <?= '<span data-toggle="tooltip" title="Edit">'. $this->Html->link('<span class="pad-action-glyph glyphicon glyphicon-pencil"></span>', ['action' => 'edit', $inventoryContainer->id], array('escape' => false, 'class' => 'label label-success action-pad')) . '</span>' ?>
                    <?php
                    if (empty($inventoryContainer->child_inventory_containers) && empty($inventoryContainer->inventory_boxes)) {
                        echo '<span data-toggle="tooltip" title="Delete">'. $this->Form->postLink('<span class="pad-action-glyph glyphicon glyphicon glyphicon-trash"></span> ', ['action' => 'delete', $inventoryContainer->id], ['escape' => false, 'class' => 'label label-danger action-pad', 'confirm' => __('Are you sure you want to delete # {0}?', $inventoryContainer->id)]) . '</span>';
                    }
                    ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
