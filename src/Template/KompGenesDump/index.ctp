<script>
$(document).ready(function() {
    var selectorStr = '.data-table';
    var injectObj = [
        {
            'column':'actions', 
            'string': `
                "<a href='/komp-genes-dump/view/view/"+row.ID+"'><span style='cursor:pointer;' data-toggle='tooltip' title='View'><span class='label label-primary action-pad'><span class='pad-action-glyph glyphicon glyphicon-eye-open'></span> View</span></span></a>"
            `
        },
        {
            'column':'MGI_Number', 
            'string': `
                "<a href='mgi-genes-dump/view/"+row.MGI_Number+"'>"+row.MGI_Number+"</a>"
            `
        }
    ];
    var columns = ['actions', 'created', 'ID', 'MGI_Number', 'Chr', 'cM', 'Symbol', 'Status', 'Name', 'MGI_type', 'available', 'ensembl', 'vega', 'Regeneron', 'CSD', 'EUCOMM', 'IGTC', 'Targeted', 'Other_Mutants', 'Sanger', 'komptarget', 'kompgenesversion', 'start', 'end', 'strand', 'IMSR', 'vectorAvailable', 'miceAvailable', 'NorCOMM', 'TIGM', 'spermAvailable', 'embryoAvailable', 'MGIupdate', 'comment', 'GXD', 'synonym_of', 'hasBeenOrdered'];
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
    <div class="kompGenesDump index large-9 medium-8 columns content">
    <div style="float:left">
        <h3><?= __('Komp Genes Dump') ?></h3>
    </div>
    <div class="clearfix"></div>
    <div class="table-responsive horizontal-table">
        <table class="data-table table table-striped">
        <thead>
            <tr>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
                <th class="highlight">Dump created</th>
                <th>ID</th>
                <th>MGI_Number</th>
                <th>Chr</th>
                <th>cM</th>
                <th>Symbol</th>
                <th>Status</th>
                <th>Name</th>
                <th>MGI_type</th>
                <th>available</th>
                <th>ensembl</th>
                <th>vega</th>
                <th>Regeneron</th>
                <th>CSD</th>
                <th>EUCOMM</th>
                <th>IGTC</th>
                <th>Targeted</th>
                <th>Other_Mutants</th>
                <th>Sanger</th>
                <th>komptarget</th>
                <th>kompgenesversion</th>
                <th>start</th>
                <th>end</th>
                <th>strand</th>
                <th>IMSR</th>
                <th>vectorAvailable</th>
                <th>miceAvailable</th>
                <th>NorCOMM</th>
                <th>TIGM</th>
                <th>spermAvailable</th>
                <th>embryoAvailable</th>
                <th>MGIupdate</th>
                <th>comment</th>
                <th>GXD</th>
                <th>synonym_of</th>
                <th>hasBeenOrdered</th>
            </tr>
        </thead>
    </table>
    </div>
</div>
