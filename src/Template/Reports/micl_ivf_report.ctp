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
        'ivf_date',
        'fresh_frozen',
        'sperm_cryo_id',
        'eggs_info_donor_strain',
        'egg_yield',
        'ivf_method',
        'fert_rate',
        'icsi',
        'sperm_conc',
        'sperm_total_mot',
        'sperm_prog_mot',
        'sample_type',
        'cpa_lot_no',
        'ivf_icsi_by'
    ];
    iniDataTableServerSide('.data-table', columns, null, null, 'POST', {"iDisplayLength": 25});
});
</script>
<hr/>
<div class="jobs index large-9 medium-8 columns content horizontal-table">
    <h3>MICL IVF Report</h3>
    <table class="data-table table stripe order-column table-responsive">
        <thead>
            <tr>
                <th>Membership</th>
                <th>Job ID</th>
                <th>Strain Name</th>
                <th>MMRRC&nbsp;#</th>
                <th>ESC Clone ID</th>
                <th>IVF ID</th>
                <th>IVF Date</th>
                <th>Fresh/Frozen</th>
                <th>Sperm Cryo ID</th>
                <th>Egg Donor Strain</th>
                <th>Egg Yield</th>
                <th>IVF Method</th>
                <th>IVF Rate</th>
                <th>ICSI?</th>
                <th>Sperm Concentration</th>
                <th>Sperm Total Motility</th>
                <th>Sperm Progressive Motility</th>
                <th>Sperm Sample Type</th>
                <th>CPA Lot#</th>
                <th>IVF technician</th>
            </tr>
        </thead>
    </table>
    <hr/>
    <?= $this->CustomForm->displayAdvancedSearchInput(['id', 'job_id', 'ivf_date', 'background', 'purpose', 'membership', 'sperm_info_donor_strain', 'fresh_frozen', 'sample_type', 'sperm_cryo_id', 'straw_vial_no', 'cpa_lot_no', 'centrifuge_force', 'centrifuge_time', 'collect_thaw_time', 'time_in_mbcd', 'stud_id_no', 'stud_dob', 'abnormal_heads', 'abnormal_tails', 'cpa_fresh_sperm_conc', 'cpa_fresh_total_motility', 'cpa_fresh_rapid_motility', 'cpa_fresh_prog_motality', 'mbcd_sperm_conc', 'mbcd_total_motality', 'mbcd_rapid_motality', 'mbcd_prog_motality', 'sperm_analyzer', 'epi_storage_tank', 'epi_storage_rack', 'epi_storage_box', 'epi_storage_space', 'epi_storage_vial_id_no', 'epi_storage_code', 'male_genotype_confirmed', 'geno_date', 'genotyped_by', 'sperm_info_comments', 'eggs_info_donor_strain', 'eggs_info_genotype', 'eggs_info_donor_dob', 'eggs_info_donor_age', 'eggs_info_comments', 'females_ordered_no', 'females_out_no', 'unsuperovulated_no', 'pmsg_time', 'hcg_time', 'pmsg_hcg_by', 'icsi', 'ivf_method', 'laser_system', 'pulse_duration', 'laser_power', 'co_culture_hrs', 'incubator_id_no', 'ivf_note', 'two_cell_score_time', 'ivf_icsi_by', 'ivf_icsi_info_comment', 'egg_collection_time', 'icsi_end_time', 'eggs_injected_no', 'eggs_survived_no', 'survival_rate', 'more_icsi_info_comments', 'ivf_medium', 'ivf_medium_lot', 'ivf_medium_vendor', 'oil_vendor', 'oil_lot', 'user_id', 'created', 'modified', 'genotype', 'fmp_id_no', 'fmp_job_id_no', 'fmp_sc_id_no']); ?>
    </hr>
</div>

<style>
.data-table td {
    text-align:center !important;
}
</style>