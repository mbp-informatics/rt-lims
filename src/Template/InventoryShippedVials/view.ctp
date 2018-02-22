<?php
$originalVial = unserialize($inventoryShippedVial->original_vial_snapshot);
if (isset($inventoryShippedVial->sperm_cryo_id)) {
    $cryoId = $inventoryShippedVial->sperm_cryo_id;
    $cryoType = 'sperm';
}

if (isset($inventoryShippedVial->embryo_cryo_id)) {
    $cryoId = $inventoryShippedVial->embryo_cryo_id;
    $cryoType = 'embryo';
}

if (isset($inventoryShippedVial->escell_cryo_id)) {
    $cryoId = $inventoryShippedVial->escell_cryo_id;
    $cryoType = 'escell';
}
$originalContainerId = $originalVial['inventory_location']['inventory_box']['inventory_container_id'];
$originalBoxId = $originalVial['inventory_location']['inventory_box']['id'];
$originalTissue = (empty($inventoryShippedVial->tissue) || $inventoryShippedVial->tissue==0) ? 0 : 1;
// echo $this->Html->link('<span class="glyphicon glyphicon-pencil"></span> ' . __('Edit Shipped Vial'), ['controller' => 'InventoryShippedVials', 'action' => 'edit', $inventoryShippedVial->id], array('escape' => false, 'class' => 'btn btn-warning pull-right'));
?>

<?php if (empty($originalLocationTakenBy)){ ?>
    <!-- Unship vials form --> 
    <form action="/inventory-vials/add/<?= $cryoId ?>/<?= $cryoType ?>" method="POST">
    <input type="hidden" name="0[label]" value="<?= $inventoryShippedVial->label ?>">
    <input type="hidden" name="0[volume]" value="<?= $inventoryShippedVial->volume ?>">
    <input type="hidden" name="0[inventory_container_id]" value="<?= $originalContainerId ?>">
    <input type="hidden" name="0[inventory_box_id]" value="<?= $originalBoxId ?>">
    <input type="hidden" name="0[inventory_location_id]" value="<?= $inventoryShippedVial->original_location_id_no ?>">
    <input type="hidden" name="0[inventory_vial_type_id]" value="<?= $inventoryShippedVial->original_vial_type_id_no ?>">
    <input type="hidden" name="0[comments]" value="<?= $inventoryShippedVial->comments ?>">
    <input type="hidden" name="0[tissue]" value="<?= $originalTissue ?>">
    <input type="hidden" name="0[shipped_vial_id]" value="<?= $inventoryShippedVial->id ?>">
    <input type="hidden" name="0[pups]" value="<?= $inventoryShippedVial->pups ?>">
    <input type="hidden" name="0[qc_pass]" value="<?= $inventoryShippedVial->qc_pass ?>">
    <input type="hidden" name="0[do_not_distribute]" value="<?= $inventoryShippedVial->do_not_distribute ?>">
    <button type="submit" style="margin-right:10px;" class="btn btn-success pull-right"><span class="glyphicon glyphicon-pencil"></span> Restore (unship) Vial</button>
    </form>
<?php } ?>

<div class="inventoryShippedVials view large-9 medium-8 columns content">
    <h3><?= __('InventoryShippedVial')." #".h($inventoryShippedVial->id) ?></h3>
    <table class="table stripe order-column">
        <tr>
            <th><?= __('Ship/Thaw Date') ?></th>
            <td><?= isset($inventoryShippedVial->ship_thaw_date) ? $inventoryShippedVial->ship_thaw_date->format('n/j/Y') : '-' ?></td>
        </tr>
        <tr>
            <th><?= __('User') ?></th>
            <td><?= h($inventoryShippedVial->user->name) ?></td>
         </tr>
        <tr>
            <th><?= __('Ship/Thaw Reason') ?></th>
            <td><?= h($inventoryShippedVial->ship_thaw_reason) ?></td>
         </tr>
        <tr>
            <th><?= __('Order No') ?></th>
            <td><?= h($inventoryShippedVial->order_no) ?></td>
         </tr>
        <tr>
            <th><?= __('Sperm Cryo ID') ?></th>
            <td><?= $inventoryShippedVial->sperm_cryo_id ? $this->Html->link($inventoryShippedVial->sperm_cryo_id, ['controller' => 'SpermCryos', 'action' => 'view', $inventoryShippedVial->sperm_cryo_id]) : '-' ?></td>
         </tr>
        <tr>
        <tr>
            <th><?= __('Embryo Cryo ID') ?></th>
            <td><?= $inventoryShippedVial->embryo_cryo_id ? $this->Html->link($inventoryShippedVial->embryo_cryo_id, ['controller' => 'EmbryoCryos', 'action' => 'view', $inventoryShippedVial->embryo_cryo_id]) : '-' ?></td>
         </tr>
        <tr>
            <th><?= __('ES Cell ID') ?></th>
            <td><?= $inventoryShippedVial->es_cell_id ? h($inventoryShippedVial->es_cell_id) : '-' ?></td>
         </tr>
        <tr>
            <th><?= __('ID') ?></th>
            <td><?= $this->Number->format($inventoryShippedVial->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Label') ?></th>
            <td><?= h($inventoryShippedVial->label) ?></td>
        </tr>
        <tr>
            <th><?= __('Pups?') ?></th>
            <td><?= h($inventoryShippedVial->pups) ?></td>
        </tr>
        <tr>
            <th><?= __('QC Pass?') ?></th>
            <td><?= h($inventoryShippedVial->qc_pass) ?></td>
        </tr>
        <tr>
            <th><?= __('Distribute?') ?></th>
            <td><?= h($inventoryShippedVial->do_not_distribute) ?></td>
        </tr>
        <tr>
            <th><?= __('Volume') ?></th>
            <td><?= h($inventoryShippedVial->volume) ?></td>
        </tr>
        <tr>
            <th><?= __('Comments') ?></th>
            <td><?= h($inventoryShippedVial->comments) ?></td>
        </tr>
        <tr>
            <th><h2>Original Vial Snapshot</h2></th>
            <td><?= $this->CustomForm->displayCompound($originalVial) ?></td>
        </tr>
        <tr>
            <th><?= __('Original Vial ID No') ?></th>
            <td><?= $this->Number->format($inventoryShippedVial->original_vial_id_no) ?></td>
        </tr>
        <tr>
            <th><?= __('Original Location ID No') ?></th>
            <td><?= $this->Number->format($inventoryShippedVial->original_location_id_no) ?></td>
        </tr>
        <tr>
            <th><?= __('Original Vial Type ID No') ?></th>
            <td><?= $this->Number->format($inventoryShippedVial->original_vial_type_id_no) ?></td>
        </tr>
        <tr>
            <th><?= __('Original Created') ?></th>
            <td><?= h($inventoryShippedVial->original_created) ?></td>
        </tr>
        <tr>
            <th><?= __('Original Modified') ?></th>
            <td><?= h($inventoryShippedVial->original_modified) ?></td>
        </tr>
        <tr>
            <th><?= __('Tissue') ?></th>
            <td><?= $inventoryShippedVial->tissue ? __('Yes') : __('No'); ?></td>
         </tr>
    </table>
</div>