<script>
$( document ).ready(function() {

    /* Initiate jQuery UI dialogs/modals */
    iniDialog('#associate-contact', '/contacts-jobs/addAjax/');
    iniDialog('#add-contact', '/contacts/addAjax/');
    iniDialog('#add-job-comment', '/job-comments/addAjax/');

    /* Some global vars, mkey? */
    $( "#dialog-add-job-comment" ).data('jobComment-id', 0);
    $( "#dialog-associate-contact" ).data('jobContact-id', 0);

    //Submit form on click handler
    $('#submit-job-form-button').click(function(e) {
        e.preventDefault();
        var form = $( '#job-request-form');

        //Extract Job Comments from the table
        var i = 0;
        $('td.jobComments').each(function(){
            val = $(this)[0].innerText;
            val = val.replaceAll("'", "&apos;");
            el = "<input class='hidden' type='text' name='jobComments["+ i +"]' value='" + val +"'>"
            form.append(el);
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
    $(document).on('click ', '#jobContacts a, #jobTypes a, #jobComments a', function(event){
        event.preventDefault();
        var rowId = $(this)[0].id;
        $("#"+rowId).fadeOut(300, function(){ $(this).remove();}); //remove the row from DOM     
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
        <legend><?= __('Add New Injection Request') ?></legend>
        <div class="module related horizontal-table job-source">
            <div class='col-xs-4 '>
                <?php echo $this->Form->input('job_source', [
                    'options' => ['KOMP' => 'KOMP', 'MMRRC' => 'MMRRC', 'MBP' => 'MBP'],
                    'label' => 'Job Source',
                    'empty' => true
                ]); ?></div>
                <div class='col-xs-4 '>
                <?php echo $this->customForm->displayMgiGenesDropdown(); ?></div>
                <div class='col-xs-4 '>
                <?php echo $this->Form->input('cell_clone_line', [
                    'label' => 'Cell/Clone line',
                    'empty' => true
                ]); ?></div>
            <div class="clearfix"></div>
        </div>


        <div class='row'>
            <div class='col-xs-4'><?php echo $this->CustomForm->displayDatepickerField('request_date', ['empty'=>true, 'label'=>'Request Date (YYYY-MM-DD)']); ?></div>
            <div class='col-xs-4'><?php echo $this->Form->input('mosaic_id_no',['label' => 'Closed Date', 'disabled' => true, 'placeholder' => 'Available only when editing job']);  ?></div>
            <div class='col-xs-4'><?php echo $this->CustomForm->displayField(
                        'membership', 
                        ['MMRRC' => 'MMRRC', 'MMRRC Customer Service' => 'MMRRC Customer Service', 'MBP' => 'MBP', 'MBP Customer Service'=>'MBP Customer Service', 'PI' => 'PI', 'KOMP' => 'KOMP', 'KOMP Customer Service' => 'KOMP Customer Service'],
                        true,
                        ['empty'=>true]
                    ); ?></div>
        </div>
        <div class='row'>
            <div class='col-xs-3'><?php echo $this->Form->input('order_no',['label' => 'Order #']); ?></div>
            <div class='col-xs-3'><?php echo $this->CustomForm->displayField(
                    'et_location', 
                    ['M3' => 'M3', 'MBP' => 'MBP'],
                    true,
                    ['empty'=>true, 'label' => 'Facility']
                ); ?></div>
            <div class='col-xs-3'><?php echo $this->Form->input('inj_parental_line',['label' => 'Parental Line']); ?></div>
            <div class='col-xs-3'><?php echo $this->Form->input('inj_preferred_donor',['label' => 'Preferred Donor']); ?></div>
        </div>
        <div class='row'>
            <div class='col-xs-3'>
                <label class="control-label" for="inj_injection_type">Injection Type</label>
                <div class="switch-toggle well">
                    <input id="inj_injection_type-basic" name="inj_injection_type" type="radio" value="Basic" checked>
                    <label class="pointer" for="inj_injection_type-basic">Basic</label>
                    <input id="inj_injection_type-guaranteed" name="inj_injection_type" value="Guaranteed" type="radio">
                    <label class="pointer" for="inj_injection_type-guaranteed">Guaranteed</label>
                    <a class="progress-bar"></a>
                </div>
            </div>
            <div class='col-xs-3'>
                <label class="control-label" for="inj_repeat">Repeat?</label>
                <div class="switch-toggle well">
                    <input id="inj_repeat-yes" name="inj_repeat" type="radio" value="1">
                    <label class="pointer" for="inj_repeat-yes">Yes</label>
                    <input id="inj_repeat-no" name="inj_repeat" value="0" type="radio" checked>
                    <label class="pointer" for="inj_repeat-no">No</label>
                    <a class="progress-bar"></a>
                </div>
            </div>
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

        <?php
            echo $this->Form->hidden('user_id', [
                'options' => $users,
                'default' => $this->request->session()->read('Auth.User.id')
                ]);
            echo $this->Form->hidden('job_status_a', [
                'default' => 'New'
                ]);
            echo $this->Form->hidden('is_injection_request', [
                'default' => '1'
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
    <div class='alert alert-danger' role='alert'>Data Integrity/Double Entry</div>
    <div class="row">
        <div class='col-xs-3'><?php echo $this->Form->input('fmp_id_no', ['label' => 'ID in Filemaker']); ?></div>
    </div>
    </fieldset>
    </div>
    <hr/>
    <?= $this->Form->button(__('Submit New Injection Request'),
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