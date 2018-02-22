
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.2.0/min/dropzone.min.css" type="text/css" />
<style>
    .dropzone {
        border: 2px dashed #0087F7;
        border-radius: 5px;
        background: white;
    }
</style>
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.2.0/min/dropzone.min.js"></script>

<div class="Projects form large-9 medium-8 columns content">
    <fieldset>
        <legend><?= __('Bulk Upload Projects') ?></legend>
        <p><small><strong>Please note that the script halts on ANY error. Do make sure that:</strong>
        <ul>
         <li>your XLS file is in the <strong>correct format</strong>. Here you'll find an example file: <a href="/uploads/project-bulk-upload/bulk_upload_projects_example_input_files.xlsx">bulk_upload_example_input.xlsx</a>,</li>
         </ul>
         </small></p>
          <div id="progress-candy" class="hidden"> Processing. Please wait patiently!
            <div class="progress">
              <div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuenow="100" style="width: 100%">
                <span class="sr-only">40% Complete (success)</span>
              </div>
            </div>
          </div>
    </fieldset>
    <div id="flash-alerts"></div>
    <form action="/projects/parse-bulk-upload/" class="dropzone" id="crispr-dropzone"></form>
</div>
<script>
    Dropzone.options.crisprDropzone = {
        paramName: "file", // The name that will be used to transfer the file
        maxFilesize: 4, // MB
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
                    //hack to replicate $this-Flash in cake's controller
                    var error = '<div class="alert alert-danger">'+
                                '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'+
                                response["errors"][i]+
                                '</div>';
                    $("#flash-alerts").append(error);
                }
            }
            else{
                window.location = "/projects/?bulk_upload=success";
            }
        }
    };
</script>