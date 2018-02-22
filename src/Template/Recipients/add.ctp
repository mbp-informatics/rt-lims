<style>
.xbuttons { 
    padding:0px;
    margin-top:-45px;
    margin-right:-25px;
}
.panel-default {
    background-color:#f5f5f5;
    box-shadow: 0px 10px 10px #cbbb;
    margin-top:35px;
}
.hidden-recs {
    /*display:2;*/
    display:none;
}

</style>
<script>
$( document ).ready(function() {
    var nextRecToShowId = 0;
    var recCounter = 0;
    var allDropdowns;
    addRecs('first'); //Add the first rec on page load

    $.ajaxSetup({
       async: false
    });

    /** FUNCTIONS FOLLOW */

    /* Populates the fields with values grabbed from the previous vial (var prevRecId) */
    function populateRec(recIdToPopulate, prevRecId) {


        /* SELECTIZE JS DROPDOWNS */
        //DOB
        var dob = $('#'+prevRecId+'-dob').val();
        $('#'+recIdToPopulate+'-dob').val(dob);

        //ANESTHETIC VOL TYPE
        var parentDropdown = $('#'+recIdToPopulate+'-anesthetic-vol-type');
        var dropdownValues = [];
        parentDropdown.find('option').remove();
        $('#'+prevRecId+'-anesthetic-vol-type option').each(function() {
            parentDropdown.append('<option value="' + $(this).val() + '">' + $(this).text() + '</option>');
            dropdownValues.push($(this).val());
        });
        var prevValue = $('#'+prevRecId+'-anesthetic-vol-type').val();
        if (prevValue) {
            $('#'+recIdToPopulate+'-anesthetic-vol-type').val(prevValue).change();
        }

        //EMBRYO STAGE
        var parentDropdown = $('#'+recIdToPopulate+'-embryo-stage');
        var dropdownValues = [];
        parentDropdown.find('option').remove();
        $('#'+prevRecId+'-embryo-stage option').each(function() {
            parentDropdown.append('<option value="' + $(this).val() + '">' + $(this).text() + '</option>');
            dropdownValues.push($(this).val());
        });
        var prevValue = $('#'+prevRecId+'-embryo-stage').val();
        if (prevValue) {
            $('#'+recIdToPopulate+'-embryo-stage').val(prevValue).change();
        }
    }

    /* Moves recipient from hidden recs into the form and increments the counter */
    function addRecs(first=false){
        if (first) {
            var noRecsToAdd = 1;
        } else {
            var noRecsToAdd = $('#addRecsNo').val();
        }
        for (i=0; i<noRecsToAdd; i++) {
            if ($('.visible-recs:last').length >0) {
                var prevRecId  = $('.visible-recs:last').attr('id').replace('recipient', '')
            } else {
                var prevRecId = 0;
            }
            var rec = $('#recipient'+nextRecToShowId).addClass('visible-recs');
            $("#buttonsFollow").before(rec);
            if (nextRecToShowId != 0) { //don't call the function when adding the first rec to the view
                populateRec(nextRecToShowId, prevRecId); 
            }
            nextRecToShowId++;
            recCounter++;
        }    
    }


    /* Removes a recipient identified by its id from DOM */
    function removeRec(recId){
        $('#recipient'+recId).fadeOut(400, function(){
            $(this).remove();
            recCounter--;
        });
    }

    /** EVENTS FOLLOW */

    //Add new vials on button click
    $(document).on('click', "#addRecs", function() {
        addRecs();
    });

    //Remove vial when X is clicked
    $(document).on('click', ".xbuttons", function() {
        removeRec($(this).attr('id'));
    });

});

function calcTx(i) {
    if ($('#'+ i + '-tx-l').val() && $('#'+ i + '-tx-r').val()) {
        var l = parseFloat($('#'+ i + '-tx-l').val() );
        var r = parseFloat($('#'+ i + '-tx-r').val() );
        var Total = parseFloat( l+r );
        $('#'+ i + '-total-tx').val(Total);
    } else if ($('#'+ i + '-tx-l').val()) {
        var l = parseFloat($('#'+ i + '-tx-l').val() );
        $('#'+ i + '-total-tx').val(l);
    } else if ($('#'+ i + '-tx-r').val()) {
        var r = parseFloat($('#'+ i + '-tx-r').val() );
        $('#'+ i + '-total-tx').val(r);
    }
};

function roundWeight(value) {
    var re = /\d+.\d+/;
    var weight = String(value);
    console.log(weight);
    if (re.test(weight)) {
        var weightArray = weight.split(".");
        var decimal = weightArray[1];
        if (decimal > 5) {
            var newValue = parseInt(weightArray[0]);
            var newWeight = newValue + 1;
            return newWeight;
        } else {
            return weightArray[0];
        }
    } else {
        return weight;
    }
};

function calcAnesthetic(i) {
    // Validation rule
    var dec = /[0-9]+.[0-9]+/;
    var noDec = /[0-9]+/;
    // Check input
    if (dec.test(document.getElementById(i + '-weight').value) || noDec.test(document.getElementById(i + '-weight').value)){
        // document.getElementById('hidden_msg').innerHTML="";
        if (document.getElementById(i + '-weight').value) {
            var weight = parseFloat(document.getElementById(i + '-weight').value);
            if (weight) {
                var roundedWeight = roundWeight(weight);
                var Total = parseFloat( roundedWeight/100 );
                $('#'+ i + '-anesthetic-vol').val(Total);
            }
        document.getElementById('hidden_msg').innerHTML="";
        } 
        // return true;
    } else {
        document.getElementById(i + '-weight').value = '';
        lightUp($('#'+ i + '-weight'));
        document.getElementById('hidden_msg').innerHTML="Weight must only contain numbers or decimal points";
        return false; 
    }

};

</script>

<div class="recipients form large-9 medium-8 columns content" style="margin-top:30px;">
    <legend><?= __('Add Recipients') ?></legend>
    <p><span class="important"><span class="glyphicon glyphicon-warning-sign"></span> You are adding recipients to Embryo Transfer# <?= $etId ?>.</span></p>
    <div id="recipients">
    <?= $this->Form->create($recipient, ['id' => 'recipientsForm', 'onsubmit' => "return confirm('Are you sure you want to submit ' + recCounter + ' recipient(s)?');"]) ?>
    <hr id ="buttonsFollow">
    Add <input id="addRecsNo" type="text" value="1" style="width:30px;"> more recipients <button id="addRecs" type="button" class="btn btn-warning"><span class="glyphicon glyphicon-plus"></span></button>
    <?= $this->Form->button(__('Submit All Recipients'),
        array(
            'class' => 'btn btn-success',
            'div' => false,
            'confirm' => 'Are you sure you want to submit recipients?'
            )); ?>
    <?= $this->Form->end() ?>
    <div id="hidden_msg"></div>
</div>
<div class="hidden-recs">
    <?php
    /** 
     * Inserts a preset number of rec modules into a hidden container
     * These recs are then moved into the <form> when the 'Add Recipient Button'
     * is clicked. Tomek, 10/6/2016
     */
    $i=0; for ($i; $i < 10; $i++)  { ?>

    <div class="panel panel-default" id='recipient<?= $i ?>'>
        <div class='panel-body'>
            <div class="pull-right">
                <button id='<?= $i ?>' type="button" class="xbuttons btn btn-danger btn-sm"><span class="pad-action-glyph glyphicon glyphicon-remove"></span></button>
            </div>
            <fieldset>
                <?php $esOptions = ['2-Cell' => '2-Cell', 'Zygote' => 'Zygote', '8-cell/Early Morula' => '8-cell/Early Morula', 'Mor/Early Blast 2.5' => 'Mor/Early Blast 2.5', 'Blast 3.5' => 'Blast 3.5']; ?>
                <?php $etOptions = ['DLY' => 'DLY', 'KMJ' => 'KMJ', 'JZ' => 'JZ', 'LNB' => 'LNB', 'NLA' => 'NLA', 'PTD' => 'PTD', 'VLG' => 'VLG', 'KLW' => 'KLW']; ?>
                <div class='row'>
                    <div class='col-sm-3'><?php echo $this->Form->input($i.'.ear_mark', ['required' => 'required']); ?></div>
                    <div class='col-sm-3'><?php echo $this->Form->input($i.'.weight', ['label' => 'Weight (g)', 'onblur'=>'calcAnesthetic('.$i.')', 'type'=>'decimal']); ?></div>
                    <div class='col-sm-3'><?php echo $this->Form->input($i.'.embryo_stage', ['options' => $esOptions, 'label'=>'Embryo Stage', 'empty'=>true, 'default'=>'2-Cell']); ?></div>
                </div>
                <div class='row'>
                    <?php $typeOptions = ['mL' => 'mL', '%' => '%']; ?>  
                    <div class='col-sm-3'><?php echo $this->Form->input($i.'.anesthetic_vol', ['label' => 'Anesthetic Volume']); ?></div>
                    <div class='col-sm-1'><?php echo $this->Form->input($i.'.anesthetic_vol_type', ['label' => '', 'options' => $typeOptions]); ?></div>
                    <div class='col-sm-1'></div>
                    <div class='col-sm-3'><?php echo $this->Form->input($i.'.analgesic_vol', ['default' => '0.1', 'label' => 'Analgesic Volume (mL)']); ?></div>
                    <div class='col-sm-1'><?php echo $this->Form->input($i.'.cl', ['type'=>'checkbox', 'label'=>'Cl', 'checked'=>'true']); ?></div>
                    <div class='col-sm-1'><?php echo $this->Form->input($i.'.amp', ['type'=>'checkbox', 'label'=>'Amp', 'checked'=>'true']); ?></div>
                </div>
                <div class='row'>
                    <div class='col-sm-3'><?php echo $this->Form->input($i.'.tx_l', ['onblur'=>'calcTx('.$i.')', 'type'=>'number']); ?></div>
                    <div class='col-sm-3'><?php echo $this->Form->input($i.'.tx_r', ['onblur'=>'calcTx('.$i.')', 'type'=>'number']); ?></div>
                    <div class='col-sm-3'><?php echo $this->Form->input($i.'.total_tx', ['readonly'=>true]); ?></div>
                    <div class='col-sm-3'><?php echo $this->Form->input($i.'.et_by', ['options' => $etOptions, 'label'=>'ET By', 'empty'=>true]); ?></div>
                </div>
                <div class='row'>
                    <div class='col-sm-12'><?php echo $this->Form->input($i.'.comments', [ 'type' => 'text']); ?></div>
                </div>  
            </fieldset>
        </div>
    </div>
    <?php } ?>
</div>

