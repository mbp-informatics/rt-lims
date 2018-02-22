<script>
$( document ).ready( function() {
    $('#assign-contact-button').click(function(event) {
        $('#ajax-loader').show();
        event.preventDefault();
        var contactId = $('#contact-id').val();
        tableSelector = '#jobContacts';
        idPrefix = 'jobContact-';
        tdClass = 'jobContacts';
        dialogId = 'dialog-associate-contact';
        $.get( "/contacts/view/" + contactId + "/ajax", function( data ) {
            res = JSON.parse(data);
            extraFields = [res.first_name +' '+res.last_name, res.campus_company, res.contact_type.name, res.email + ' <a href="mailto:'+ res.email +'"><span class="glyphicon glyphicon-envelope"></span></a>'];
            populateRow(dialogId, tableSelector, idPrefix, tdClass, contactId, null, extraFields);
            $('#ajax-loader').hide();
            if (typeof startConfirmExit == 'function') { startConfirmExit(); }
        });
    });
});
</script>
<div class="contactsJobs form large-9 medium-8 columns content">
    <?= $this->Form->create($contactsJob, ['id'=>'associate-contact-form']) ?>
    <div style="border-bottom:1px solid #aaa; margin-bottom:15px">
    <fieldset">
    <legend><?= __('Associate a contact' ) ?></legend>
    <?php 
        echo $this->CustomForm->displayField(
                'contact_id', 
                $contacts,
                false,
                ['empty'=>true, 'label' => 'Select contact']
            );
        ?>
    </fieldset>
    </div>
    <?php
    if (count($contacts) > 0) {
    echo $this->Form->button(__('Assign'),
        array(
            'class' => 'btn btn-success',
            'div' => false,
            'id' => 'assign-contact-button'
            ));
    }
    if (count($contacts) < 1) { 
        echo "<p>No contacts can be associated with this job (all possible contacts already associated?). Add a new contact.</p></div>";
    }?> 
    <?= $this->Form->end() ?>
</div>
    <p style="border-top:1px solid #ddd; margin-top:25px;"><small>If the contact you're looking for is not on the list, please create a new contact first.</small></p>
