<script>
$(document).ready(function() {
    var selectorStr = '.data-table';
    var injectObj = [
        {
            'column':'actions', 
            'string': `
                "<span data-toggle='tooltip' title='View'><a href='/ivfs/view/"+ row.id_action +"' class='label label-primary action-pad' target='_blank'><span class='pad-action-glyph glyphicon glyphicon-eye-open'></span></a></span>"+
                "<span data-toggle='tooltip' title='Edit'><a href='/ivfs/edit/"+ row.id_action +"' class='label label-success action-pad' target='_blank'><span class='pad-action-glyph glyphicon glyphicon-pencil'></span></a></span>"
            `
        }
    ];
    var columns = ['id', 'strain_name', 'stock_number', 'sperm_info_donor_strain', 'sperm_cryo_id', 'average_eggs', 'fert_rate', 'membership', 'icsi', 'ivf_date', 'actions'];
    iniDataTableServerSide(selectorStr, columns, injectObj, null, null, {"iDisplayLength": 25});
});//end document ready
</script>

<?= $this->Html->link('<span class="glyphicon glyphicon-plus"></span> '.__('New IVF'), ['action' => 'add'], array('escape' => false, 'class' => 'btn btn-warning pad-button')) ?>
<?= $this->Html->link('<span class="glyphicon glyphicon-list-alt"></span> ' .__('List IVF Dishes'), ['controller' => 'IvfDishes', 'action' => 'index'], array('escape' => false, 'class' => 'btn btn-warning pad-button')) ?>
<hr/>
<div class="ivfs index large-9 medium-8 columns content horizontal-table">
    <h3><?= __('IVFs') ?></h3>
    <table class="data-table table stripe order-column">
        <thead>
            <tr>
                <th>IVF ID</th>
                <th>Strain Name</th>
                <th>Stock Number</th>
                <th>Egg Donor Strain</th>
                <th>SC#</th>
                <th>Egg Yield/Donor</th>
                <th>Fert rate</th>
                <th>Membership</th>
                <th>ICSI?</th>
                <th>IVF Date</th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
    </table>
    <hr/>
    <?= $this->CustomForm->displayAdvancedSearchInput($modelFields); ?>
    </hr>
</div>
