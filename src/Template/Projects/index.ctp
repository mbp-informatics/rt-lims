<script>
$(document).ready(function() {
    var selectorStr = '.data-table';
    var injectObj = [
        {'column':'project_type_id', 'string':`row.project_type.type`},
        {'column':'project_status_id', 'string':`row.project_status.status`},
        {'column':'mutation_id', 'string':`row.mutation.type`},
        {
        'column':'actions', 
        'string': `
            '<span data-toggle="tooltip" title="View"><a href="/projects/view/'+ row.id +'" class="label label-primary action-pad"><span class="pad-action-glyph glyphicon glyphicon-eye-open"></span></a></span>'+
            '<span data-toggle="tooltip" title="Edit"><a href="/projects/edit/'+ row.id +'" class="label label-success action-pad"><span class="pad-action-glyph glyphicon glyphicon-pencil"></span></a></span>'+
            '<span data-toggle="tooltip" title="Delete"><form id="'+row.id+'" style="display:none;" method="post" action="/projects/delete/'+ row.id +'"><input type="hidden" name="_method" value="POST"/></form><a href="#" class="label label-danger action-pad" onclick="if (confirm(&quot;Are you sure you want to delete:'+ row.id +'&quot;)) { $(&quot;#'+row.id+'&quot;).submit(); } event.returnValue = false; return false;"><span class="pad-action-glyph glyphicon glyphicon glyphicon-trash"></span> </a></span>'
        `
        }
    ];
    var columns = ['id', 'project_name', 'colony_name', 'mgi_genes_dump', 'project_type_id', 'project_status_id', 'mutation_id', 'created', 'actions'];
    iniDataTableServerSide(selectorStr, columns, injectObj, null, 'POST');
});//end document ready
</script>

<?php if ($this->request->session()->read('Auth.User.role.name') == 'admin') { ?>
    <div class="pull-left">
    <?= $this->Html->link('<span class="glyphicon glyphicon-pencil"></span> '.__('Projects-Genes'), ['controller' => 'projects-genes'], array('escape' => false, 'class' => 'btn btn-default pad-button'));  ?>
        <?= $this->Html->link('<span class="glyphicon glyphicon-pencil"></span> '.__('Projects-Milestones'), ['controller' => 'project-milestones'], array('escape' => false, 'class' => 'btn btn-default pad-button'));  ?>
        <?= $this->Html->link('<span class="glyphicon glyphicon-pencil"></span> '.__('Project Types'), ['controller' => 'project-types'], array('escape' => false, 'class' => 'btn btn-default pad-button'));  ?>
        <?= $this->Html->link('<span class="glyphicon glyphicon-pencil"></span> '.__('Project Statuses'), ['controller' => 'project-statuses'], array('escape' => false, 'class' => 'btn btn-default pad-button'));  ?>
        <?= $this->Html->link('<span class="glyphicon glyphicon-pencil"></span> '.__('Mutations'), ['controller' => 'mutations'], array('escape' => false, 'class' => 'btn btn-default pad-button'));  ?>
        <?= $this->Html->link('<span class="glyphicon glyphicon-pencil"></span> '.__('Phenotypes'), ['controller' => 'phenotypes'], array('escape' => false, 'class' => 'btn btn-default pad-button'));  ?>
    </div>
    <div style="clear:both;"></div>
<?php } ?>

<?= $this->Html->link('<span class="glyphicon glyphicon-plus"></span> '.__('New Project'), ['action' => 'add'], array('escape' => false, 'class' => 'btn btn-warning pad-button'));  ?>
<?php if ($this->request->session()->read('Auth.User.role.name') == 'admin') { ?>
    <?= $this->Html->link('<span class="glyphicon glyphicon-floppy-open"></span> '.__('Bulk Projects upload (from file)'), ['action' => 'bulk-upload'], array('escape' => false, 'class' => 'btn btn-danger pad-button'));  ?>
<?php } ?>
<hr/>
<div class="projects index large-9 medium-8 columns content horizontal-table">
    <h3><?= __('Projects') ?></h3>
    <table class="data-table table stripe order-column data-table">
        <thead>
            <tr>
                <th>id</th>
                <th>Project name</th>
                <th>Colony name</th>
                <th>Mgi accession id</th>
                <th>Project type</th>
                <th>Project status</th>
                <th>Mutation id</th>
                <th>Created</th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
    </table>
</div>
