<div class="inventoryBoxTypes view large-9 medium-8 columns content">
    <h3>Freezer Inventory Management</h3>
   <hr/>
   <p>This page allows you to <strong>view</strong> existing Freezer Inventory and <strong>configure</strong> Freezer containers and other options.</p><p>Add new Freezer Inventory via <a href="/sperm-cryos">Sperm Cryo</a> or <a href="Embryo Cryos">Embryo Cryo</a> paths. </p>
   <hr/>

   <?= $this->Html->link('<span class="glyphicon glyphicon-eye-open"></span> '.__('View Vials'), ['action' => 'index', 'controller' => 'InventoryVials'], array('escape' => false, 'class' => 'btn btn-success pad-button')) ?>

	<?= $this->Html->link('<span class="glyphicon glyphicon-eye-open"></span> '.__('View Shipped Vials'), ['action' => 'index', 'controller' => 'InventoryShippedVials'], array('escape' => false, 'class' => 'btn btn-success pad-button')) ?>
	
	<?= $this->Html->link('<span class="glyphicon glyphicon-eye-open"></span> '.__('View Containers'), ['action' => 'index', 'controller' => 'InventoryContainers'], array('escape' => false, 'class' => 'btn btn-success pad-button')) ?>

	<?= $this->Html->link('<span class="glyphicon glyphicon-eye-open"></span> '.__('View Boxes'), ['action' => 'index', 'controller' => 'InventoryBoxes'], array('escape' => false, 'class' => 'btn btn-success pad-button')) ?>

<hr/>
	
	<?= $this->Html->link('<span class="glyphicon glyphicon-pencil"></span> '.__('Set Up Vial Types'), ['action' => 'index', 'controller' => 'InventoryVialTypes'], array('escape' => false, 'class' => 'btn btn-warning pad-button')) ?>

	<?= $this->Html->link('<span class="glyphicon glyphicon-pencil"></span> '.__('Set Up Box Types'), ['action' => 'index', 'controller' => 'InventoryBoxTypes'], array('escape' => false, 'class' => 'btn btn-warning pad-button')) ?>
<hr/>
</div>
