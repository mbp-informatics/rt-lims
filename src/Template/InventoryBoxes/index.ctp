<script>
$(document).ready(function() {
    var selectorStr = '.data-table';
    var injectObj = {
        'column':'actions', 
        'string': `
            '<span data-toggle="tooltip" title="View"><a href="/inventory-boxes/view/'+ row.id +'" class="label label-primary action-pad"><span class="pad-action-glyph glyphicon glyphicon-eye-open"></span></a></span>'+
            '<span data-toggle="tooltip" title="Edit"><a href="/inventory-boxes/edit/'+ row.id +'" class="label label-success action-pad"><span class="pad-action-glyph glyphicon glyphicon-pencil"></span></a></span>'+
            '<span data-toggle="tooltip" title="Delete"><form id="'+row.id+'" style="display:none;" method="post" action="/inventory-boxes/delete/'+ row.id +'"><input type="hidden" name="_method" value="POST"/></form><a href="#" class="label label-danger action-pad" onclick="if (confirm(&quot;Are you sure you want to delete:'+ row.id +'&quot;)) { $(&quot;#'+row.id+'&quot;).submit(); } event.returnValue = false; return false;"><span class="pad-action-glyph glyphicon glyphicon glyphicon-trash"></span> </a></span>'
        `
    };
    var columns = ['id', 'name', 'inventory_container_id',  'box_type', 'inventory_locations', 'created','modified', 'actions'];
    iniDataTableServerSide(selectorStr, columns, injectObj);
});//end document ready
</script>
<hr/>
    <?= $this->Html->link('<span class="glyphicon glyphicon-plus"></span> '.__('New Inventory Box'), ['action' => 'add'], array('escape' => false, 'class' => 'btn btn-warning pad-button')) ?>
<hr/>
<div class="inventoryBoxes index large-9 medium-8 columns content">
    <h3><?= __('Inventory Boxes') ?></h3>
    <table class="data-table table stripe order-column">
        <thead>
            <tr class="info">
                <th>Id</th>
                <th>Name</th>
                <th>Container ID</th>
                <th>Box Type ID</th>
                <th>Empty cells (available/total)</th>
                <th>Created</th>
                <th>Modified</th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
    </table>
    <hr/>
    <?= $this->CustomForm->displayAdvancedSearchInput($modelFields); ?>
    </hr>
</div>
