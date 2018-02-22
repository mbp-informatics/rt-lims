<script>
$(document).ready(function() {
    var selectorStr = '.data-table';
    var injectObj = {
        'column':'actions', 
        'string': `
            '<span data-toggle="tooltip" title="View"><a href="/inventory-shipped-vials/view/'+ row.id +'" class="label label-primary action-pad"><span class="pad-action-glyph glyphicon glyphicon-eye-open"></span></a></span>'+
            '<span data-toggle="tooltip" title="Edit"><a href="/inventory-shipped-vials/edit/'+ row.id +'" class="label label-success action-pad"><span class="pad-action-glyph glyphicon glyphicon-pencil"></span></a></span>'+
            '<span data-toggle="tooltip" title="Delete"><form id="'+row.id+'" style="display:none;" method="post" action="/inventory-shipped-vials/delete/'+ row.id +'"><input type="hidden" name="_method" value="POST"/></form><a href="#" class="label label-danger action-pad" onclick="if (confirm(&quot;Are you sure you want to delete:'+ row.id +'&quot;)) { $(&quot;#'+row.id+'&quot;).submit(); } event.returnValue = false; return false;"><span class="pad-action-glyph glyphicon glyphicon glyphicon-trash"></span> </a></span>'
        `
    };
    var columns = ['id', 'label', 'volume', 'comments', 'original_vial_id_no', 'original_location_id_no', 'actions'];
    iniDataTableServerSide(selectorStr, columns, injectObj);
});//end document ready
</script>

<div class="inventoryShippedVials index large-9 medium-8 columns content horizontal-table">
    <h3><?= __('Inventory Shipped Vials') ?></h3>
    <hr/>
    <table class="data-table table stripe order-column">
        <thead>
            <tr>
                <th>id</th>
                <th>label</th>
                <th>volume</th>
                <th>comments</th>
                <th>tissue</th>
                <th>original_vial_id_no</th>
                <th class="actions">Actions</th>
            </tr>
        </thead>
    </table>
    <hr/>
    <?= $this->CustomForm->displayAdvancedSearchInput($modelFields); ?>
    </hr>
</div>
