<script>
$(document).ready(function() {
    var selectorStr = '.data-table';
    var columns = [
        'membership',
        'job_id',
        'strain_name',
        'mmrrc_no',
        'esc_clone_id_no',
        'id',
        'et_date',
        'et_location',
        'fresh_frozen',
        'total_embryos_tx',
        'total_pups_born',
        'litter_rate',
        'total_male_pups',
        'total_mut_males',
        'total_mut_females',
        'no_recipients',
        'litter_rate',
        'icsi_embryos',
        'et_by',
        'et_lab'
    ];
    iniDataTableServerSide('.data-table', columns, null, null, 'POST', {"iDisplayLength": 25});
});
</script>
<hr/>
<div class="jobs index large-9 medium-8 columns content horizontal-table">
    <h3>MICL Embryo Transfer (ET) Report</h3>
    <table class="data-table table stripe order-column table-responsive">
        <thead>
            <tr>
                <th>Membership</th>
                <th>Job ID</th>
                <th>Strain Name</th>
                <th>MMRRC&nbsp;#</th>
                <th>ESC Clone ID</th>
                <th>ET#</th>
                <th>ET Date</th>
                <th>ET Location</th>
                <th>Fresh/Frozen</th>
                <th>ET Total embryos Tx'd</th>
                <th>ET Total Pups Born</th>
                <th>Pup rate</th>
                <th>ET total male pups</th>
                <th>ET total mut male pups</th>
                <th>ET total mut female pups</th>
                <th>ET Total Recipients Used</th>
                <th>ET Litter Rate</th>
                <th>ICSI Embryos?</th>
                <th>ET Technician</th>
                <th>ET Lab</th>
            </tr>
        </thead>
    </table>
    <hr/>
    <?= $this->CustomForm->displayAdvancedSearchInput(['id', 'job_id', 'embryo_resus_id', 'ivf_id', 'mmrrc_no', 'bl_no', 'pn_cr_no', 'membership', 'pts_ko_mo_no', 'crispr', 'strain_name', 'et_purpose', 'investigator', 'lab_contact', 'background', 'komp_clone', 'et_date', 'et_lab', 'et_time', 'expected_dob', 'et_by', 'et_location', 'fresh_frozen', 'icsi_embryos', 'assisted_ivf_embryos', 'save_pups', 'send_tails_to', 'embryo_cryo_id', 'recipient_strain', 'anesthetic', 'anesthetic_lot_no', 'analgesic', 'analgesic_lot_no', 'comments', 'maternity_updated_by', 'pup_genotype_updated_by', 'total_embryos_tx', 'total_pups_born', 'et_birth_rate', 'total_male_pups', 'total_female_pups', 'total_mut_males', 'total_mut_females', 'et_total_mut_mice', 'no_recipients', 'no_litters', 'litter_rate', 'search', 'primary_recharge', 'secondary_recharge', 'test_et_birth_rate', 'no_total_chimeras', 'no_total_male_chimeras', 'no_total_female_chimeras', 'chimeras_greater_than_fifty', 'chimera_bl_no', 'chimera_pn_no', 'chimera_crispr', 'created', 'modified', 'user_id', 'analgesic_dose', 'anesthetic_dose', 'analgesic_method', 'anesthetic_method', 'injection_id', 'pups', 'straw_label', 'fmp_id_no', 'fmp_job_id_no', 'fmp_ivf_id_no', 'fmp_rs_id_no', 'embryo_transfer_day', 'protocol']); ?>
    </hr>
</div>

<style>
.data-table td {
    text-align:center !important;
}
</style>