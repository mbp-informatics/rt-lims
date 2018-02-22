<script>
$(document).ready(function() {
    var selectorStr = '.data-table';
    var injectObj = [
        {
            'column':'actions', 
            'string': `
                "<script>iniDialog('#add-new-status"+row.id+"', '/genes-statuses/add/"+row.mgi_accession_id+"', '', null, 600, 560, 'mgi-genes-dump');<\/script>"+
                "<div id='dialog-add-new-status"+row.id+"' title='Add status to a gene'></div>"+
                "<div id='add-new-status"+row.id+"'><span style='cursor:pointer;' data-toggle='tooltip' title='Add status to that gene'><span class='label label-success action-pad'><span class='pad-action-glyph glyphicon glyphicon-plus'></span> Add status</span></span></div>"+
                "<a href='/genes-statuses/index/"+row.mgi_accession_id+"'><span style='cursor:pointer;' data-toggle='tooltip' title='View Gene Statuses'><span class='label label-primary action-pad'><span class='pad-action-glyph glyphicon glyphicon-eye-open'></span> View statuses</span></span></a>"
            `
        },
        {
            'column':'mgi_accession_id', 
            'string': `
                "<a href='/MgiGenesDump/view/"+row.mgi_accession_id+"'>"+row.mgi_accession_id+"</a>"
            `
        }
    ];
    var columns = ['actions', 'id', 'mgi_accession_id', 'marker_symbol', 'marker_synonyms', 'chr', 'cm_position', 'genome_coord_start', 'genome_coord_end', 'strand', 'status', 'marker_name', 'marker_type', 'feature_type'];
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
<div class="mgiGenesDump index large-9 medium-8 columns content horizontal-table table-responsive">
    <h3><?= __('Mgi Genes Dump') ?></h3>
    <table class=" data-table table stripe order-column">
        <thead>
            <tr>
                <th class="actions"><?= __('Actions') ?></th>
                <th>id</th>
                <th>mgi_accession_id</th>
                <th>marker_symbol</th>
                <th>marker_synonyms</th>
                <th>chr</th>
                <th>cm_position</th>
                <th>genome_coord_start</th>
                <th>genome_coord_end</th>
                <th>strand</th>
                <th>status</th>
                <th>marker_name</th>
                <th>marker_type</th>
                <th>feature_type</th>
            </tr>
        </thead>
    </table>
</div>