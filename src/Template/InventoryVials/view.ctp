<script>
$( document ).ready(function() {    
    iniDialog('#ship-vial', '/inventory-shipped-vials/add', [<?= $inventoryVial->id ?>, <?= $inventoryVial->inventory_location_id ?>]);
});   
</script>


<?php
echo $this->Html->link('<span class="glyphicon glyphicon-pencil"></span> ' . __('Edit Vial'), ['controller' => 'InventoryVials', 'action' => 'edit', $inventoryVial->id], array('escape' => false, 'class' => 'btn btn-warning pull-right'));
?>
<div class="inventoryVials view large-9 medium-8 columns content">
    <h3><?= __('Vial')." ".h($inventoryVial->label) ?></h3>
    <div class='alert alert-info' role='alert'>Vial Information</div>
    <div class='container-fluid'>
        <div class='row'>
            <div class='col-xs-3'><strong><?= __('ID') ?>: </strong><?= $this->Number->format($inventoryVial->id) ?></div>
            <div class='col-xs-3'><strong><?= __('Label') ?>: </strong><?= h($inventoryVial->label) ?></div>
            <div class='col-xs-3'><strong><?= __('Volume') ?>: </strong><?= h($inventoryVial->volume) ?></div>
            <div class='col-xs-3'><strong><?= __('Inventory Vial Type') ?>: </strong><?= $inventoryVial->has('inventory_vial_type') ? $this->Html->link($inventoryVial->inventory_vial_type->name, ['controller' => 'InventoryVialTypes', 'action' => 'view', $inventoryVial->inventory_vial_type->id]) : '' ?></div>
        </div>
        <div class='row'>             
            <div class='col-xs-2'><strong><?= __('Tissue') ?>: </strong><?= $inventoryVial->tissue ? __('Yes') : __('No'); ?></div>
            <div class='col-xs-2'><strong><?= __('Distribute?') ?>: </strong><?= $inventoryVial->do_not_distribute ? __('No') : __('Yes'); ?></div>
            <div class='col-xs-3'><strong><?= __('QC Pass?') ?>: </strong><?= h($inventoryVial->qc_pass) ?></div>
            <div class='col-xs-2'><strong><?= __('Pups?') ?>: </strong><?= h($inventoryVial->pups) ?></div>
            <div class='col-xs-3'><strong><?= __('Embryo Cryo ID') ?>: </strong><a href="/embryo-cryos/view/<?= $inventoryVial->embryo_cryo_id ?>"><?= h($inventoryVial->embryo_cryo_id) ?></a></div>
        </div>
        <div class='row'>             
            <div class='col-xs-3'><strong><?= __('Sperm Cryo ID') ?>: </strong><a href="/sperm-cryos/view/<?= $inventoryVial->sperm_cryo_id ?>"><?= h($inventoryVial->sperm_cryo_id) ?></a></div>
            <div class='col-xs-3'><strong><?= __('ES Cell ID') ?>: </strong><a href="/es-cells/view/<?= $inventoryVial->es_cell_id ?>"><?= h($inventoryVial->es_cell_id) ?></a></div>
        </div>
        <hr/>
        <div class='row'> 
            <div class='col-xs-12'><strong><?= __('Comments') ?>: </strong><?= h($inventoryVial->comments); ?></div>
        </div>
      
    </div>
    <div class="related">
        <?php if (!empty($inventoryVial->inventory_location)): ?>
            <div class='alert alert-info' role='alert'>Location</div>
                <div class='container-fluid'>
                    <div class='row'>
                        <div class='col-xs-6'><strong><?= __('Container') ?>: </strong><?= $this->customForm->getContainerHierarchy($containerHierarchy); ?>><a href="/inventory-containers/view/<?= h($inventoryVial->inventory_location->inventory_box->inventory_container->id) ?>"><?= h($inventoryVial->inventory_location->inventory_box->inventory_container->name) ?></a></div> 
                        <div class='col-xs-2'><strong><?= __('Box Type') ?>: </strong><a href="/inventory-box-types/view/<?= h($inventoryVial->inventory_location->inventory_box->inventory_box_type->id) ?>"><?= h($inventoryVial->inventory_location->inventory_box->inventory_box_type->name) ?></a></div> 
                        <div class='col-xs-3'><strong><?= __('Box ') ?>: </strong><a href="/inventory-boxes/view/<?= h($inventoryVial->inventory_location->inventory_box->id) ?>"><?= h($inventoryVial->inventory_location->inventory_box->name) ?> (id:<?= h($inventoryVial->inventory_location->inventory_box->id) ?>)</a></div> 
                        <div class='col-xs-1'><strong><?= __('Cell') ?>: </strong><?= h($inventoryVial->inventory_location->cell) ?></div> 
                    </div>
                </div>
        <?php endif; ?>
    </div>
    <div class='alert alert-info' role='alert'>Meta</div>
    <div class='container-fluid'>
        <div class="row">            
            <div class='col-xs-3'><strong><?= __('Created') ?>: </strong><?= h($inventoryVial->created) ?></div>
            <div class='col-xs-3'><strong><?= __('Modified') ?>: </strong><?= h($inventoryVial->modified) ?></div>           
         </div>
    </div>
    <hr>
    <div class="related">
        <?php if (!empty($inventoryVial->inventory_shippings)): ?>
        <h4><?= __('Related Inventory Shippings') ?></h4>
        <table class="data-table table stripe order-column">
            <tr>
                <th><?= __('ID') ?></th>
                <th><?= __('Ship Date') ?></th>
                <th><?= __('Comments') ?></th>
                <th><?= __('Inventory Vial ID') ?></th>
                <th><?= __('Inventory Location ID') ?></th>
                <th><?= __('Contact ID') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($inventoryVial->inventory_shippings as $inventoryShippings): ?>
            <tr>
                <td><?= h($inventoryShippings->id) ?></td>
                <td><?= h($inventoryShippings->ship_date) ?></td>
                <td><?= h($inventoryShippings->comments) ?></td>
                <td><?= h($inventoryShippings->inventory_vial_id) ?></td>
                <td><?= h($inventoryShippings->inventory_location_id) ?></td>
                <td><?= h($inventoryShippings->contact_id) ?></td>
                <td class="actions">
                    <?= '<span data-toggle="tooltip" title="View">'. $this->Html->link('<span class="pad-action-glyph glyphicon glyphicon-eye-open"></span>', ['action' => 'view', 'controller' => 'InventoryShippings', $inventoryShipping->id],  array('escape' => false, 'class' => 'label label-primary action-pad')) . '</span>' ?>
                    <?= '<span data-toggle="tooltip" title="Edit">'. $this->Html->link('<span class="pad-action-glyph glyphicon glyphicon-pencil"></span>', ['action' => 'edit', 'controller' => 'InventoryShippings', $inventoryShipping->id], array('escape' => false, 'class' => 'label label-success action-pad')) . '</span>' ?>
                    <?= '<span data-toggle="tooltip" title="Delete">'. $this->Form->postLink('<span class="pad-action-glyph glyphicon glyphicon glyphicon-trash"></span> ', ['action' => 'delete', 'controller' => 'InventoryShippings', $inventoryShipping->id], ['escape' => false, 'class' => 'label label-danger action-pad', 'confirm' => __('Are you sure you want to delete # {0}?', $inventoryShipping->id)]) . '</span>' ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
    </div>
</div>
<div id="dialog-ship-vial" title="Ship/Thaw Vial"></div>
<button id="ship-vial" class="btn btn-success pad-button"><span class="glyphicon glyphicon-plus"></span> Ship/Thaw this vial</button> 
<?php
    echo $this->Html->link('' . __('Go back to all vials'), ['action' => 'index'], array(
            'escape' => false,
            'class' => 'btn btn-default pad-button'
    ));
?>  
