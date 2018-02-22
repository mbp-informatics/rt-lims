
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.2.0/min/dropzone.min.css" type="text/css" />
<style>
    .dropzone {
        border: 2px dashed #0087F7;
        border-radius: 5px;
        background: white;
    }
    #info-box {
        padding: 15px;
        margin-bottom: 20px;
        border: 1px solid transparent;
        border-top-color: transparent;
        border-right-color: transparent;
        border-bottom-color: transparent;
        border-left-color: transparent;
        border-radius: 4px;
        color: #3c763d;
        background-color: #dff0d8;
        border-color: #d6e9c6;
    }
</style>
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.2.0/min/dropzone.min.js"></script>

<div class="crisprDesigns form large-9 medium-8 columns content">
    <fieldset>
        <legend><span class="glyphicon glyphicon-floppy-open"></span> <?= __('Bulk CRISPR Design Upload') ?></legend>
        <p style="text-align:right"><small><a style="text-decoration:underline;" href="/crispr-designs/add">Click here to upload a single CRISPR Design.</a></small></p>
        <div id="info-box">
            <p>
                <strong>Please note that the script halts on ANY error. Do make sure that:</strong>
                <ul>
                    <li>Your XLS file is in the <strong>correct format</strong>. Here you'll find a sample input file: <strong><a href="/uploads/crispr-design-bulk-upload/bulk_upload_example_input.xlsx">bulk_upload_example_input.xlsx</a></strong>.</li>
                    <li>The <strong>gene names are correct</strong> and can be mapped to their corresponding MGI Accession Ids.</li>
                    <li>The input XLS file is <strong>smaller than 100 rows</strong>.</li>
                </ul>
                <br/>
                <ul>
                    <li><strong><span style="color:red">Note 1:</span></strong> For each design uploaded, a <strong>KOMP2 project</strong> will be automatically created in RT-LIMS with <strong>'Designed' status</strong> set.</li>
                    <li><strong><span style="color:red">Note 2:</span></strong> The script uses Sanger API to look up <strong>CRISPR from 20bp gRNA sequences</strong> provided in the XLS sheet.</li>
                    <li><strong><span style="color:red">Note 3:</span></strong> Be patient and do not reload the page - uploading 100 rows will take <strong>about 25 minutes</strong>.</li>
                </ul>
            </p>
        </div>
          <div id="progress-candy" class="hidden"> Processing. Please wait patiently. (For reference: uploading 100 rows will take about 25 minutes)
            <div class="progress">
              <div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuenow="100" style="width: 100%">
              </div>
            </div>
          </div>
    </fieldset>
    <div id="flash-alerts"></div>
    <form action="/crispr-designs/parse-bulk-upload/" class="dropzone" id="crispr-dropzone"></form>
</div>
<script>
    Dropzone.options.crisprDropzone = {
        paramName: "file", // The name that will be used to transfer the file
        maxFilesize: 15, // MB
        accept: function(file, done) {
            var extension = file.name.substring(file.name.lastIndexOf('.')+1).toLowerCase();
            if($.inArray(extension,["xlsx","csv","tsv"]) !== -1){ //if not a spreadsheet
                done();
            $("#progress-candy").removeClass("hidden");
            }
            else{
                var originalFile = file.name;
                originalFile = originalFile.substring(0, originalFile.lastIndexOf("_"));
                alert(originalFile + "is not a valid spreadsheet. Check if it's an excel file, csv, or tsv.");
                this.removeFile(file);
            }
        },
        success: function(file, response){
        $("#progress-candy").addClass("hidden");
            var response = JSON.parse(response);
            if(response["errors"]){
                //if even one error, remove file?
                this.removeFile(file);
                for(var i=0;i<response["errors"].length;i++){
                    //hack to replicate $this->Flash in cake's controller
                    var error = '<div class="alert alert-danger">'+
                                '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'+
                                response["errors"][i]+
                                '</div>';
                    $("#flash-alerts").append(error);
                }
            }
            else {
                window.location = "/crispr-designs/?bulk_upload=success";
            }
        },
        error: function(file, response){
        $("#progress-candy").addClass("hidden");
            if (response.message) {
                var err = response.message;
            } else {
                var err = 'Unknown error. Aborting.'
            }
            var error = '<div class="alert alert-danger">'+
                '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'+
                err+'</div>';
            $("#flash-alerts").append(error);
        }
    };
</script>