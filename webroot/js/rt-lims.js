$(document).ready(function() {
clearAll();

$( window ).resize(function() {
clearAll();
});

/**
 * A hack to apply the resizing when everything has loaded,
 * Do this four times only.
 */
var i = 0;
var h = setInterval( function(){ 
    clearAll();
    if (++i === 4) { clearInterval(h); }
}, 300, i, h);

$( window ).scroll(function() {
	if ( ($( document ).height() - $( document ).scrollTop()) == $( window ).height()) {
		$('#fading-bottom').css('visibility','hidden'); //hide at the bottom of the page
	} else {
		$('#fading-bottom').css('visibility','visible'); //show again when scroll up
		$('.article').css('border-bottom', '5px solid #ccc');
	}
});

/* Redirect to the print view when print button is clicked */
$('.print-icon').click(function(event){
    window.location = window.location.pathname + '?print' + window.location.hash;
});

/* Resizes article width according to the viewport size */
function resizeArticle() {
    var sidebarHidden = ($('#sidebar-wrapper').width() < 250) ? true : false;
    if (sidebarHidden) {
        var menuWidth = 0;
        $('#logo-gfx').hide();
    } else {
        var menuWidth = 260;
        $('#logo-gfx').show();
    }
    newArtWidth = $(window).width() - menuWidth;
    $('.article').css('width', newArtWidth + 'px');
}

/**
 * Resizes blue background under the header img bar
 * to have the same height as the img. Plus resizes the logo img.
 */
function resizeHeaderImgs() {
    newBgHeight = $('.header-img').height();
    $('#header').css('height', newBgHeight + 'px');
    $('#logo-gfx').css('height', (newBgHeight-25) + 'px');
}    

function resizeFadingBottom() {
	if ($(document).height() > $(window).height()) {
		$('.article').css('border-bottom', 'none');
		$('#fading-bottom').css('visibility','visible');
		$('#fading-bottom').css('width', $('.article').outerWidth());
	} else {
		$('#fading-bottom').css('visibility','hidden');
		$('.article').css('border-bottom', '5px solid #ccc');
	}
}

function clearAll() {
    resizeArticle();
    resizeFadingBottom();
    resizeHeaderImgs();   
}

/* Add blue thead background to data tables */
$('.data-table').find('thead').find('tr').addClass('info');

/* Initiate DataTables jQuery plugin */
$('.data-table').dataTable({
    'scrollX':true,
    "autoWidth": true,
    "order": [[ 0, "desc" ]]
});

/* Initiate Bootstrap tooltip */
$('[data-toggle="tooltip"]').tooltip();

/* ***************************************************************** */

/*Adds up male and female pups and prepopulates "Number Total Pups".
Used when adding/editting entries on Transfer page */
var females, males;
$('#number-female-pups').blur(function() {
    females =  parseInt($(this).val());
    testCompleteness();
});

$('#number-male-pups').blur(function() {
    males =  parseInt($(this).val());
    testCompleteness();
});
function testCompleteness() {
    if (females && males) {
        $('#number-total-pups').val(females + males);
        lightUp($("label[for='number-total-pups']"));
    }
}

});//end document ready

/* Global functions */

/**
 * Initiates Server Side Data Tables for a given selector string.
 * Note: To work, controller must have implemented:
 * pagination, sorting, search mechanisms. There's a $this->Search->prepareDataTablesResultSet()
 * method ready to be used by controllers specifically for that.

 * @param string selString Selector string of a table e.g. '.data-table'
 * @param array columns Which table columns from the result set should be displayed
 * @param object injectObj An object containinga a column name and string to be injected
 * @param string url Ajax url, default is window.href
 * @param string type Request type, e.g. "POST", default is GET
 * @param object options Datatable.js custom options to use

 * into a column identified by 'column'. Note: the string is evaluated using eval() so make sure to
 * escape quotes appropriately. This also means you call field values using js vars e.g:
 * 'row.id' will return the value of 'id' field for a current row.

 * @return array Structured to be DataTables ready
 */
function iniDataTableServerSide(selString, columns, injectObj=null, url=null, type=null, options=null) {
    /* PLUGIN CODE 
     * This plugin overrides the default behaviour of initializing search
     * on every key press. It forces a user to hit Enter to initiate search
     */
    jQuery.fn.dataTableExt.oApi.fnFilterOnReturn = function (oSettings) {
    var _that = this;
    this.each(function (i) {
        $.fn.dataTableExt.iApiIndex = i;
        var $this = this;
        var anControl = $('input', _that.fnSettings().aanFeatures.f);
        anControl
            .unbind('keyup search input')
            .bind('keypress', function (e) {
                if (e.which == 13) {
                    $.fn.dataTableExt.iApiIndex = i;
                    _that.fnFilter(anControl.val());
                }
            });
        return this;
    });
    return this;
    };

   /* MAIN FUNCTION CODE 
    * Prepare data structures
    */
    $sel = $(selString);
    var dataTablesColumns = []
    columns.forEach(function(el){
        dataTablesColumns.push({ "data": el });
    });
    var url = url ? url : window.location;
    var type = type ? type : 'GET'; //use GET by default
    var idColNo = columns.indexOf('id') != '-1' ? columns.indexOf('id') : columns.indexOf('ID');

    // Destroy existing dataTable object to prevent reinitializtion
    if ( $.fn.DataTable.isDataTable( selString ) ) {
        $sel.DataTable().destroy();
    }
    
    var iniOptions = {
        "processing": true,
        "serverSide": true,
        "searchDelay": 600,
        "order": [[ idColNo, "desc" ]],
        'dom': 'flBrtip',
        'buttons': [
            { extend: 'excel', text: 'Save current table view as XLSX' }
        ],
        lengthMenu: [
                    [ 10, 25, 50, 100, 500, 1000, 2000, 5000, 10000, 1000000 ],
                    [ '10 rows', '25 rows', '50 rows', '100 rows', '500 rows', '1000 rows', '2000 rows', '5000 rows', '10000 rows', 'Show all' ]
                ],
        "ajax": {
            "type"   : type,
            "url"    : url,
            "dataSrc": function (json) {
              var return_data = [];
              var data = json.data;
              if (injectObj) {
                  for(var i=0;i< data.length; i++){
                    var row = data[i];
                    return_data[i] = data[i];
                        var type = (typeof injectObj[0] == 'undefined') ? 'object' : 'array';
                        if (type == 'array') {
                            injectObj.forEach(function(el){
                                return_data[i][el.column] = eval(el.string);
                            });
                        }
                        if (type == 'object') {
                            return_data[i][injectObj.column] = eval(injectObj.string);
                        }
                  }
                  return return_data;
              }
              return data;
            }
        },
        "oLanguage": {
         "sProcessing": "<span style='font-weight:bold; font-size:20px; color:#FF69B4;'>Loading...</span> <img style='margin-top:-12px;' src='/img/cube-loader.gif'>"
       },
        "columns": dataTablesColumns
    };
    //Insert custom options
    if (options) {
        for (property in options){
            iniOptions[property] = options[property];
        }
    }
    //Initialize again with server side data source enabled
    $(selString).dataTable(iniOptions).fnFilterOnReturn();

    //Change search box styling
    $('.dataTables_filter input')
        .attr("placeholder", "Type in search phrase and hit 'Enter' ...")
        .css({'font-size':'small', 'font-weight':'normal', 'font-style':'italic', 'width':'400px'});
}


function lightUp(selector, color) {
    var selected = $(selector);
    if (typeof color === 'undefined') { color = "yellow"};
    var readonly = selected.prop('readonly');
    var bgColor = selected.css('backgroundColor')
    //var bgColor = '#fff';
    selected
    .animate({ backgroundColor: color}, 2000)
    .animate({ backgroundColor: bgColor }, 1000);
    if (readonly) {
        selected.prop('readonly', true);
    }
}

function alertModal(heading, text) {
        var uniqueId = new Date().getUTCMilliseconds();
        var dialog = `<div id="dialog` + uniqueId + `" title="` + heading + `">
                    <p>` + text + `</p>
                    </div>`;
        $( "body" ).append(dialog);
        $( "#dialog" + uniqueId ).dialog({
              width: 400,
              modal: true,
              buttons: {
                Ok: function() {
                  $( this ).dialog( "close" );
                }
            }
        });
}

function changeDate(days, date1Input, date2Input, lightupSelector) {
    var days = parseInt(days);
    date1D = parseInt($('select[name="' + date1Input + '[day]"]').val());
    date1M = parseInt($('select[name="' + date1Input + '[month]"]').val())-1;
    date1Y =  parseInt($('select[name="' + date1Input + '[year]"]').val());

    var date1 = new Date(date1Y, date1M, date1D);
    date1.setDate(date1.getDate() + days) //add n days to datePlugged
    date2 = date1;
    var newDay = date2.getDate();
    var newMonth = date2.getMonth()+1;
    var newYear = date2.getFullYear();
    
    newMonth = newMonth.toString();
    newDay = newDay.toString();
    if (newMonth.length == 1) { newMonth = '0' + newMonth; }
    if (newDay.length == 1) { newDay = '0' + newDay; } 

    $('select[name="' + date2Input + '[day]"]').val(newDay);
    $('select[name="' + date2Input + '[month]"]').val(newMonth);
    $('select[name="' + date2Input + '[year]"]').val(newYear);
    lightUp(lightupSelector);
}

//There's no string.replaceAll() method in JS, so we must create one ourselves, lol
String.prototype.replaceAll = function(search, replacement) {
    var target = this;
    return target.replace(new RegExp(search, 'g'), replacement);
    };

/** Initiates the jquery UI dialog and sets button onclick events
  * First time used on Job Request page.
  */
function iniDialog(dialogId, ajaxUri, params='', title=null, width = null, height = null, redir = null) {
    if (!width) { var width = 550; }
    if (!height) { var height = 500; }
    selector = dialogId;
    if (dialogId.indexOf('.') !== -1) { //class
        dialogId = dialogId.replace('.','');
    } else { //id
        dialogId = dialogId.replace('#','');
    }
    if (title) {
        $('#dialog-'+dialogId).remove(); //make sure there's only 1 dialog with that id
        $("body").append('<div id="dialog-' + dialogId  + '" title="' + title + '"></div>');
    }
    
    $( selector ).click(function(e) {
        e.preventDefault();
        var dialog = $( "#dialog-"+dialogId ).dialog({
            autoOpen: false,
            width: width,
            height: height,
            modal: true,
            });
        $( "#dialog-"+dialogId ).html('<p style="text-align:center"><img src="/img/ajax-loader.gif"> <small>Please wait...</small></p>');
        $('#ajax-loader').show();
        dialog.dialog( "open" );

        if (Array.isArray(params)) {
            paramsString = '';
            for (var i = 0; i < params.length; i++) {
                paramsString +='/'+params[i];
            }
        } else {
            paramsString = params;
        }

        /* apend location Id to the url - used by Freezer Inventory graphical grid view */
        if ( $(this).data('locationId') ) {
            paramsString += "/" +$(this).data('locationId');
        }
        
        /* get modal contents via ajax */
        var fullUrl = ajaxUri + paramsString +"/"+"?redir="+redir;
        $.get( fullUrl.replace('//', '/'), function( data ) {
          $( "#dialog-"+dialogId ).html( data );
          $('#ajax-loader').hide();
        });
    });
}

//This prevents the page from  going back when backspace is pressed. Backspace still works in the input and textarea types
$(document).on("keydown", function (event) {
    if (event.which === 8 && !$(event.target).is("input, textarea")) {
        event.preventDefault();
    }
});

/**
 * This will populate a table row. Used by Job Comments, Requested Job Types etc. modals
 * on Add Job page.
 */
function populateRow(dialogId, tableSelector, idPrefix, tdClass, mainValue, mainValueKey=null, extraFields=null, extraFieldsTdClasses=null ) {
    var elemId = $( "#" + dialogId ).data(idPrefix + 'id');
        $( "#" + dialogId ).dialog('close');
        /* Populate the table with values */
        var table = $(tableSelector);
        var deleteAction =`
            <td class="actions">
                <span data-toggle="tooltip" title="Delete">
                    <a href="#" id="` + idPrefix + elemId + `" class="label label-danger action-pad"><span class="pad-action-glyph glyphicon glyphicon glyphicon-trash"></span>
                    </a>
                </span>
            </td>`;
        var dataAttr = '';
        if (mainValueKey) {
            dataAttr = 'data-key="' + mainValueKey + '"';
        }
        if (extraFields) {
            var extraFieldsStr = '';
            $(extraFields).each(function(key, val) {
                if (extraFieldsTdClasses !== null && extraFieldsTdClasses[key] !== undefined) {
                    extraFieldsStr += '<td class="'+extraFieldsTdClasses[key]+'">' + val + '</td>';
                } else {
                    extraFieldsStr += '<td>' + val + '</td>';    
                }
                
            });
        }
        $( table ).append( "<tr id='" + idPrefix + elemId + "'><td " + dataAttr + " class='" + tdClass + "'>" + mainValue + "</td>"+ extraFieldsStr + deleteAction + "</tr>" );
        /* Increment element id */
        elemId++;
        $( "#" + dialogId ).data(idPrefix + 'id', elemId);
}

//Reset the form
function resetForm(selector) {
    $(selector).find(':input').each(function() {
        if ( $(this).attr('name') == '_method' ) { return true; } //don't clear _method field
        var fieldId = $(this)[0].id;
        var classes = $(this).attr('class');
        $(this).val(''); //insert empty string
        if (fieldId) {
            document.getElementById(fieldId).selectedIndex = -1; //reset dropdowns
        }
        if (classes && classes.search('selectized') > -1) { //reset selectize dropdowns
            var selectizeField = $('#'+fieldId).selectize();
            var control = selectizeField[0].selectize;
            control.clear();
        }
    });
}

