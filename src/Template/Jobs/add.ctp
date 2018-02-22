<?= $this->CustomForm->iniConfirmExit('#job-request-form') ?>
<script>
$( document ).ready(function() {

    /* Initiate jQuery UI dialogs/modals */
    iniDialog('#associate-contact', '/contacts-jobs/addAjax/');
    iniDialog('#add-contact', '/contacts/addAjax/');
    iniDialog('#add-job-type', '/job-types/addAjax/');
    iniDialog('#add-job-comment', '/job-comments/addAjax/');
    iniDialog('#associate-komp-vial', '/komp-vials-dump/find-vial/', null, null, null, 550);

    /* Some global vars, mkey? */
    $( "#dialog-add-job-comment" ).data('jobComment-id', 0);
    $( "#dialog-add-job-type" ).data('jobType-id', 0);
    $( "#dialog-associate-contact" ).data('jobContact-id', 0);
    $( "#dialog-associate-komp-vial" ).data('kompVial-id', 0);


    //Submit form on click handler
    $('#submit-job-form-button').click(function(e) {
        e.preventDefault();
        var form = $( '#job-request-form');

        //check if there's only 1 KOMP order id
        var kompOrderIdsArr = [];
        $('td.kompOrders').each(function(){
            kompOrderId = $(this)[0].innerText;
            if (kompOrderId != '') {
                kompOrderIdsArr.push(kompOrderId);
            }
        });
        //Remove dupes from array
        var uniqueKompOrderIdsArr = [];
        $.each(kompOrderIdsArr, function(i, el){
            if($.inArray(el, uniqueKompOrderIdsArr) === -1) uniqueKompOrderIdsArr.push(el);
        });
        kompOrderIdsArr = uniqueKompOrderIdsArr;

        if (kompOrderIdsArr.length > 1) {
            alert("You cannot associate a job with more than 1 KOMP order. Please review 'Job Source' and make sure all vials have the same order id (or none).")
            return;
        }

        //Extract Job Comments from the table
        var i = 0;
        $('td.jobComments').each(function(){
            val = $(this)[0].innerText;
            val = val.replaceAll("'", "&apos;");
            el = "<input class='hidden' type='text' name='jobComments["+ i +"]' value='" + val +"'>"
            form.append(el);
            i++;
        });
        
        //Extract Job Types and Scheduled Dates from the table
        var i = 0;
        $('table#jobTypes tr').each(function(){     //iterate over <tr>
            if (i==0) { i++; return true; }         //skip first row with headers ('return true;' is an equivalent of 'continue;' for .each()
            var ii = 0;
            $(this).find('td').each(function(){     //iterate over <td>
                val = $(this)[0].innerText;
                el = '';
                switch (ii) {
                    case 0: //field 1 jobTypes
                        val = $(this).data('key');
                        el = "<input class='hidden' type='text' name='jobTypes["+ i +"][jobType]' value='" + val +"'>";
                    break;
                    case 1: //field 2 scheduledDate1
                        el = "<input class='hidden' type='text' name='jobTypes["+ i +"][scheduledDate1]' value='" + val +"'>";
                    break;
                    case 2: //field 3 scheduledDate2
                        el = "<input class='hidden' type='text' name='jobTypes["+ i +"][scheduledDate2]' value='" + val +"'>"
                    break;
                    case 3: //skip field 4 (actions)
                    break;
                }
                ii++;
                form.append(el);
            });
            i++;
        });

        //Extract Job Contacts from the table
        var i = 0;
        $('td.jobContacts').each(function(){
            val = $(this)[0].innerText;
            el = "<input class='hidden' type='text' name='jobContacts["+ i +"]' value='" + val +"'>"
            form.append(el);
            i++;
        });

        //Extract KOMP Vials from the table
        var i = 0;
        $('td.kompVials').each(function(){
            val = $(this)[0].innerText;
            el = "<input class='hidden' type='text' name='kompVials["+ i +"]' value='" + val +"'>"
            form.append(el);
            i++;
        });
        var i = 0;
        $('td.kompOrders').each(function(){
            val = $(this)[0].innerText;
            el = "<input class='hidden' type='text' name='kompOrders["+ i +"]' value='" + val +"'>"
            form.append(el);
            i++;
        });
        form.submit();
    });



    //Delete event - what to do when delete button is clicked
    $(document).on('click ', '#jobContacts a, #jobTypes a, #jobComments a, #kompVials a', function(event){
        event.preventDefault();
        var rowId = $(this)[0].id;
        $("#"+rowId).fadeOut(300, function(){ $(this).remove();}); //remove the row from DOM     
    });

    //when job source == KOMP, show more fields to fill out
    $('#job-source').click(function(e){
        switch ($(this).val()) {
            case 'KOMP':
            $("#komp-source-extra-fields").show('slow');
            break;
            case '':
            case 'MMRRC':
            $('#kompVials td').remove();
            $("#komp-source-extra-fields").hide('slow');
            break;
        } 
    });


});   
</script>
<style>
.job-source {
    margin-bottom:20px;
    margin-top:25px
}
#komp-source-extra-fields {
    display:none;
}
</style>

<div class="jobs form large-9 medium-8 columns content">
    <div class='container-fluid' style="margin-bottom:20px;">
    <?= $this->Form->create($job, ['id'=>'job-request-form']) ?>
    <fieldset>
        <legend><?= __('Add New Job') ?></legend>
        <div class='alert alert-info' role='alert'>Job Status</div>
        <div class="important" style="margin-bottom:20px;">
            <div class='row'>
                <br/>
                <div class='col-xs-6'><?php echo $this->Form->input('job_astatus_id', [
                            'options' => $jobAstatuses,
                            'label' => 'Job Status 1',
                            'empty' => true
                            ]); ?></div>
                <div class='col-xs-6'><?php echo $this->Form->input('job_bstatus_id', [
                            'options' => $jobBstatuses,
                            'label' => 'Job Status 2',
                            'empty' => true
                            ]); ?></div>                            
            </div>
        </div>
<!--
        <div class="module related horizontal-table job-source">
            <div class='col-xs-4 '>
                <?php echo $this->Form->input('job_source', [
                    'options' => ['KOMP' => 'KOMP'],
                    // 'options' => ['KOMP' => 'KOMP', 'MMRRC' => 'MMRRC'],
                    'label' => 'Job Source',
                    'empty' => true
                ]); ?></div>

            <div id="komp-source-extra-fields">
                <div class='col-xs-4 '>
                    <div id="dialog-associate-komp-vial" title="Associate a KOMP vial"></div>
                    <br/><button id="associate-komp-vial" class="btn btn-warning pad-button pull-left"><span class="glyphicon glyphicon-zoom-in"></span> Associate a KOMP vial</button>   
                </div>
                <table class="table stripe order-column" id="kompVials">
                    <tr>
                        <th><?= __('KOMP vial ID') ?></th>
                        <th><?= __('KOMP Clone name') ?></th>
                        <th><?= __('MGI Accession Id') ?></th>
                        <th><?= __('KOMP Order Id') ?></th>
                        <th class="actions"><?= __('Actions') ?></th>
                    </tr>
                </table>
            </div>

            <div class="clearfix"></div>
        </div>
-->

        <div class='row'>
            <div class='col-xs-4'><?php echo $this->CustomForm->displayDatepickerField('request_date', ['empty'=>true, 'label'=>'Request Date (YYYY-MM-DD)']); ?></div>
            <div class='col-xs-4'><?php echo $this->CustomForm->displayDatepickerField('reopened_date', ['empty'=>true, 'label'=>'Reopened Date (YYYY-MM-DD)']); ?></div>
            <div class='col-xs-4'><?php echo $this->Form->input('mosaic_id_no',['label' => 'Closed Date', 'disabled' => true, 'placeholder' => 'Available only when editing job']);  ?></div>
        </div>
        <div class="row">
            <div class='col-xs-4'><?php echo $this->CustomForm->displayField(
                        'membership', 
                        $this->CustomForm->getMembershipList(),
                        true,
                        ['empty'=>true]
                    ); ?></div>
            <div class='col-xs-4'><?php echo $this->CustomForm->displayField(
                        'komp_source', 
                        $this->CustomForm->getKompSourceList(),
                        true,
                        ['empty'=>true]
                    ); ?></div>
            <div class='col-xs-4'><?php echo $this->Form->input('mosaic_id_no',['label' => 'Mosaic ID']);  ?></div>
        </div>
        <div class='row'>
            <div class='col-xs-4'><?php echo $this->CustomForm->displayField(
                    'mcrl_recharge', 
                    // $this->CustomForm->getPrevValuesList('mcrl_recharge'),
                    $this->CustomForm->getMcrlRechargeList(),
                    true,
                    ['empty'=>true, 'label' => 'MICL Recharge']
                ); ?></div>
            <div class='col-xs-4'><?php echo $this->CustomForm->displayField(
                    'mvp_recharge', 
                    // $this->CustomForm->getPrevValuesList('mvp_recharge'),
                    $this->CustomForm->getMvpRechargeList(),
                    true,
                    ['empty'=>true, 'label' => 'MVP Recharge']
                ); ?></div>
            <div class='col-xs-4'><?php echo $this->CustomForm->displayField(
                    'mgel_recharge', 
                    // $this->CustomForm->getPrevValuesList('mgel_recharge'),
                    $this->CustomForm->getMgelRechargeList(),
                    true,
                    ['empty'=>true, 'label' => 'MGEL Recharge']
                ); ?></div>
        </div>
        <div class='row'>
            <div class='col-xs-3'>
                <label class="control-label" for="billed">Will be Billed?</label>
                <div class="switch-toggle well">
                    <input id="billed-yes" name="billed" type="radio" value="1" checked>
                    <label class="pointer" for="billed-yes">Yes</label>
                    <input id="billed-no" name="billed" value="0" type="radio">
                    <label class="pointer" for="billed-no">No</label>
                    <a class="progress-bar"></a>
                </div>
            </div>
            <div class='col-xs-3'><?php echo $this->Form->input('order_no',['label' => 'Order #']); ?></div>
            <div class='col-xs-3'><?php echo $this->Form->input('billing_id_no',['label' => 'Billing ID']); ?></div>
            <div class='col-xs-3'><?php echo $this->Form->input('import_id_no',['label' => 'Import #']); ?></div>
        </div>

         <div id="contacts" class="module related horizontal-table" style="margin-bottom:20px; margin-top:25px">
            <h4><?= __('<span class="glyphicon glyphicon-user"></span> Job Contacts') ?></h4>
            <table class="table stripe order-column" id="jobContacts">
                <tr>
                    <th><?= __('Id') ?></th>
                    <th><?= __('Name') ?></th>
                    <th><?= __('Campus/Institution') ?></th>
                    <th><?= __('Contact Type') ?></th>
                    <th><?= __('Email') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </table>
            <div id="dialog-associate-contact" title="Associate a contact"></div>
            <button id="associate-contact" class="btn btn-warning pad-button pull-left"><span class="glyphicon glyphicon-user"></span> Associate a contact</button>   
            <div id="dialog-add-contact" title="Add a new contact"></div>
            <button id="add-contact" class="btn btn-default pad-button"><span class="glyphicon glyphicon-plus"></span> Add a new contact</button>   
        </div>

        <div class='alert alert-info' role='alert'>Job Request Details</div>
        <div class='row'>
            <div class='col-xs-12'><?php echo $this->Form->input('strain_name'); ?></div>
        </div>
        <div class='row'>
            <div class='col-xs-12'><?php echo $this->Form->input('strain_note'); ?></div>
        </div>
        <div class='row'>
            <div class='col-xs-12'><?php echo $this->Form->input('previous_name',['label' => 'Previous Strain Name']); ?></div>  
        </div>
        <div class='row'>
            <div class='col-xs-4'><?php echo $this->Form->input('mmrrc_no',['label' => 'MMRRC ID']); ?></div>
            <div class='col-xs-4'><?php echo $this->Form->input('bl_no',['label' => 'BL#']); ?></div>
            <div class='col-xs-4'><?php echo $this->Form->input('pn_cr_no',['label' => 'PN/CR#']); ?></div>                
        </div>
        <hr/>
        <div class='row'>
            <div class='col-xs-6'><?php echo $this->Form->input('esc_clone_id_no',['label' => 'ESC Clone ID']); ?></div>
            <div class='col-xs-6'><?php echo $this->Form->input('esc_line'); ?></div>
        </div>
        <div class='row'>
            <div class='col-xs-6'><?php echo $this->CustomForm->displayField(
                    'genotype', 
                    $this->CustomForm->getGenotypeList(),
                    true,
                    ['empty'=>true]
                ); ?></div>
            <div class='col-xs-6'>           
                <label class="control-label" for="sexlinked">Sexlinked?</label>
                <div class="switch-toggle well">                   
                    <input type="radio" name="sexlinked" value="No" id="sexlinked-no" checked>
                    <label class="pointer" for="sexlinked-no"> No</label>
                    <input type="radio" name="sexlinked" value="X-linked" id="sexlinked-x-linked"> 
                    <label class="pointer" for="sexlinked-x-linked">X-linked </label>
                    <input type="radio" name="sexlinked" value="Y-linked" id="sexlinked-y-linked">
                    <label class="pointer" for="sexlinked-y-linked">Y-linked   </label>
                    <a class="progress-bar"></a>
                </div>
            </div>
        </div>
        <hr/>
        <div class='row'>
            <div class='col-xs-3'><?php echo $this->CustomForm->displayField(
                    'background', 
                    $this->CustomForm->getBackgroundList(),
                    true,
                    ['empty'=>true]
                );   ?></div>  
            <div class='col-xs-3'><?php echo $this->CustomForm->displayField(
                    'egg_donors', 
                    $this->CustomForm->getDonorStrainList(),
                    true,
                    ['empty'=>true]
                ); ?></div>
            <div class='col-xs-3'><?php echo $this->CustomForm->displayField(
                    'et_location', 
                    ['M3' => 'M3', 'MBP' => 'MBP'],
                    true,
                    ['empty'=>true, 'label' => 'ET Location']
                ); ?></div>
            <div class='col-xs-3'><?php echo $this->Form->input('recipient_no',['label' => 'Recipient #']); ?></div>
        </div>
        <div class="row">
            <div class='col-xs-12'><?php echo $this->Form->input('method_note',['label' => 'Method or Note', 'type' => 'textarea']); ?></div>
        </div>

            <div class="module horizontal-table" id='requested-job-types'>
                <h4><?= __('<span class="glyphicon glyphicon-exclamation-sign"></span> Requested Job Types') ?></h4>        
                <table class="table stripe order-column" id="jobTypes">
                    <tr>
                        <th><?= __('Job Type Name') ?></th>
                        <th><?= __('Scheduled Date 1') ?></th>
                        <th><?= __('Scheduled Date 2') ?></th>
                        <th class="actions"><?= __('Actions') ?></th>
                    </tr>
                </table>
                <hr/>
                <div id="dialog-add-job-type" title="Add a job type"></div>
                <button id="add-job-type" class="btn btn-warning pad-button"><span class="glyphicon glyphicon-plus"></span> Add job type</button>   
            </div>

        <div class='alert alert-info' role='alert'>Animal Information</div>   
        <div class='row'>
            <div class='col-xs-4'><?php echo $this->CustomForm->displayField(
                    'housing', 
                    $this->CustomForm->getHousingLocationList(),
                    true,
                    ['empty'=>true, 'label'=>'Housing location']
                ); ?></div>
            <div class='col-xs-4'><?php echo $this->Form->input('chimeras'); ?></div>
            <div class='col-xs-4'><?php echo $this->CustomForm->displayField(
                    'chimera_fertility', 
                    $this->CustomForm->getChimeraFertilityList(),
                    true,
                    ['empty'=>true]
                ); ?></div>
        </div>
        <hr/>
        <div class='row'>
            <div class='col-xs-6'><?php echo $this->Form->input('males_no'); ?></div>
            <div class='col-xs-6'><?php echo $this->Form->input('males_id_dob',['label' => 'Males ID/DOB']); ?></div>
        </div>
        <div class='row'>
            <div class='col-xs-6'><?php echo $this->Form->input('females_no'); ?></div>
            <div class='col-xs-6'><?php echo $this->Form->input('females_id_dob',['label' => 'Females ID/DOB']); ?></div>
        </div>
        <div class='alert alert-info' role='alert'>Genotyping</div>      
        <div class='row'>
            <div class='col-xs-3'>
                <label class="control-label" for="donor_genotyping">Sperm Donor Genotyping? </label>
                <div class="switch-toggle well">
                    <input id="donor_genotyping-yes" name="donor_genotyping" type="radio" value="1">
                    <label class="pointer" for="donor_genotyping-yes">Yes</label>
                    <input id="donor_genotyping-no" name="donor_genotyping" value="0" type="radio" checked>
                    <label class="pointer" for="donor_genotyping-no">No</label>
                    <a class="progress-bar"></a>
                </div>
            </div>
            <div class='col-xs-3'>
                <label class="control-label" for="egg_donor_genotyping">Egg Donor Genotyping? </label>
                <div class="switch-toggle well">
                    <input id="egg_donor_genotyping-yes" name="egg_donor_genotyping" type="radio" value="1">
                    <label class="pointer" for="egg_donor_genotyping-yes">Yes</label>
                    <input id="egg_donor_genotyping-no" name="egg_donor_genotyping" value="0" type="radio" checked>
                    <label class="pointer" for="egg_donor_genotyping-no">No</label>
                    <a class="progress-bar"></a>
                </div>
            </div>            
            <div class='col-xs-3'>
                <label class="control-label" for="targeting_conf">Targeting confirmation? </label>
                <div class="switch-toggle well">
                    <input id="targeting-conf-yes" name="targeting_conf" type="radio" value="1">
                    <label class="pointer" for="targeting-conf-yes">Yes</label>
                    <input id="targeting-conf-no" name="targeting_conf" value="0" type="radio" checked>
                    <label class="pointer" for="targeting-conf-no">No</label>
                    <a class="progress-bar"></a>
                </div>
            </div>
            <div class='col-xs-3'>
                <label class="control-label" for="muga_sample">MUGA Sample Required? </label>
                <div class="switch-toggle well">
                    <input id="muga_sample-yes" name="muga_sample" type="radio" value="1"  >
                    <label class="pointer" for="muga_sample-yes">Yes</label>
                    <input id="muga_sample-no" name="muga_sample" value="0" type="radio" checked >
                    <label class="pointer" for="muga_sample-no">No</label>
                    <a class="progress-bar"></a>
                </div>
            </div>
            <div class='col-xs-3'><?php echo $this->CustomForm->displayField(
                    'where_geno', 
                    ['PI Lab' => 'PI Lab', 'MGEL' => 'MGEL', 'None' => 'None'],
                    true,
                    ['empty'=>true, 'label' => 'Genotyping of Derived Pups']
                ) ?></div>
        </div>
        <div class="row">
            <div class='col-xs-12'><?php echo $this->Form->input('mcrl_note',['label' => 'MCRL note', 'type' => 'textarea']); ?></div>
        </div>

        <?php
            echo $this->Form->hidden('user_id', [
                'options' => $users,
                'default' => $this->request->session()->read('Auth.User.id')
                ]);
            echo $this->Form->hidden('job_status', [
                'default' => 'New'
                ]);
        ?>
        
    <div class="related horizontal-table module" id='job-comments'>
        <h4><?= __('<span class="glyphicon glyphicon-comment"></span> Job Comments') ?></h4>
        <table class="table stripe order-column" id="jobComments">
            <tr>
                <th><?= __('Comment') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </table>
        <hr/>
        <div id="dialog-add-job-comment" title="Add a job comment"></div>
        <button id="add-job-comment" class="btn btn-warning pad-button"><span class="glyphicon glyphicon-plus"></span> Add job comment</button>
    </div>

    </fieldset>
    </div>
    <hr/>
    <?= $this->Form->button(__('Submit Job Request'),
        array(
            'class' => 'btn btn-success',
            'div' => false,
            'id' => 'submit-job-form-button'
            ));
         echo $this->Html->link('' . __('Go back'), ['controller' => 'Jobs', 'action' => 'index'], array(
                'escape' => false,
                'class' => 'btn btn-default',
                'style' => 'margin-left:10px'
            ));
    ?>
    <?= $this->Form->end() ?>
</div>