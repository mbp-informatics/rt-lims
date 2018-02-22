<script>
$(document).ready(function() {
    $('#ajax-loader').show();
    var middlewareHost = window.DEBUG ? 'https://api-ns-staging.mousebiology.org' : 'https://api-ns.mousebiology.org'
    $.get( middlewareHost+'/get-gene-name-changes', function( data ) {
        var dataSet = [];
        var data = JSON.parse(data)
        data.forEach(function(el) {
            row = [];
            $.each(el, function(k, v){
                if (k == 'mgi_accession_id') {
                    v = '<a href="/mgi-genes-dump/view/'+v+'">'+v+'</a>';
                }
                row.push(v);
            });
            dataSet.push(row);
        });
        $('#gene-changes-table').dataTable({
            'data': dataSet,
            'scrollX':true,
            "autoWidth": true,
            "order": [[ 0, "desc" ]]
        });
        $('#ajax-loader').hide();
    });
});
</script>
<div class="alert alert-success">
Note: This logging mechanism was initiated in August 2017.<br/> Marker symbol changes that occurred earlier are not shown here.<br/>Changes detection is based on <em><a href="http://www.informatics.jax.org/downloads/reports/index.html">Mouse Genetic Markers List 2</a></em> provided by JAX. 
</div>
<div class="mgiGenesDump index large-9 medium-8 columns content horizontal-table table-responsive">
    <h3><?= __('Gene Name Changes') ?></h3>
    <table id='gene-changes-table' class="table stripe order-column">
        <thead>
            <tr class="info">
                <th>Change Id</th>
                <th>MGI Accession Id</th>
                <th>New marker symbol</th>
                <th>Old marker symbol</th>
                <th>New synonyms</th>
                <th>Old synonyms</th>
                <th>Status</th>
                <th>Date logged</th>
            </tr>
        </thead>
    </table>
</div>