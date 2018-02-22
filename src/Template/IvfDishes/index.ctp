<script>
$(document).ready(function() {
    var selectorStr = '.data-table';
    var injectObj = [
        {
            'column':'actions', 
            'string': `
                '<span data-toggle="tooltip" title="View"><a href="/ivf-dishes/view/'+ row.id +'" class="label label-primary action-pad"><span class="pad-action-glyph glyphicon glyphicon-eye-open"></span></a></span>'+
                '<span data-toggle="tooltip" title="Edit"><a href="/ivf-dishes/edit/'+ row.id +'" class="label label-success action-pad"><span class="pad-action-glyph glyphicon glyphicon-pencil"></span></a></span>'+
                '<span data-toggle="tooltip" title="Delete"><form id="'+row.id+'" style="display:none;" method="post" action="/ivf-dishes/delete/'+ row.id +'"><input type="hidden" name="_method" value="POST"/></form><a href="#" class="label label-danger action-pad" onclick="if (confirm(&quot;Are you sure you want to delete:'+ row.id +'&quot;)) { $(&quot;#'+row.id+'&quot;).submit(); } event.returnValue = false; return false;"><span class="pad-action-glyph glyphicon glyphicon glyphicon-trash"></span> </a></span>'                
            `
        }
    ];
    var columns = ['id', 'ivf_id', 'dish_no', 'clutches_no', 'cocs_in_dish_time', 'insemination_time', 'sperm_ul', 'actions'];
    iniDataTableServerSide(selectorStr, columns, injectObj, null, null);
});//end document ready
</script>
<hr/>
<?= $this->Html->link('<span class="glyphicon glyphicon-plus"></span> '.__('New Ivf Dish'), ['action' => 'add'], array('escape' => false, 'class' => 'btn btn-warning pad-button')) ?>
<?= $this->Html->link('<span class="glyphicon glyphicon-list-alt"></span> ' .__('List Ivfs'), ['controller' => 'Ivfs', 'action' => 'index'], array('escape' => false, 'class' => 'btn btn-warning pad-button')) ?>
<?= $this->Html->link('<span class="glyphicon glyphicon-plus"></span> '.__('New Ivf'), ['controller' => 'Ivfs', 'action' => 'add'], array('escape' => false, 'class' => 'btn btn-warning pad-button')) ?>
<hr/>
<div class="ivfDishes index large-9 medium-8 columns content">
    <h3><?= __('Ivf Dishes') ?></h3>
    <table class="data-table table stripe order-column">
        <thead>
            <tr>
                <th>id</th>
                <th>ivf_id</th>
                <th>dish_no</th>
                <th>clutches_no</th>
                <th>cocs_in_dish_time</th>
                <th>insemination_time</th>
                <th>sperm_ul</th>
                <th class="actions">Actions</th>
            </tr>
        </thead>
    </table>
    <hr/>
    <?= $this->CustomForm->displayAdvancedSearchInput($modelFields); ?>
    </hr>
</div>
