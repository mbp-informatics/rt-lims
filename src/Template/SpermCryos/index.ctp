<script>
$(document).ready(function() {
    var selectorStr = '.data-table';
    var injectObj = [
        {
            'column':'actions', 
            'string': `
                "<span data-toggle='tooltip' title='View'><a href='/sperm-cryos/view/"+ row.id_action +"' class='label label-primary action-pad' target='_blank'><span class='pad-action-glyph glyphicon glyphicon-eye-open'></span></a></span>"+
                "<span data-toggle='tooltip' title='Edit'><a href='/sperm-cryos/edit/"+ row.id_action +"' class='label label-success action-pad' target='_blank'><span class='pad-action-glyph glyphicon glyphicon-pencil'></span></a></span>"
            `
        }
    ];
    var columns = ['id', 'job_id', 'strain_name', 'stock_number', 'donor_id_no', 'donor_genotype', 'donor_geno', 'cryo_sperm_conc', 'cryo_total_motility','cryo_rapid_motility', 'cryo_prog_motility', 'cryo_abnormal_heads', 'cryo_abnormal_tails', 'straw_count', 'cryo_date', 'actions'];
    iniDataTableServerSide(selectorStr, columns, injectObj, null, null, {"iDisplayLength": 25});
});//end document ready
</script>


<div class="pull-left">
    <?= $this->Html->link('<span class="glyphicon glyphicon-plus"></span> '.__('New Sperm Cryo'), ['action' => 'add'], array('escape' => false, 'class' => 'btn btn-warning pad-button')) ?>
</div>
<div class="clearfix"></div>
<hr/>
<div class="spermCryos index large-9 medium-8 columns content horizontal-table">
    <h3><?= __('Sperm Cryos') ?></h3>
    <table class="data-table table stripe order-column">
        <thead>
            <tr>
                <th>SC ID</th>
                <th>Job ID</th>
                <th>Strain Name</th>
                <th>Stock Number</th>
                <th>Donor ID</th>
                <th>Male Geno</th>
                <th>Geno Confirmed</th>
                <th>Conc</th>
                <th>Total Mot.</th>
                <th>Rapid Mot.</th>
                <th>Prog Mot.</th>
                <th>Abn Heads %</th>
                <th>Abn Tails %</th>
                <th>Inventory Count</th>
                <th>Cryo Date</th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
    </table>
    <hr/>
    <?= $this->CustomForm->displayAdvancedSearchInput($modelFields); ?>
    </hr>
</div>