<script>
$(document).ready(function() {
    var selectorStr = '.data-table';
    var injectObj = {
        'column':'actions', 
        'string': `
            '<span data-toggle="tooltip" title="View MICL"><a href="/embryo-transfers/view/'+ row.id_action +'" class="label label-primary action-pad" target="_blank"><span class="pad-action-glyph glyphicon glyphicon-eye-open"></span></a></span>'+
            '<span data-toggle="tooltip" title="View MTGL"><a href="/embryo-transfers/view/'+ row.id_action + '/mtgl" class="label label-primary action-pad"  target="_blank"><span class="pad-action-glyph glyphicon glyphicon-globe"></span></a></span>'+
           '<span data-toggle="tooltip" title="Edit"><a href="/embryo-transfers/edit/'+ row.id_action +'" class="label label-success action-pad"  target="_blank"><span class="pad-action-glyph glyphicon glyphicon-pencil"></span></a></span>'
        `
    };
    var columns = ['id', 'job_id', 'colonies', 'strain_name', 'stock_number', 'total_embryos_tx', 'ivf_id', 'pups_equation', 'litterrate', 'birth_rate', 'et_date', 'actions'];
    iniDataTableServerSide(selectorStr, columns, injectObj, null, null, {"iDisplayLength": 25});
});//end document ready
</script>

<?= $this->Html->link('<span class="glyphicon glyphicon-plus"></span> '.__('New Embryo Transfer'), ['action' => 'add'], array('escape' => false, 'class' => 'btn btn-warning pad-button')) ?>
<?= $this->Html->link('<span class="glyphicon glyphicon-list-alt"></span> ' .__('List Recipients'), ['controller' => 'Recipients', 'action' => 'index'], array('escape' => false, 'class' => 'btn btn-warning pad-button')) ?>
<hr/>
<div class="embryoTransfers index large-9 medium-8 columns content horizontal-table">
    <h3><?= __('Embryo Transfers') ?></h3>

    <table class="data-table table stripe">
        <thead>
            <tr>
                <th>ET ID</th>
                <th>Job ID</th>
                <th>Colony</th>
                <th>Strain Name</th>
                <th>Stock Number</th>
                <th>Tx'd</th>
                <th>IVF ID</th>                
                <th>Mut Pups/# Pups</th>
                <th>Litter Rate</th>  
                <th>Pup Rate</th>                
                <th>ET Date</th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
    </table>
    <hr/>
    <?= $this->CustomForm->displayAdvancedSearchInput($modelFields); ?>
    </hr>
</div>
