<style>
p.label {
    display:block;
}
</style>
<script>
$( document ).ready( function() {
    $('#submit-contact').click(function(event) {
        $('p.label').remove();
        var errors = [];
        //Look for errors in input fields
        $("#add-contact-form").find(':input').each(function(key, val) {
            var fieldName = $(this)[0].id;
            var fieldValue = $(this).val();
            var fieldHtml5Valid = $(this)[0].checkValidity();
            if (!fieldHtml5Valid) {
                errors.push( 'Value provided in field <em>' + fieldName + '</em> is invalid.');              
            }
        });
        //If there are errors, display them and stop.
        if (errors.length > 0) {
            $(errors).each(function(key) {
                $("<p class='label label-danger'>" + errors[key] +"</p>"  ).prependTo("#dialog-add-contact" );
            })
            return;
        }
        //Validation OK, we can save the contact now
        $('#ajax-loader').show();
        $.ajax({
          type: "POST",
          url: '/contacts/addAjax',
          data: $('#add-contact-form').serialize(),
          success: function(res) {
            data = JSON.parse(res);
            $('#ajax-loader').hide();
            if (data.success) {
                $("<p class='label label-primary'>" + data.success +"</p>"  ).prependTo("#dialog-add-contact" );
                resetForm('#add-contact-form');
            }
            if (data.error) {
                $("<p class='label label-danger'>" + data.error +"</p>"  ).prependTo("#dialog-add-contact" );
            }
          }
        });
    });
});
</script>
<br/>
<div class="jobContacts form large-9 medium-8 columns content">
    <div class='container-fluid'>
        <div style="border-bottom:1px solid #aaa; margin-bottom:15px">
        <?= $this->Form->create($contact, ['id'=>'add-contact-form']) ?>
        <fieldset>
            <legend><?= __('Add Contact') ?></legend>
            <p style="text-align:center; display:none" id="ajax-loader"><img src="/img/ajax-loader.gif"> <small>Please wait...</small></p>
            <div class='row'>
                <div class='col-sm-4'><?php echo $this->Form->input('first_name', ['label' => 'First Name', 'required' => true]); ?></div>
                <div class='col-sm-4'><?php echo $this->Form->input('last_name', ['label' => 'Last Name', 'required' => true]); ?></div>           
                <div class='col-sm-4'><?php echo $this->CustomForm->displayField(
                        'campus_company', 
                       	$this->CustomForm->getCampusList(),
                        true,
                        ['empty'=>true, 'label' => 'Campus/Institution', 'required' => true]
                    ); ?></div>
                </div>

            <div class='row'>
                <div class='col-sm-6'><?php echo $this->Form->input('contact_type_id', [
                    'options' => $ContactTypes,
                    'empty' => true,
                    'label' => 'Contact Type',
                    'required' => true
                    ]);  ?></div>  
                <div class='col-sm-6'><?php echo $this->Form->input('email', ['type'=>'email','required' => true]); ?></div>
            </div>
        </fieldset>
            </div>
    <?= $this->Form->button(__('Add Contact'),
        array(
            'class' => 'btn btn-success',
            'id' => 'submit-contact',
            'div' => false
            ));
    ?>
    <?= $this->Form->end() ?>
    </div>
</div>