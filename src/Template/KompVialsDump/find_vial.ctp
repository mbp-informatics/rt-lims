<?php
/**
  * @var \App\View\AppView $this
  */
?>

<script>
$( document ).ready(function() {
    $.getScript('/js/find-komp-vial.js', function(){
        /** 
         * Populate the table when submit button is clicked,
         * Insert non-empty values into DOM    
         */
        $('#submit-komp-vial-button').click(function(event) {
            event.preventDefault();
            var vialId = $( "#dialog-associate-komp-vial" ).data('kompVial-id');
            tableSelector = '#kompVials';
            idPrefix = 'kompVial-';
            tdClass = 'kompVials';
            dialogId = 'dialog-associate-komp-vial'
            if (selectedKompVialId) {
                populateRow(dialogId, tableSelector, idPrefix, tdClass, selectedKompVialId, selectedKompVialId, [selectedKompClone, selectedMgi, selectedKompOrderId], [null, null, 'kompOrders']);
            }
        });
    });



}); 
</script>
<style>
.grayOut {
    color:#999;
}
.white {
    background-color:white;
    padding:15px 15px 65px 15px;
    margin-top:30px;
}

.badge-enabled {
    background-color:green;
}

</style>

<div class="kompVialsDump view large-9 medium-8 columns content">
    <div class="white">
        <label class="control-label" for="genes"><span id="b-1" class="badge badge-enabled">1</span> Gene</label>
        <select id="genes" class="form-control"></select>
        <br/>
        <label class="control-label" for="clones"><span id="b-2" class="badge">2</span> Clone</label>
        <select id="clones" class="form-control grayOut" disabled>
            <option>Select a Gene first</option>
        </select>
        <br/>
        <label class="control-label" for="vials"><span id="b-3" class="badge">3</span> Komp Vial Id</label>
        <select id="vials" class="form-control grayOut" disabled>
            <option>Select a Clone first</option>
        </select>
        <br/>
        <label class="control-label" for="orders"><span id="b-4" class="badge">4</span> Komp Order Id</label>
        <select id="orders" class="form-control grayOut" disabled>
            <option>Select a Vial first</option>
        </select>
        <hr/>
    <?= $this->Form->button(__('Associate this vial'),
        array(
            'class' => 'btn btn-success',
            'div' => false,
            'id' => 'submit-komp-vial-button',
            'style' => "display:none"
            ));
    ?>
    </div>
</div>
