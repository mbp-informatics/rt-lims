<script>
$(document).ready(function() {

    var selectorStr = '.data-table';
    var injectObj = {
        'column':'actions', 
        'string': `
            '<span data-toggle="tooltip" title="View"><a href="/inventory-vials/view/'+ row.id +'" class="label label-primary action-pad"><span class="pad-action-glyph glyphicon glyphicon-eye-open"></span></a></span>'+
            '<span data-toggle="tooltip" title="Edit"><a href="/inventory-vials/edit/'+ row.id +'" class="label label-success action-pad"><span class="pad-action-glyph glyphicon glyphicon-pencil"></span></a></span>'+
            '<span data-toggle="tooltip" title="Delete"><form id="'+row.id+'" style="display:none;" method="post" action="/inventory-vials/delete/'+ row.id +'"><input type="hidden" name="_method" value="POST"/></form><a href="#" class="label label-danger action-pad" onclick="if (confirm(&quot;Are you sure you want to delete:'+ row.id +'&quot;)) { $(&quot;#'+row.id+'&quot;).submit(); } event.returnValue = false; return false;"><span class="pad-action-glyph glyphicon glyphicon glyphicon-trash"></span> </a></span>'
        `
    };
    var columns = ['id', 'label', 'volume', 'ec_sc', 'inventory_vial_type', 'tissue', 'created', 'actions'];
    iniDataTableServerSide(selectorStr, columns, injectObj);
});//end document ready
</script>
<hr/>
<div class="inventoryVials index large-9 medium-8 columns content">
    <h3><?= __('Inventory Vials') ?></h3>
    <table class="data-table table stripe order-column">
        <thead>
            <tr>
                <th>ID</th>
                <th>Label</th>
                <th>Volume</th>
                <th>Embryo/Sperm</th>
                <th>Type</th>
                <th>Tissue?</th>
                <th>Created</th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
    </table>
    <hr/>
    <?= $this->CustomForm->displayAdvancedSearchInput($modelFields); ?>
    </hr>
</div>
