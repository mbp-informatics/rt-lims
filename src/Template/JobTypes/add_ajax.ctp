<script>
/** Add another dropdown when a value from the previous dropdown 
 *  has been selected. That way you can add unlimieted number of job types
 *  at one go. Tomek, 10/25/2016
 */
$( document ).ready( function() {
var i = 0;

// Remove event handlers, otherwise they're going to duplicate and "bubble" resulting in unexpected behavior.
$('#submit-job-type-button').off('click');
$(document).off('focus');
$(document).off('change');

//Initiate datepickers for the two initial date fields
$( '#0-scheduled-date1' ).datepicker({ dateFormat: 'yy-mm-dd' });
$( '#0-scheduled-date2' ).datepicker({ dateFormat: 'yy-mm-dd' });

$(document).on('focus ', '.job-names', function(){
    prevVal = this.value;
    i++;
    }).on('change', '.job-names', function(){
        //debugger;
        if ( prevVal == '') {
            //Define counters
            jobTypeId = $(this).attr('id');
            currentCounter = parseInt(jobTypeId.replace('-job-type-name-id', ''));
            nextCounter = currentCounter + 1;

            //Clone objects and update their id's and other attributes
            jobTypeClone = $(this).clone();
            jobTypeClone.attr('id', nextCounter+'-job-type-name-id');
            sdate1Clone = $('#'+ currentCounter +'-scheduled-date1').clone();
            sdate1Clone.attr('id', nextCounter+'-scheduled-date1').attr('name', null).removeClass('hasDatepicker');
            sdate2Clone = $('#'+ currentCounter +'-scheduled-date2').clone();
            sdate2Clone.attr('id', nextCounter+'-scheduled-date2').attr('name', null).removeClass('hasDatepicker');

            //Prepare a row and insert it into DOM
            $( "#job-type-fieldset" ).append( `
                    <div class='row' id="`+nextCounter+`-all-input-fields">
                        <div class='col-sm-4'id="`+nextCounter+`-job-type-field"></div>
                        <div class='col-sm-4'id="`+nextCounter+`-date1-field"></div>
                        <div class='col-sm-4'id="`+nextCounter+`-date2-field"></div>
                    </div>
                `);

            //Insert new fields into previously prepared row
            $('#'+nextCounter+'-job-type-field').append(jobTypeClone);
            $('#'+nextCounter+'-date1-field').append(sdate1Clone);
            $('#'+nextCounter+'-date2-field').append(sdate2Clone);

            //Initialize Datepickers
            $( '#'+nextCounter+'-scheduled-date1' ).datepicker({ dateFormat: 'yy-mm-dd' });
            $( '#'+nextCounter+'-scheduled-date2' ).datepicker({ dateFormat: 'yy-mm-dd' });
        } //end if prevVal ==''

        //Delete a row when a user selects empty job type from dropdown
        if ($(this).val() == '') {
            thisRowId = $(this)[0].id.replace('-job-type-name-id', '');
            $('#'+thisRowId+'-all-input-fields').remove();
        }
        prevVal = $(this).val();
    });

    //Populate the table when submit button is clicked    
    $('#submit-job-type-button').click(function(event) {
        event.preventDefault();
        tableSelector = '#jobTypes';
        idPrefix = 'jobType-';
        tdClass = 'jobTypes';
        dialogId = 'dialog-add-job-type';
        //Insert non-empty values into DOM
        $('.job-names').each(function(){
            if ($(this).val() !== '' ) {
                id = $(this)[0].id;
                counter = parseInt(id.replace('-job-type-name-id', ''));
                dateFields = [$( '#'+counter+'-scheduled-date1' ).val(), $( '#'+counter+'-scheduled-date2' ).val()];
                populateRow(dialogId, tableSelector, idPrefix, tdClass, $(this).find(":selected").text(), $(this).find(":selected").val(), dateFields );
            }
        });
        if (typeof startConfirmExit == 'function') { startConfirmExit(); }
    });
});
</script>
<style>
.row {
    margin-bottom:15px !important;
}
</style>
<div class="jobTypes form large-9 medium-8 columns content">
    <?= $this->Form->create($jobType, ['id' => 'add-job-type-form']) ?>
    <div style="border-bottom:1px solid #aaa; margin-bottom:15px;">
    <fieldset id='job-type-fieldset'>
    <div class='row' id="0-all-input-fields">
        <div class='col-sm-4'>
        <?php
            echo $this->Form->input('job_type_name_id', ['options' => $jobTypeNames, 'required' => true, 'empty' => true, 'class' => 'job-names', 'id' => '0-job-type-name-id', 'label' => 'Select job type']);
        ?>
        </div>
        <div class='col-sm-4'>
        <?php echo $this->CustomForm->displayDatepickerField('scheduled_date1', ['empty'=>true, 'id' => '0-scheduled-date1' ]); ?>
        </div>
        <div class='col-sm-4'>
        <?php echo $this->CustomForm->displayDatepickerField('scheduled_date2', ['empty'=>true, 'id' => '0-scheduled-date2']); ?>
        </div>
    </div>
    </fieldset>
    </div>
    <?= $this->Form->button(__('Add'),
        array(
            'class' => 'btn btn-success',
            'div' => false,
            'id' => 'submit-job-type-button'
            ));
    ?>
    <?= $this->Form->end() ?>
</div>