<?php

    $header = isset($injection_requests) ? 'Injection Requests' : 'Jobs';
    $buttonTxt = isset($injection_requests) ? 'New Injection  Request' : 'New Job';
    $action = isset($injection_requests) ? 'add_injection' : 'add';

?>
<script>
$(document).ready(function() {

    var selectorStr = '.data-table';
    var injectObj = [
        {
            'column':'actions', 
            'string': `
                "<span data-toggle='tooltip' title='View'><a href='/jobs/view/"+ row.id_action +"' class='label label-primary action-pad' target='_blank'><span class='pad-action-glyph glyphicon glyphicon-eye-open'></span></a></span>"+
                "<span data-toggle='tooltip' title='Edit'><a href='/jobs/edit/"+ row.id_action +"' class='label label-success action-pad' target='_blank'><span class='pad-action-glyph glyphicon glyphicon-pencil'></span></a></span>"
            `
        }
    ];
    var columns = ['id', 'strain_name', 'mmrrc_no', 'esc_clone_id_no', 'membership', 'request_date', 'job_status', 'job_statusb', 'sc_count', 'ec_count',  'actions'];
    iniDataTableServerSide(selectorStr, columns, injectObj, null, null, {"iDisplayLength": 25});
});//end document ready
</script>

<?= $this->Html->link('<span class="glyphicon glyphicon-plus"></span> '.__($buttonTxt), ['action' => $action], array('escape' => false, 'class' => 'btn btn-warning pad-button')) ?>
<hr/>
<div class="jobs index large-9 medium-8 columns content horizontal-table">
    <h3><?= __($header) ?></h3>
    <table class="data-table table stripe order-column table-responsive">
        <thead>
            <tr>
                <th>Job ID</th>
                <th>Strain name</th>
                <th>MMRRC Stock#</th>
                <th>Clone ID</th>
                <th>Membership</th>
                <th>Request date</th>
                <th>Job Status 1</th>
                <th>Job Status 2</th>
                <th>SC Inv</th>
                <th>EC Inv</th>
                <!-- <th>Inj req</th> -->
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
    </table>
    <hr/>
    <?= $this->CustomForm->displayAdvancedSearchInput($modelFields); ?>
    </hr>
</div>
