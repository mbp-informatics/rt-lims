<link rel="stylesheet" type="text/css" href="/webroot/css/inventory-box-grid.css">
<script>
var inventoryBoxId = <?= $inventoryBox->id ?>; //Global variable used by inventory-box-grid.js
</script>
<script src="/webroot/js/inventory-box-grid.js"></script> 
<div class="inventoryBoxes view large-9 medium-8 columns content">
    <div class='alert alert-info' role='alert'>Box Information</div>
    <div class='container-fluid'>
        <div class='row'>
            <div class='col-xs-2'><strong><?= __('ID') ?>: </strong><?= $this->Number->format($inventoryBox->id) ?></div>
            <div class='col-xs-2'><strong><?= __('Name') ?>: </strong><?= h($inventoryBox->name) ?></div>
            <div class='col-xs-6'><strong><?= __('Container') ?>: </strong><?= $this->customForm->getContainerHierarchy($containerHierarchy) ?>><?= $inventoryBox->has('inventory_container') ? $this->Html->link($inventoryBox->inventory_container->name, ['controller' => 'InventoryContainers', 'action' => 'view', $inventoryBox->inventory_container->id]) : '' ?></div>
            <div class='col-xs-2'><strong><?= __('Box Type') ?>: </strong><?= $inventoryBox->has('inventory_box_type') ? $this->Html->link($inventoryBox->inventory_box_type->name, ['controller' => 'InventoryBoxTypes', 'action' => 'view', $inventoryBox->inventory_box_type->id]) : '' ?></div>
        </div>
    </div>
<hr />
<h3/ id="freezer-view">Freezer Box View</h3>
<p>
<span class="important"><i class="fa fa-mouse-pointer" aria-hidden="true"></i>
 Drag and drop vials to change their location in the box.</span>
 <span class="important"><i class="fa fa-info" aria-hidden="true"></i>
 Click a vial to see detailed information.</span>
 <span class="important"><i class="fa fa-plus-circle" aria-hidden="true"></i>
 Click a plus sign in an empty cell to add a new vial.</span>
</p>

<!-- Grid containers -->
<div id='bg'>
  <div id="content">
    <div id="grid"></div>
    <div id="vialsGrid"></div>
  </div>
  <p style="text-align:center;margin-top:20px; float:left; width:100%" id="ajax-loader"><img src="/img/ajax-loader.gif"><small>Contacting server. Please wait...</small></p>
</div>
<hr class="fat" style="margin-top:0px">
    <div id="accordion" role="tablist" aria-multiselectable="true">
      <div class="panel panel-default horizontal-table">
        <a class="accord-head collapsed accord-head" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
          <div class="panel-heading alert-info" role="tab" id="headingOne">
            <h4 class="panel-title">
                Box spaces</sup> <span class="caret"></span>
            </h4>
          </div>
        </a>
        <div id="collapseOne" class="panel-collapse" role="tabpanel" aria-labelledby="headingOne">
            <div class="related" style="margin-top:20px;">
                <?php if (!empty($inventoryBox->inventory_locations)): ?>
                <table class="table" width="100%" id="inventory-locations">
                    <thead>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Cell') ?></th>
                            <th><?= __('Label') ?></th>
                            <th><?= __('Inventory Vial Id') ?></th>
                            <th><?= __('Vial Type') ?></th>
                        </tr>
                    </thead>
                    </table>
            <?php endif; ?>
            </div>
        </div>
      </div>
    </div>