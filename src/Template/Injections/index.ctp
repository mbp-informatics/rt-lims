<script>
$(document).ready(function() {

    var selectorStr = '.data-table';
    var injectObj = {
        'column':'actions', 
        'string': `
            '<span data-toggle="tooltip" title="Clone it! Will pull in Superovulation and Embryo Collection value."><a href="/injections/add?pull-from-injection='+ row.id +'" class="label label-primary action-pad"><span class="pad-action-glyph glyphicon glyphicon-open"></span></a></span>'+
            '<span data-toggle="tooltip" title="View"><a href="/injections/view/'+ row.id +'" class="label label-primary action-pad"><span class="pad-action-glyph glyphicon glyphicon-eye-open"></span></a></span>'+
            '<span data-toggle="tooltip" title="Edit"><a href="/injections/edit/'+ row.id +'" class="label label-success action-pad"><span class="pad-action-glyph glyphicon glyphicon-pencil"></span></a></span>'+
            '<span data-toggle="tooltip" title="Delete"><form id="'+row.id+'" style="display:none;" method="post" action="/injections/delete/'+ row.id +'"><input type="hidden" name="_method" value="POST"/></form><a href="#" class="label label-danger action-pad" onclick="if (confirm(&quot;Are you sure you want to delete:'+ row.id +'&quot;)) { $(&quot;#'+row.id+'&quot;).submit(); } event.returnValue = false; return false;"><span class="pad-action-glyph glyphicon glyphicon glyphicon-trash"></span> </a></span>'
        `
    };
    var columns = ['id', 'injection_date', 'project_name', 'qc_state', 'pts_ko_mo', 'cell_clone_line', 'injected_by', 'colonies', 'recharge', 'actions'];
    iniDataTableServerSide(selectorStr, columns, injectObj);
});//end document ready
</script>

<?= $this->Html->link('<span class="glyphicon glyphicon-plus"></span> '.__('New Microinjection'), ['action' => 'add'], array('escape' => false, 'class' => 'btn btn-warning pad-button'));  ?>
<?php if ($this->request->session()->read('Auth.User.role.name') == 'admin') { ?>
    <?= $this->Html->link('<span class="glyphicon glyphicon-pencil"></span> '.__('Projects-Injections Associations'), ['controller' => 'projects-injections'], array('escape' => false, 'class' => 'btn btn-default pad-button'));  ?>
<?php } ?>
<hr/>
<div class="injections index large-9 medium-8 columns content horizontal-table">
    <h3><?= __('Injections') ?></h3>
    <table class="data-table table stripe">
        <thead>
            <tr>
                <th>Inj ID</th>
                <th>Injection date</th>
                <th>Project Name</th>
                <th>QC State</th>
                <th>Order #</th>
                <th>Cell/Clone line</th>
                <th>Injected By</th>
                <th>Colony Id</th>                
                <th>Recharge</th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
    </table>
    <hr/>
    <?= $this->CustomForm->displayAdvancedSearchInput($modelFields); ?>
    </hr>
</div>
