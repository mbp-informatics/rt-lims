$( document ).ready(function() {
    var numCells;

    $('#inventory-box-id').change(function() {
        var invBoxId = $(this).val();
        if (invBoxId) {
            $('#ajax-loader').show();
            $.get('/inventory-boxes/view/'+invBoxId+'/ajax', function(data) {
                var json = JSON.parse(data);
                numCells = json.inventory_box_type.num_cells;

                var numLocations = Object.keys(json.inventory_locations).length;
                if (numLocations > numCells-1 ) {
                    alert('This box has all locations. Choose a different box.')
                    var $select = $('#inventory-box-id').selectize();
                    var control = $select[0].selectize;
                    control.clear();
                } else {
                    $( "#cell" ).prop( "disabled", false );
                    $("#cell").attr("placeholder", "Enter Cell ID.");
                }                
                $('#ajax-loader').hide();
                $( "#cell" ).trigger( "focusout" );
            });
        } else {
            $( "#cell" ).prop( "disabled", true );
            $("#cell").attr("placeholder", "Please select Inventory Box first.");
        }
    });

    /* Prevent form submission on enter */
    $( "#form-inventory-locations" ).on('keyup keypress', function( event ) {
        var keyCode = event.keyCode || event.which;
        if(keyCode == 13) {
            event.preventDefault();
            return false;
        }
    });

    /* Trigger even on page load of Edit page*/
    if ($('#inventory-box-id').val() !== '') {
        $( "#inventory-box-id" ).trigger( "change" );
    }
});