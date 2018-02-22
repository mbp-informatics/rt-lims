<script>
$(document).ready(function() {
    var selectorStr = '.data-table';
    var injectObj = [
        {
            'column':'actions', 
            'string': `
                "<span data-toggle='tooltip' title='View'><a href='/embryo-resus/view/"+ row.id_action +"' class='label label-primary action-pad' target='_blank'><span class='pad-action-glyph glyphicon glyphicon-eye-open'></span></a></span>"+
                "<span data-toggle='tooltip' title='Edit'><a href='/embryo-resus/edit/"+ row.id_action +"' class='label label-success action-pad' target='_blank'><span class='pad-action-glyph glyphicon glyphicon-pencil'></span></a></span>"
            `
        }
    ];
    var columns = ['id', 'strain_name', 'stock_number', 'straw_no', 'embryo_cryo_id', 'embryos_no', 'recovered_no', 'intact_no','bad_lysed_no', 'thawing_date', 'actions'];
    iniDataTableServerSide(selectorStr, columns, injectObj, null, null, {"iDisplayLength": 25});
});//end document ready
</script>

<?= $this->Html->link('<span class="glyphicon glyphicon-plus"></span> '.__('New Embryo Resus'), ['action' => 'add'], array('escape' => false, 'class' => 'btn btn-warning pad-button')) ?>
<?= $this->Html->link('<span class="glyphicon glyphicon-list-alt"></span> ' .__('List Jobs'), ['controller' => 'Jobs', 'action' => 'index'], array('escape' => false, 'class' => 'btn btn-warning pad-button')) ?>
<?= $this->Html->link('<span class="glyphicon glyphicon-list-alt"></span> ' .__('List Embryo Cryos'), ['controller' => 'EmbryoCryos', 'action' => 'index'], array('escape' => false, 'class' => 'btn btn-warning pad-button')) ?>
<hr/>
<div class="embryoResus index large-9 medium-8 columns content horizontal-table">
    <h3><?= __('Embryo Resus') ?></h3>
    <table class="data-table table stripe order-column">
        <thead>
            <tr>
                <th>RS ID</th>
                <th>Strain Name</th>
                <th>Stock Number</th>
                <th>Straw/Vial</th>
                <th>EC#</th>
                <th># Embryos</th>
                <th># Recovered</th>
                <th># Intact</th>
                <th># Bad</th>
                <th>Thawing date</th>   
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
    </table>
    <hr/>
    <?= $this->CustomForm->displayAdvancedSearchInput($modelFields); ?>
    </hr>
</div>
