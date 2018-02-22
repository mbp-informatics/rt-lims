<script>
$(document).ready(function() {
    var selectorStr = '.data-table';
    var injectObj = [
        {
            'column':'actions', 
            'string': `
                "<a href='/komp-clones-dump/view/"+row.id+"'><span style='cursor:pointer;' data-toggle='tooltip' title='View'><span class='label label-primary action-pad'><span class='pad-action-glyph glyphicon glyphicon-eye-open'></span> View</span></span></a>"
            `
        },
        {
            'column':'gene_id', 
            'string': `
                "<a href='komp-genes-dump/view/"+row.gene_id+"'>"+row.gene_id+"</a>"
            `
        }
    ];
    var columns = ['actions', 'id', 'created', 'modified', 'user_id', 'gene_id', 'clone_number', 'receiving', 'fp_plate', 'fp_well', 'epd', 'epd_pass', 'epd_pass_score', 'epd_distribute', 'mutation_type', 'mutation_id_no', 'pg', 'pgs_plate', 'pgs_well', 'pgs_well_id_no', 'pgs_pass', 'pgs_pass_score', 'pgs_distribute', 'pc', 'pcs_plate', 'pcs_well', 'pcs_pass', 'pcs_pass_score', 'pcs_distribute', 'dp', 'design_id_no', 'design_instance_id_no', 'project_id_no', 'cassette', 'backbone', 'cell_line', 'passage', 'design', 'available', 'qc_result', 'sanger_project', 'facility', 'maid', 'mice_available', 'sperm_available', 'sperm_recovery_available', 'embryo_available', 'embryo_recovery_available', 'pass5arm', 'passloxp', 'pass3arm', 'mice_rederivation_available', 'mice_toronto_available', 'mice_available_conventional', 'mice_status_update_date', 'cryo_status_update_date', 'is_mouse_clone', 'is_crispr', 'mutation'];
    iniDataTableServerSide(selectorStr, columns, injectObj, null, 'POST');
});//end document ready
</script>

<div class="alert alert-success">
    <script src="/webroot/js/komp-dump.js"></script> 
    <div id="super-spinner" style="display:none; float:right; border-left: 2px solid brown; padding-left:15px; color:brown; margin-top:5px;">
        <div style="width:250px;float:left;">
            <em>This table is now being refreshed!</em> 
            <small>Job started: <span id="job-date"></span></small>
        </div>
    <img style="width:50px; margin-left:15px;" class="super-spinner" src="/img/balls.gif">
    </div>
Note: All <em>*_dump_*</em> tables are automatically populated by a CRON job calling API-NS system.<br/>
This is just a view - it will get overwritten every time the CRON jon is run.<br/>
More info in the wiki.
</div>
<hr/>
    <div class="kompClonesDump index large-9 medium-8 columns content">
    <div style="float:left">
        <h3><?= __('Komp Clones Dump') ?></h3>
    </div>
    <div class="clearfix"></div>
    <div class="table-responsive horizontal-table">
        <table class="data-table table table-striped">
            <thead>
                <tr>
                    <th class="actions"><?= __('Actions') ?></th>
                    <th>id</th>
                    <th class="highlight">dump created</th>
                    <th>modified</th>
                    <th>user_id</th>
                    <th>gene_id</th>
                    <th>clone_number</th>
                    <th>receiving</th>
                    <th>fp_plate</th>
                    <th>fp_well</th>
                    <th>epd</th>
                    <th>epd_pass</th>
                    <th>epd_pass_score</th>
                    <th>epd_distribute</th>
                    <th>mutation_type</th>
                    <th>mutation_id_no</th>
                    <th>pg</th>
                    <th>pgs_plate</th>
                    <th>pgs_well</th>
                    <th>pgs_well_id_no</th>
                    <th>pgs_pass</th>
                    <th>pgs_pass_score</th>
                    <th>pgs_distribute</th>
                    <th>pc</th>
                    <th>pcs_plate</th>
                    <th>pcs_well</th>
                    <th>pcs_pass</th>
                    <th>pcs_pass_score</th>
                    <th>pcs_distribute</th>
                    <th>dp</th>
                    <th>design_id_no</th>
                    <th>design_instance_id_no</th>
                    <th>project_id_no</th>
                    <th>cassette</th>
                    <th>backbone</th>
                    <th>cell_line</th>
                    <th>passage</th>
                    <th>design</th>
                    <th>available</th>
                    <th>qc_result</th>
                    <th>sanger_project</th>
                    <th>facility</th>
                    <th>maid</th>
                    <th>mice_available</th>
                    <th>sperm_available</th>
                    <th>sperm_recovery_available</th>
                    <th>embryo_available</th>
                    <th>embryo_recovery_available</th>
                    <th>pass5arm</th>
                    <th>passloxp</th>
                    <th>pass3arm</th>
                    <th>mice_rederivation_available</th>
                    <th>mice_toronto_available</th>
                    <th>mice_available_conventional</th>
                    <th>mice_status_update_date</th>
                    <th>cryo_status_update_date</th>
                    <th>is_mouse_clone</th>
                    <th>is_crispr</th>
                    <th>mutation</th>
                </tr>
        </thead>
        </tbody>
</table>
    </div>
</div>
