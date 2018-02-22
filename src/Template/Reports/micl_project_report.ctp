<script>
$(document).ready(function() {
    var selectorStr = '.data-table';
    var columns = ['request_date', 'membership', 'job_types', 'id', 'order_no', 'strain_name', 'genotype', 'background', 'mosaic_id_no', 'mmrrc_no', 'esc_clone_id_no','sc_count', 'ec_count', 'job_astatus', 'job_bstatus'];
    iniDataTableServerSide('.data-table', columns, null, null, null, {"iDisplayLength": 25});
});
</script>
<hr/>
<div class="jobs index large-9 medium-8 columns content horizontal-table">
    <h3>MICL Project Report</h3>
    <table class="data-table table stripe order-column table-responsive">
        <thead>
            <tr>
                <th>Request Date</th>
                <th>Membership</th>
                <th>Job Type</th>
                <th>Job ID</th>
                <th>Order&nbsp;#</th>
                <th>Strain&nbsp;Name</th>
                <th>Genotype</th>
                <th>Background</th>
                <th>Mosaic ID</th>
                <th>MMRRC&nbsp;#</th>
                <th>ESC Clone ID</th>
                <th>Total Current Sperm  Inventory</th>
                <th>Total Current Embryo Inventory</th>
                <th>Job&nbsp;Status&nbsp;1</th>
                <th>Job&nbsp;Status&nbsp;2</th>
            </tr>
        </thead>
    </table>
    <hr/>
    <?= $this->CustomForm->displayAdvancedSearchInput(['id', 'request_date', 'membership', 'order_no', 'strain_name', 'genotype', 'background', 'mosaic_id_no', 'mmrrc_no', 'esc_clone_id_no', 'job_astatus_id', 'job_bstatus_id']); ?>
    </hr>
</div>

<style>
.data-table td {
    text-align:center !important;
}
</style>