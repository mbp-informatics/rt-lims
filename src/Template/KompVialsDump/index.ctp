<script>
$(document).ready(function() {
    var selectorStr = '.data-table';
    var injectObj = [
        {
            'column':'actions', 
            'string': `
                "<a href='/komp-vials-dump/view/"+row.komp_vial_id+"'><span style='cursor:pointer;' data-toggle='tooltip' title='View'><span class='label label-primary action-pad'><span class='pad-action-glyph glyphicon glyphicon-eye-open'></span> View</span></span></a>"
            `
        },
        {
            'column':'mgi_accession_id', 
            'string': `
                "<a href='/MgiGenesDump/view/"+row.mgi_accession_id+"'>"+row.mgi_accession_id+"</a>"
            `
        }
    ];
    var columns = ['actions', 'id', 'gene', 'komp_gene_id', 'clone_name', 'clone_nickname', 'mouse_clone_id', 'mutation', 'mutation_id_no', 'cell_line', 'mgi_accession_id', 'epd', 'komp_vial_id', 'created'];
    iniDataTableServerSide(selectorStr, columns, injectObj, null, 'POST');
});//end document ready
</script>
<?php
/**
  * @var \App\View\AppView $this
  */
?>
<div class="kompProjectsDump index large-9 medium-8 columns content table-responsive">
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
    <h3><?= __('Komp Vials Dump') ?></h3>
    <div class="table-responsive">
        <table class="table data-table table-striped">
            <thead>
                <tr>
                    <th scope="col" class="actions"><?= __('Actions') ?></th>
                    <th scope="col">id</th>
                    <th scope="col">gene</th>
                    <th scope="col">komp_gene_id</th>
                    <th scope="col">clone_name</th>
                    <th scope="col">clone_nickname</th>
                    <th scope="col">mouse_clone_id</th>
                    <th scope="col">mutation</th>
                    <th scope="col">mutation_id_no</th>
                    <th scope="col">cell_line</th>
                    <th scope="col">mgi_number</th>
                    <th scope="col">epd</th>
                    <th scope="col">komp_vial_id</th>
                    <th class="highlight" scope="col">dump created</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
