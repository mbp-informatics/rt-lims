$( function() {
/* Initiate the grid  and the locations table */
refreshGrid();
refreshLocationsTable();

/**  **FUNCTIONS**  **/
function refreshLocationsTable() {
    $.get('/inventory-boxes/view/'+inventoryBoxId+'/ajax/', function(ib_res){

        //Inventory box dataset
        var res = JSON.parse(ib_res);
        var locations = res.inventory_locations;
        var dataSet = [];

        for (var i=0; i<locations.length; i++) {
            label = locations[i]['inventory_vial'] ? locations[i]['inventory_vial']['label'] : '-';
            vial =  locations[i].inventory_vial ? '<a href="/inventory-vials/view/'+locations[i].inventory_vial.id+'">'+locations[i].inventory_vial.id+'</a>' : '-' ;
            var type = "-";
            if (locations[i].inventory_vial != null){
              if (locations[i].inventory_vial.sperm_cryo_id) { var type = "sperm cryo (<a href='/sperm-cryos/view/"+locations[i].inventory_vial.sperm_cryo_id+"'>"+locations[i].inventory_vial.sperm_cryo_id+")"; }
              if (locations[i].inventory_vial.embryo_cryo_id) { var type = "embryo cryo (<a href='/embryo-cryos/view/"+locations[i].inventory_vial.embryo_cryo_id+"''>"+locations[i].inventory_vial.embryo_cryo_id+")"; }
              if (locations[i].inventory_vial.es_cell_id) { var type = "es cell (<a href='/es-cells/view/"+locations[i].inventory_vial.es_cell_id+"'>"+locations[i].inventory_vial.es_cell_id+")"; }
            }
            row = [
              locations[i].id,
              locations[i].cell,
              label,
              vial,
              type
            ];

// if (i == 0) { console.log(locations[i].inventory_vial); continue; }
            dataSet.push(row);
        }
        $('#inventory-locations').DataTable( {
            destroy: true,
            paging: false,
            data: dataSet
        });        

    });
}

function refreshGrid() {
  $("#ajax-loader").show();
  $.get( "/inventory-boxes/view/"+ inventoryBoxId +"/ajax", function( data ) {
    var json = JSON.parse(data);
    $("#ajax-loader").hide();
    initGrid(json);
  });
}

function initGrid(json) {
    $('#content').html('<div id="grid"></div><div id="vialsGrid"></div>'); //reset the grid
    cellsNo = json.inventory_locations.length;
    sqr = Math.sqrt(cellsNo);

    // Check if the box is square. Style the containers accordingly
    if (Number.isInteger(sqr)) {    
      var width = sqr * 52; //icons are 52x52px
      $('#content').css('width', width+"px");
      $('#vialsGrid').css('width', width+"px");
    } else {
      $ ('#content').css('width', width+"px");
      $('#vialsGrid').css('width', width+"px");
    }

    // Insert slots (cells)
    for ( var i=1; i<=json.inventory_locations.length; i++ ) {
      $('<div>' + i + '</div>').data( { id: i, locationId: json.inventory_locations[i-1].id } ).appendTo( '#grid' ).addClass( "cells" ).droppable( {
        hoverClass: 'hovered',
        drop: handleVialDrop
      } );
    }

    // Insert Vials
    var vialOptions = {
        containment: '#content',
        stack: '#grid div',
        cursor: 'move',
        revert: false
    };
    for ( var i=1; i<=json.inventory_locations.length; i++ ) {
      var sampleType = null;
      if (json.inventory_locations[i-1].inventory_vial) { //check if location has a vial

        if (json.inventory_locations[i-1].inventory_vial.embryo_cryo_id) { //check if a sample is embryo
          sampleType = 'embryo';
        }
        if (json.inventory_locations[i-1].inventory_vial.sperm_cryo_id) { //check if a sample is sperm
          sampleType = 'sperm';
        }
        if (json.inventory_locations[i-1].inventory_vial.es_cell_id) { //check if a sample is sperm
          sampleType = 'escell';
        }
        $('<div title="Click for details"></div>').data( { id: i, vialId: json.inventory_locations[i-1].inventory_vial.id, locationId : json.inventory_locations[i-1].id } ).appendTo( '#vialsGrid' ).addClass( "vials "+sampleType ).draggable(vialOptions);
      } else { //location doesn't have a vial, insert ghost vial instead
          $('<div></div>').data( {id : i, locationId : json.inventory_locations[i-1].id }).appendTo( '#vialsGrid' ).addClass( "ghost-vials" ).attr('locationId', json.inventory_locations[i-1].id); 
        }
    }
    // Show modal with detailed vial information on vial click
    $( "div.vials" ).click(
      function(e) {
        //Find the right location
        for ( var i=0; i<json.inventory_locations.length; i++ ) {
          if (json.inventory_locations[i].id == $(this).data('locationId')) {
            break;
          }
        }
        vial = json.inventory_locations[i].inventory_vial;
        if (vial.embryo_cryo_id) { var type = 'Embryo cryo id:'+ vial.embryo_cryo_id}
        if (vial.sperm_cryo_id) { var type = 'Sperm cryo id:'+ vial.sperm_cryo_id}
        if (vial.es_cell_id) { var type = 'Es cell id:'+ vial.es_cell_id}
        alertModal(`Vial details`,
          `<div class="pull-right"><a href="/inventory-vials/edit/`+vial.id+`" class="btn btn-info btn-sm active" role="button">Edit</a> <a href="/inventory-shipped-vials/add/` + vial.id + `/` + json.inventory_locations[i].id + `" class="btn btn-info btn-sm active" role="button">Ship</a></div>`+
          `<strong>Vial Id</strong>: ` + vial.id + `<br/>` + 
          `<strong>Type</strong>: ` + type + `<br/>` + 
          `<strong>Label</strong>: ` + vial.label + `<br/>` + 
          `<strong>Volume</strong>: ` + vial.volume + `<br/>` + 
          `<strong>Tissue</strong>: ` + vial.tissue + `<br/>` +
          `<strong>Vial type</strong>: ` + vial.inventory_vial_type.name + `<br/>` +
          `<strong>Comments</strong>: ` + vial.comments
          );  
      }
    );
    // Display Add new vial modal when an empty slot is clicked
    iniDialog('.ghost-vials', '/inventory-vials/add-single', '', "Add Vial", 700);
} //end initGrid()

function handleVialDrop( event, ui ) {
  var cellId = $(this).data( 'id' );
  var vialCellId = ui.draggable.data( 'id' );
  var vialId = ui.draggable.data( 'vialId' );
  var newLocationId = $(this).data( 'locationId' );
  var cell = $(this);
  var vial = ui.draggable;
  ui.draggable.draggable( 'option', 'revert', false );

  //Check if a cell is not already taken by an embryo
  var cellTaken = false;
  $("div.vials.embryo").each(function(){
    if ( $(this).data( 'id' ) == cellId ) {
      cellTaken = true;
    }
  });
  //Check if a cell is not already taken by a sperm
  $("div.vials.sperm").each(function(){
    if ( $(this).data( 'id' ) == cellId ) {
      cellTaken = true;
    }
  });
  //Check if a cell is not already taken by a en es cell
  $("div.vials.escell").each(function(){
    if ( $(this).data( 'id' ) == cellId ) {
      cellTaken = true;
    }
  });

  if ( !cellTaken ) {
    if ( confirm('Are you sure you want to move this vial from cell no ' +vialCellId+ ' to cell no '+cellId+' ?') ) {
      $("#ajax-loader").show();
      //Update the database via ajax
      $.ajax({
        method: "PUT",
        url: '/inventory-vials/edit/'+vialId+'/ajax',
        data: { inventory_location_id: newLocationId}
      }).done(function( msg ) {
          ui.draggable.draggable( 'option', 'revert', false );
          ui.draggable.position( { of: cell, my: 'left top', at: 'left top' } );
          ui.draggable.data('id',cellId);
          refreshLocationsTable();
          refreshGrid();
      });
    } else {
      ui.draggable.draggable( 'option', 'revert', true );
      }
  } else {
      alertModal('Oooops...','Cell is already filled. Choose a different cell.')
      ui.draggable.draggable( 'option', 'revert', true );
  }
} //end handleVialDrop()

}); //end document ready