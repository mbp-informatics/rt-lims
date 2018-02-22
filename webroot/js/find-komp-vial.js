 function destroyDropdown($sel) {
        //Destroy the dropdown to clear previous options etc.
        var  $select = $sel.removeClass('grayOut').selectize();
        selectizeClones = $select[0].selectize;
        selectizeClones.destroy();  
    }

    var dataSet = []; 
    var selectedMgi;
    var selectedKompClone;
    var selectedKompVialId;
    var selectedKompOrderId = '';
    var genesInit = {
        valueField: 'mgi_accession_id',
        labelField: 'gene',
        searchField: 'gene',
        placeholder:"Enter gene name to get suggestions. 3 chars minimum!",
        persist: false,
        loadThrottle: 800,
        create: false,
        allowEmptyOption: true,
        load: function(query, callback) {
            $('#ajax-loader').show();
            if (!query.length || query.length < 3) {
                $('#ajax-loader').hide();
                return callback();
            }
            $.ajax({
                url: '/komp-vials-dump/find-vial/'+query,
                type: 'GET',
                dataType: 'json',
                error: function() {
                    $('#ajax-loader').hide();
                    return callback();
                },
                success: function(res) {
                    if (res.kompVialsDump.length === 0) {
                        alert('No genes found for query: '+query);
                        $('#ajax-loader').hide();
                        return callback();
                    }
                    dataSet = res;
                    prepedList = [];
                    for (k in res.kompVialsDump) {
                        prepedList.push( {mgi_accession_id : res.kompVialsDump[k].mgi_accession_id, gene:res.kompVialsDump[k].gene+' ('+ res.kompVialsDump[k].mgi_accession_id +')'} );

                    }
                    $('#ajax-loader').hide();
                    callback(prepedList);
                }
            });
        }
    };

    /* MAIN LOGIC */
    //Initialize selectize.js for Genes dropdown
    var $select = $('#genes').selectize(genesInit);
    selectizeGenes = $select[0].selectize;
    selectizeGenes.enable();


    /* EVENTS */
    $('#genes').change(function(e){ // fires up when a gene is selected
        selectedMgi = $(this).val();
        if (selectedMgi == '') { //no gene selected
            $('#ajax-loader').hide();
            return true;
        }
        lightUp($("label[for='clones']"));
        $('#b-2').addClass('badge-enabled');
        destroyDropdown($('#clones'));
        destroyDropdown($('#vials'));
        // Prepare clones dropdown dataset
        clonesList = [];
        for (k in dataSet.kompVialsDump) {
            if (dataSet.kompVialsDump[k]['mgi_accession_id'] == selectedMgi &&
                dataSet.kompVialsDump[k]['clone_name'] != '') {
                var clone_label = dataSet.kompVialsDump[k]['komp_order_id'] ? dataSet.kompVialsDump[k]['clone_name']+' (has orders)' : dataSet.kompVialsDump[k]['clone_name'];
                    clonesList.push({clone_name: dataSet.kompVialsDump[k]['clone_name'], clone_label: clone_label});
            }
        }
        //Initialize selectize.js for Clones dropdown
        var $select = $('#clones').selectize({
            valueField: 'clone_name',
            labelField: 'clone_label',
            searchField: ['clone_name'],
            options: clonesList
        });
        selectizeClones = $select[0].selectize;
        selectizeClones.enable();
    })

    $('#clones').change(function(e){ // fires up when a clone is selected
        selectedKompClone = $(this).val();
        if (selectedKompClone == '') { //no clone selected
            $('#ajax-loader').hide();
            return true;
        }
        lightUp($("label[for='vials']"));
        $('#b-3').addClass('badge-enabled');
        destroyDropdown($('#vials'));
        // Prepare vials dropdown dataset
        vialsList = [];
        for (k in dataSet.kompVialsDump) {
            if (dataSet.kompVialsDump[k]['clone_name'] == selectedKompClone &&
                dataSet.kompVialsDump[k]['komp_vial_id'] != '') {
                    vialsList.push({
                        komp_vial_value: dataSet.kompVialsDump[k]['komp_vial_id'],
                        komp_vial_label: dataSet.kompVialsDump[k]['komp_vial_id']
                    });
            }
        }
        //Initialize selectize.js for Vials dropdown
        var $select = $('#vials').selectize({
            valueField: 'komp_vial_value',
            labelField: 'komp_vial_label',
            searchField: ['komp_vial_id'],
            options: vialsList
        });
        selectizeVials = $select[0].selectize;
        selectizeVials.enable();
    });

    $('#vials').change(function(e){ // fires up when a vial is selected
        selectedKompVialId = $(this).val();
        if (selectedKompVialId == 'null' || selectedKompVialId == '') { return; }

        lightUp($("label[for='orders']"));
        $('#b-4').addClass('badge-enabled');
        destroyDropdown($('#orders'));
        // Prepare orders dropdown dataset
        ordersList = [];
        for (k in dataSet.kompVialsDump) {
            if (dataSet.kompVialsDump[k]['clone_name'] == selectedKompClone) {
                    ordersList.push({
                        komp_order_value: dataSet.kompVialsDump[k]['komp_order_id'],
                        komp_order_label: dataSet.kompVialsDump[k]['komp_order_id']
                    });
            }
        }
        //Initialize selectize.js for Orders dropdown
        var $select = $('#orders').selectize({
            valueField: 'komp_order_value',
            labelField: 'komp_order_label',
            searchField: ['komp_order_id'],
            options: ordersList
        });
        selectizeOrders = $select[0].selectize;
        selectizeOrders.enable();        
        $('#submit-komp-vial-button').show('slow');
    });

    $('#orders').change(function(e){ // fires up when an order is selected
        selectedKompOrderId = ($(this).val());
        if (selectedKompOrderId == 'null' || selectedKompOrderId == '') { return; }
    });