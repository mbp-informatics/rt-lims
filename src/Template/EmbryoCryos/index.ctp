<script>
$(document).ready(function() {
    var selectorStr = '.data-table';
    var injectObj = [
        {
            'column':'actions', 
            'string': `
                "<span data-toggle='tooltip' title='View'><a href='/embryo-cryos/view/"+ row.id_action +"' class='label label-primary action-pad' target='_blank'><span class='pad-action-glyph glyphicon glyphicon-eye-open'></span></a></span>"+
                "<span data-toggle='tooltip' title='Edit'><a href='/embryo-cryos/edit/"+ row.id_action +"' class='label label-success action-pad' target='_blank'><span class='pad-action-glyph glyphicon glyphicon-pencil'></span></a></span>"
            `
        }
    ];
    var columns = ['id', 'job_id', 'stud_strain', 'stock_number','male_genotype', 'genotype_confirmed', 'female_strain_name', 'blast_rate', 'vial_count', 'cryo_date', 'actions'];
    iniDataTableServerSide(selectorStr, columns, injectObj, null, null, {"iDisplayLength": 25});
});//end document ready
</script>

<?= $this->Html->link('<span class="glyphicon glyphicon-plus"></span> '.__('New Embryo Cryo'), ['action' => 'add'], array('escape' => false, 'class' => 'btn btn-warning pad-button')) ?>
<hr/>
<div class="embryoCryos index large-9 medium-8 columns content horizontal-table">
    <h3><?= __('Embryo Cryos') ?></h3>
    <table class="data-table table stripe order-column">
        <thead>
            <tr>
                <th>EC ID</th>
                <th>Job ID</th>
                <th>Strain Name</th>
                <th>Stock Number</th>
                <th>Male Genotype</th>
                <th>Geno Confirmed</th>
                <th>Female Strain Name</th>
                <th>Blast Rate</th>
                <th>Embryo Inventory</th>
                <th>Cryo Date</th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
    </table>
    <hr/>
    <?= $this->CustomForm->displayAdvancedSearchInput($modelFields); ?>
    </hr>
</div>
