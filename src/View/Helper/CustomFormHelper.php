<?php
namespace App\View\Helper;

use Cake\View\Helper;
use Cake\ORM\TableRegistry;

class CustomFormHelper extends Helper
{

    public $helpers = ['Form'];



public function timeInput($fieldName, $labelName, $inputSize=null, $showCurrentTime=null) {
  $inputSize = isset($inputSize) ? $inputSize : '11'; //default input size = 11

  //prepopulate dropdown with current time 
  $hhValue = ''; $mmValue = ''; $amChecked = ''; $pmChecked = '';
  if (isset($showCurrentTime)) {
    $timeArr = explode('|', date("h|i|A"));
    $hhValue = "value='{$timeArr[0]}'";
    $mmValue = "value='{$timeArr[1]}'";
    if ($timeArr[2] == 'AM') {
      $amChecked = 'checked';  
    } else {
      $pmChecked = 'checked';  
    }
  }

  return "
  <style>
  .custom-time-input {
    display: inline-block;
    color:#555;
    border-radius:5px;
    border: 1px solid #ccc;
    line-height: 1.42857143;
    height: 34px;
    text-align:center;
  }
  </style>
      <div class='form-group'>
        <label class='control-label'>{$labelName}</label><br/>
          <input placeholder='Hours (HH)' class='custom-time-input' name='{$fieldName}[hour]' pattern='0?[0-9]|1[0-2]' size='{$inputSize}' {$hhValue}>
          <strong>:</strong>
          <input placeholder='Minutes (MM)' class='custom-time-input' name='{$fieldName}[minute]' pattern='[0-5]?[0-9]' size='{$inputSize}' {$mmValue}>
          &nbsp;
          <input class='form-check-input' type='radio' name='{$fieldName}[meridian]' id='am-radio' value='am' {$amChecked}>
          <label class='form-check-label' for='am-radio'>AM</label>
          <input class='form-check-input' type='radio' name='{$fieldName}[meridian]' id='pm-radio' value='pm' {$pmChecked}>
          <label class='form-check-label' for='pm-radio'>PM</label>
      </div>
    ";
}

public function displayAdvancedSearchInput($modelFields, $tableSelector=null) {
  $optionsHtmlStr = '';
  foreach ($modelFields as $field) {
    $optionsHtmlStr .= "<option value='{$field}'>{$field}</option>";
  }
  //Field
  $retHtmlStr = "
  <div class='col-xs-4'>
    <div class='form-group'>
        <select class='form-control adv-search-input-field'>
          <option value=''>Select field...</option>
          {$optionsHtmlStr} 
        </select>
    </div>
  </div>
  ";

  //Comparison operator
  $retHtmlStr .= "
  <div class='col-xs-4'>
    <div class='form-group'>
        <select class='form-control adv-search-input-field'>
          <option value=''>Select comparison operator...</option>
          <option value='equals'>equals</option>
          <option value='not_equals'>doesn't equal</option>
          <option value='contains'>contains</option>
          <option value='not_contains'>doesn't contain</option>
          <option value='greater_than'>greater than</option>
          <option value='less_than'>less than</option>
        </select>
    </div>
  </div>
  ";

  //Value
  $retHtmlStr .= "
    <div class='col-xs-2'>
      <div class='form-group'>
        <input type='text' class='form-control adv-search-input-field' placeholder='Enter value...'>
      </div>
    </div>
    ";

  //AND / OR link
  $retHtmlStr .= "
  <div class='col-xs-2'>
    <div class='form-group'>
        <select class='form-control adv-search-input-field'>
          <option value=''>Select link...</option>
          <option value='AND'>AND</option>
          <option value='OR'>OR</option>
        </select>
    </div>
  </div>
   ";

  $retHtmlStr = "
  <style>
    #adv-search-module {
      margin-bottom:20px;
      background-color:#f9f9f9
    }
  </style>
  <div id='adv-search-module' class='important'>
  <h4/>Advanced Search</h4>
  <div class='row' id='ini-row' style='display:none'>{$retHtmlStr}</div>
  <form id='adv-search-form'>
    <div class='row'>{$retHtmlStr}</div>
    <div id='buttons'></div>
    <button id='adv-search-button' type='submit' class='btn btn-success'><span class='glyphicon glyphicon-search'></span> Search</button>
    <button id='add-one' type='button' class='btn btn-default'><span class='glyphicon glyphicon-plus'></span> add condition</button>
  </form>
  </div>
  <script>
  $('document').ready(function() {
    $('#adv-search-form').submit( function(e) {
      e.preventDefault();
      var searchStr = 'advs|';

      //Let's build the search phrase
      $('.adv-search-input-field').each(function(){
        if ($(this).val() != '') {
          searchStr += $(this).val()+'|';  
        }
      });
      $('.data-table').dataTable().fnFilter(searchStr);
    });
    $('#add-one').click( function(e) {
      $('#ini-row').clone().insertBefore('#buttons').show('slow');
    });

  });
  </script>
    ";

  return $retHtmlStr;
}


public function iniConfirmExit($formSelector, $ignoredFieldsArr = null){
  
  $ignoredFieldsJsArrStr = '';
  if (isset($ignoredFieldsArr)) {
    $ignoredFieldsJsArrStr = "var ignoredFields = ['".implode("', '", $ignoredFieldsArr)."'];";
  }

  return "
<script>
    var confirmExit = false;
    var message = 'Are you sure you want to leave this page?';
    {$ignoredFieldsJsArrStr}
        function startConfirmExit() {
        if (!confirmExit) {
            confirmExit = true;

            window.onbeforeunload = function (event) {
                var e = event || window.event;
                // For old IE and Firefox
                if (e) {
                    e.returnValue = message;
                }
                return message;
            }
        }
    }

$(document).ready(function () {
    $('{$formSelector}').submit(function () {
        window.onbeforeunload = null;
        confirmExit = false;
    });

    $('input, textarea, select', $('{$formSelector}')).on('change keyup', function (e) {
      var fieldName = e.currentTarget.name;
      if (typeof ignoredFields == 'undefined') {
        startConfirmExit();
      } else if (ignoredFields.indexOf(fieldName)  === -1) { //not present in ignoredFields
        startConfirmExit();
      }
    });

});
</script>
  ";
}


    /**
     * Returns a string of container hierarchy
     *
     * @param array Array of container parents returned by getContainerParents($childId) method from HelperComponent.php
     * @return string A string representing container hierarchy e.g. 'MCRL Tank 1>Box Rack 1>Yet another box'.
      */
    public function getContainersHierarchy($parents, $delimiter = null) {
        if (!$parents) { return; }
        $string = '';
        if (!$delimiter) {
            $delimiter = ">";
        }
        $parents = array_reverse($parents);
        foreach ($parents as $parent) {
            $string .= $parent->name.$delimiter;
        }
        return $string;
    }

    /**
     * Creates a list of previouse unique values for $dbFieldName for
     * the current model (e.g. if you use this helper from
     * Injections view, it will query the 'Injections' table.
     * This helper is to be used in dropdowns.
     * @param string A field name for which unique values should be grabbed e.g. 'marker_symbol'
     * @param string (optional) A model name to use e.g. ImitsDumpMiPlans (if no $modelName specified, the model name is auto-detected based on the view from which this helper is called)
     * @return array Contains key=>value pairs to be used in dropdown. Note  $key and $value are the same.
     */

    public function getPrevValuesList($fieldName, $modelName=null)  {
        $modelName = isset($modelName) ? $modelName : $this->_View->name;
        $table = TableRegistry::get($modelName); //yes, I know it breaks MVC, but at least makes the code DRY :) - Tomek
        $resSet = $table
            ->find()
            ->select([$fieldName])
            ->distinct([$fieldName])
            ->toArray();
        $list = [];
        foreach ($resSet as $row) {
            $val = $row->$fieldName;
            if (empty($val)) { continue; }
            $list[$val] = $val;
        }
        return $list;
    }

    /**
     * Recurrently (i.e. will descend into child properties indifinetly)
     * displays non-scalar values in a form of a table. 
     * @param array||object A non-scalar variable you wish to display
     * @return string HTML string (<tr><td>) containg all key=>value pairs
     */
    public function displayCompound($var) {
        if (!is_object($var) && !is_array($var)) {
            return false;
        }
        if (empty($var)) {
            return false;
        }
        $indent = '&nbsp;&nbsp;&nbsp;&nbsp;';
        $html_string = '';
        foreach ($var as $k => $v) {
                if (is_object($v) || is_array($v) ) {
                    if ($k !== 0){
                        $html_string .= "<tr><th>{$k}</th><td></td></tr>";
                    }
                    $html_string .=  $this->displayCompound($v);
                } else {
                    $html_string .= "<tr>";
                    $html_string .= "<th scope='row'>{$indent}{$k}</th>";
                    $html_string .=  "<td>$v</td>";
                    $html_string .= "</tr>";
                }
        }
        return $html_string;
    }


    /**
     * Returns a HTML string representing search box used on index pages.
     * @param void
     * @return string HTML string containg search form
     */
    public function displaySearchBox() {
        $searchPhrase = isset($_GET['s']) ? $_GET['s'] : '';
        return '<form action="" method="GET">
         <div class="pull-right">
             <div class="input-group">
               <input type="text" class="form-control" name="s" value="'. $searchPhrase .'">
               <span class="input-group-btn">
                 <button class="btn btn-success" type="submit">Search!</button>
               </span>
             </div><!-- /input-group -->
         </div>
         </form>
         <div class="clearfix"></div>';
 }



    /**
     * Returns a string of container hierarchy
     *
     * @param array Array of container parents returned by getContainerParents($childId) method from HelperComponent.php
     * @return string A string representing container hierarchy e.g. 'MCRL Tank 1>Box Rack 1>Yet another box'.
      */
    public function getContainerHierarchy($parents, $delimiter = null) {
        if (!$parents) { return; }
        $string = '';
        if (!$delimiter) {
            $delimiter = ">";
        }
        $parents = array_reverse($parents);
        foreach ($parents as $parent) {
            $string .= $parent->name.$delimiter;
        }
        return rtrim($string, $delimiter);
    }

    /**
     * Display Field method - a helper for displaying dropdowns
     *
     * @param string The id of field do display
     * @param array An array of key=>value pairs to display in the dropdown.
     * @param bool editableDropdown|null If set to true, inits selectize.js to allow dropdown editing.
     * @param array $options An array of additional  options to pass to Cake's $this->Form->input() 
     * @return string Returns a html of the form field.
      */

    public function displayField($fieldId, $dropdownList, $editableDropdown = null, array $options=null) {

        if ($options) {
             foreach ($options as $k=>$v) {
                $options[$k] = $v;
             }
      	}

        /**
        * Get the current field value from the DB and add it to dropdown array.
        * This ensures that the current value is always displayed in the dropdown.
        */
        if (isset($dropdownList)) {
          $xmlParse = simplexml_load_string($this->Form->input($fieldId));
          $xml = $xmlParse->input[0];
          if ($xml) {
            $currentVal = (string) $xml->attributes()['value'];  
          }
          if (isset($currentVal) && !empty($currentVal)) {
            $dropdownList[$currentVal] = $currentVal;  
          }
        }

      	$options['options'] = $dropdownList;
        $options['placeholder'] = '';
        $resp = '';
        $resp .= $this->Form->input($fieldId, $options);
        
        $allowAddingItems = '';
        if ($editableDropdown) {
            $allowAddingItems = "create: true,";
        }
        $fieldId = str_replace('_', '-', $fieldId);
        $resp .= "
                <script>
                $( document ).ready(function() {
                    $('#$fieldId').selectize({
                        {$allowAddingItems}
                        sortField: 'text'
                    });
                });
                </script>
            ";
        return $resp;
    }

    /**
     * Display MGI Genes dropdown (values are auto-fetched after typing in 3 chars)
     * @return string Returns a html of the form field.
     */
    public function displayMgiGenesDropdown() {
                $resp = $this->Form->input('mgi_accession_id');
                $resp .= "
                    <script>
                        $(document).ready(function() {
                            $('#mgi-accession-id').selectize({
                                valueField: 'mgi_accession_id',
                                labelField: 'marker_symbol',
                                searchField: 'marker_symbol',
                                placeholder: 'Enter gene name/MGI to get suggestions. 3 chars minimum!',
                                options: [],
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
                                        url: '/mgi-genes-dump/index/ajax/',
                                        type: 'GET',
                                        dataType: 'json',
                                        data: {
                                            s: query,
                                        },
                                        error: function() {
                                            $('#ajax-loader').hide();
                                            return callback();
                                        },
                                        success: function(res) {
                                            if (res.mgiGenesDump.length === 0) {
                                                alert('No genes found fo query: '+query);
                                                $('#ajax-loader').hide();
                                                return callback();
                                            }
                                            prepedList = [];
                                            for (k in res.mgiGenesDump) {
                                                prepedList.push( {mgi_accession_id : res.mgiGenesDump[k].mgi_accession_id, marker_symbol:res.mgiGenesDump[k].marker_symbol+' ('+ res.mgiGenesDump[k].mgi_accession_id +')'} );
                                            }
                                            $('#ajax-loader').hide();
                                            callback(prepedList);
                                        }
                                    });
                                }
                            });
                        });
                    </script>
                ";
                return $resp;
    }

    /**
     * Display jQuery datepicker - a helper for displaying calendar popover
     *
     * @param string The id of field do display
     * @param array $options An array of additional  options to pass to Cake's $this->Form->input() 
     * @return string Returns a html of the form field.
      */

    public function displayDatepickerField($fieldId, array $options=null) {
                if ($options) {
                    foreach ($options as $k=>$v) {
                        $options[$k] = $v;
                    }
                } 
                $options['placeholder'] = '📅 ';
                $options['type'] = 'string';
                $options['dateFormat'] = 'yy-mm-dd';
                if (isset($options['id'])){
                    $fieldId = $options['id'];
                }


                $resp = '';
                $resp .= $this->Form->input($fieldId, $options);
                $allowAddingItems = '';
                $fieldId = str_replace('_', '-', $fieldId);
                $resp .= "
                    <script>
                        $(document).ready(function() {
                            $( '#{$fieldId}' ).datepicker({
                              dateFormat: 'yy-mm-dd'
                            });

                            /** When Backspace or Del key is pressed, 
                             * clear the form. Ignore all other key strokes.
                            
                            $('#{$fieldId}').keydown(function(e) {
                               if (e.which == 46 || e.which == 8) {
                                $(this).val(null);
                               }
                               e.preventDefault();
                               return false;
                            });
                            */
                        });
                    </script>
                    ";
                return $resp;
    }


    /**
     * Display a label implicating the value comes from Job Request
     *
     * @return string Returns a html string.
      */
    public function displayFromJobLabel() {
        return "<sup><span class='label label-info'>from Job Request</span></sup>";
    }

    /**
     * Getters for dropdown list values.
      */
    public function getBackgroundList() {
        $l = [
			'C57BL/6' => 'C57BL/6',
			'C57BL/6J' => 'C57BL/6J',
			'C57BL/6-129J' => 'C57BL/6-129J',
			'C57BL/6N' => 'C57BL/6N',
			'C57BL/6NTac' => 'C57BL/6NTac',
			'C57BL/6NCrl' => 'C57BL/6NCrl',
			'C57BL/6N-Atm1Brd;C57BL/6NCrl' => 'C57BL/6N-Atm1Brd;C57BL/6NCrl',
			'C57BL/6NCrl; C57BL/6NCrl-Tyr' => 'C57BL/6NCrl; C57BL/6NCrl-Tyr',
			'C57BL/6NHsd' => 'C57BL/6NHsd',
			'C57BL/6N; C57BL/6NJ' => 'C57BL/6N; C57BL/6NJ',
			'C57BL/6NTac; C57BL/6NCrl' => 'C57BL/6NTac; C57BL/6NCrl',
			'C57BL/6N; C57BL/6NTac' => 'C57BL/6N; C57BL/6NTac',
			'FVB/N' => 'FVB/N',
			'FVB/NJ' => 'FVB/NJ',
			'FVB/NCrl' => 'FVB/NCrl',
			'FVB/N-Swiss Webster hybrid' => 'FVB/N-Swiss Webster hybrid',
			'129S6/SvEvTac' => '129S6/SvEvTac',
			'Ola129' => 'Ola129',
			'SW/FVB' => 'SW/FVB',
			'FVB/N-IcrTac:ICR' => 'FVB/N-IcrTac:ICR',
			'FVB/N-Crl:CD1(ICR)' => 'FVB/N-Crl:CD1(ICR)',
			'129SvEvTac' => '129SvEvTac',
			'129/SvEvBrd x C57BL6/J mix' => '129/SvEvBrd x C57BL6/J mix',
			'B6/FVB' => 'B6/FVB',
			'FVB/B6' => 'FVB/B6',
			'B6/129' => 'B6/129',
			'129/B6' => '129/B6',
			'SVE129' => 'SVE129',
			'129S6' => '129S6',
			'Balb/c' => 'Balb/c',
			'Balb/cJ' => 'Balb/cJ',
			'B6/129/FVB/CD1' => 'B6/129/FVB/CD1',
			'FVB/Swiss/CD1' => 'FVB/Swiss/CD1',
			'C57BL6J/129' => 'C57BL6J/129',
			'See note below' => 'See note below',
			'C57BL/6NTac/USA;C57BL/6J-Tyrc-Brd;C57BL/6N' => 'C57BL/6NTac/USA;C57BL/6J-Tyrc-Brd;C57BL/6N',
			'C57BL/6NTac/USA;C57BL/6N' => 'C57BL/6NTac/USA;C57BL/6N',
			'C57BL/6NTac/USA;C57BL/6N-Atm1Brd/a' => 'C57BL/6NTac/USA;C57BL/6N-Atm1Brd/a',
			'C57BL/6NTac/Den;C57BL/6J-Tyrc-Brd;C57BL/6N' => 'C57BL/6NTac/Den;C57BL/6J-Tyrc-Brd;C57BL/6N',
			'C57BL/6, FVB' => 'C57BL/6, FVB',
			'C57BL/6N; C57BL/6J' => 'C57BL/6N; C57BL/6J',
			'Preferred Host' => 'Preferred Host',
            'Mutant' => 'Mutant'
        ];
        return $l;
    }

    public function getEsCellSourceList() {
        $l = [
            "PI" => "PI",
            "MSCL" => "MSCL",
            "BayGenomics" => "BayGenomics",
            "SIGTR" => "SIGTR",
            "Soriano" => "Soriano",
            "CMHD " => "CMHD ",
            "MMCL-ES" => "MMCL-ES",
            "KOMP-CSD" => "KOMP-CSD",
            "KOMP-Regeneron" => "KOMP-Regeneron",
            "TIGM" => "TIGM"
        ];
        return $l;
    }

    public function getShipReasonList() {
        $l = [
            'IVF' => 'IVF',
            'ICSI'  => 'ICSI',
            'IVF & ICSI' => 'IVF & ICSI',
            'RS' => 'RS',
            'Missing' => 'Missing',
            'Geno' => 'Geno',
            'Fake thaw' => 'Fake thaw',
            'Do Not Distribute' => 'Do Not Distribute',
            'Fell in Tank' => 'Fell in Tank',
            'Shipped' => 'Shipped',
            'Not Targeted' => 'Not Targeted',
            'Unrecoverable' => 'Unrecoverable',
            'TT Culture' => 'TT Culture'
        ];
        return $l;
    }

    public function getMicroinjectionDonorList() {
        $l = [
            "(B6;129-Gt(ROSA)26Sor<tm1(DTA)Mrc>/J x B6.FVB-Tg(Ddx4-cre)1Dcas>/J)F1/MvwJ" => "(B6;129-Gt(ROSA)26Sor<tm1(DTA)Mrc>/J x B6.FVB-Tg(Ddx4-cre)1Dcas>/J)F1/MvwJ",
            "B6D2F1 x B6" => "B6D2F1 x B6",
            "B6N-Tyrc/BrdCrCrl" => "B6N-Tyrc/BrdCrCrl",
            "BALB/c" => "BALB/c",
            "BALB/cAm" => "BALB/cAm",
            "BALB/cAnNCrl" => "BALB/cAnNCrl",
            "BALB/cJ" => "BALB/cJ",
            "BALB/cN" => "BALB/cN",
            "BALB/cWtsi;C57BL/6Brd-Tyr<c-Brd>" => "BALB/cWtsi;C57BL/6Brd-Tyr<c-Brd>",
            "BALB/cWtsi;C57BL/6J-Tyr<c-Brd>" => "BALB/cWtsi;C57BL/6J-Tyr<c-Brd>",
            "C3HxBALB/c" => "C3HxBALB/c",
            "C57BL/6Brd-Tyr<c-Brd>" => "C57BL/6Brd-Tyr<c-Brd>",
            "C57BL/6Brd-Tyr<c-Brd>;C57BL/6JIco" => "C57BL/6Brd-Tyr<c-Brd>;C57BL/6JIco",
            "C57BL/6Brd-Tyr<c-Brd>;C57BL/6N" => "C57BL/6Brd-Tyr<c-Brd>;C57BL/6N",
            "C57BL/6Brd-Tyr<c-Brd>;C57BL/6N;C57BL/6NTac" => "C57BL/6Brd-Tyr<c-Brd>;C57BL/6N;C57BL/6NTac",
            "C57BL/6Brd-Tyr<c-Brd>;Stock" => "C57BL/6Brd-Tyr<c-Brd>;Stock",
            "C57BL/6Dnk or C57BL/6NTac" => "C57BL/6Dnk or C57BL/6NTac",
            "C57Bl/6J Albino" => "C57Bl/6J Albino",
            "C57BL/6J Albino" => "C57BL/6J Albino",
            "C57BL/6J" => "C57BL/6J",
            "C57BL/6J-A<W-J>/J" => "C57BL/6J-A<W-J>/J",
            "C57BL/6JcBrd/cBrd" => "C57BL/6JcBrd/cBrd",
            "C57BL/6JOlaHsd" => "C57BL/6JOlaHsd",
            "C57BL/6J-Tyr<c-2J>" => "C57BL/6J-Tyr<c-2J>",
            "C57BL/6J-Tyr<c-2J>/J" => "C57BL/6J-Tyr<c-2J>/J",
            "C57BL/6J-Tyr<c-Brd>" => "C57BL/6J-Tyr<c-Brd>",
            "C57BL/6J-Tyr<c-Brd> or C57BL/6NTac/USA" => "C57BL/6J-Tyr<c-Brd> or C57BL/6NTac/USA",
            "C57BL/6J-Tyr<c-Brd>;C57BL/6N" => "C57BL/6J-Tyr<c-Brd>;C57BL/6N",
            "C57BL/6N" => "C57BL/6N",
            "C57BL/6N;C57BL/6NTac" => "C57BL/6N;C57BL/6NTac",
            "C57BL/6NCrl" => "C57BL/6NCrl",
            "C57BL/6NJ" => "C57BL/6NJ",
            "C57BL/6NJcl" => "C57BL/6NJcl",
            "C57BL/6NTac" => "C57BL/6NTac",
            "C57BL/6NTac/Den or C57BL/6NTac/USA" => "C57BL/6NTac/Den or C57BL/6NTac/USA",
            "C57BL/6NTac/USA" => "C57BL/6NTac/USA",
            "C57BL6/6NHsd" => "C57BL6/6NHsd",
            "C57BL6/NCrl" => "C57BL6/NCrl",
            "CD1" => "CD1",
            "FVB" => "FVB",
            "ICR (CD-1)" => "ICR (CD-1)",
            "ICR/Jcl" => "ICR/Jcl",
            "Stock" => "Stock",
            "Tg(CAG-EGFP)B5Nagy" => "Tg(CAG-EGFP)B5Nagy",
            "Tg(CAG-EGFP)B5Nagy or C57BL/6J Albino" => "Tg(CAG-EGFP)B5Nagy or C57BL/6J Albino",
        ];
        return $l;
    }
    
    public function getParentalEscLineList() {
        $l = [
            "JM8.N4" => "JM8.N4",
            "JM8A" => "JM8A",
            "JM8A1.N3" => "JM8A1.N3",
            "JM8A3.N1" => "JM8A3.N1",
            "JM8" => "JM8",
            "JM8.F6" => "JM8.F6",
            "R1" => "R1",
            "VGB6" => "VGB6",
            "E14" => "E14",
            "Bruce4" => "Bruce4"
        ];
        return $l;
    }

    public function getCampusList() {
        $l = [
			'UCD' => 'UCD',
			'UCSF' => 'UCSF',
			'UCLA' => 'UCLA',
			'UCSB' => 'UCSB',
			'UCSD' => 'UCSD',
			'UCM' => 'UCM',
			'UCB' => 'UCB',
			'USDA' => 'USDA'
        ];
        return $l;
    }

    public function getStateList() {
        $l = [
            'Alabama' => 'Alabama',
            'Alaska' => 'Alaska',
            'Arizona' => 'Arizona',
            'Arkansas' => 'Arkansas',
            'California' => 'California',
            'Colorado' => 'Colorado',
            'Connecticut' => 'Connecticut',
            'Delaware' => 'Delaware',
            'Florida' => 'Florida',
            'Georgia' => 'Georgia',
            'Hawaii' => 'Hawaii',
            'Idaho' => 'Idaho',
            'Illinois' => 'Illinois',
            'Indiana' => 'Indiana',
            'Iowa' => 'Iowa',
            'Kansas' => 'Kansas',
            'Kentucky' => 'Kentucky',
            'Louisiana' => 'Louisiana',
            'Maine' => 'Maine',
            'Maryland' => 'Maryland',
            'Massachusetts' => 'Massachusetts',
            'Michigan' => 'Michigan',
            'Minnesota' => 'Minnesota',
            'Mississippi' => 'Mississippi',
            'Missouri' => 'Missouri',
            'Montana' => 'Montana',
            'Nebraska' => 'Nebraska',
            'Nevada' => 'Nevada',
            'New Hampshire' => 'New Hampshire',
            'New Jersey' => 'New Jersey',
            'New Mexico' => 'New Mexico',
            'New York' => 'New York',
            'North Carolina' => 'North Carolina',
            'North Dakota' => 'North Dakota',
            'Ohio' => 'Ohio',
            'Oklahoma' => 'Oklahoma',
            'Oregon' => 'Oregon',
            'Pennsylvania' => 'Pennsylvania',
            'Rhode Island' => 'Rhode Island',
            'South Carolina' => 'South Carolina',
            'South Dakota' => 'South Dakota',
            'Tennessee' => 'Tennessee',
            'Texas' => 'Texas',
            'Utah' => 'Utah',
            'Vermont' => 'Vermont',
            'Virginia' => 'Virginia',
            'Washington' => 'Washington',
            'West Virginia' => 'West Virginia',
            'Wisconsin' => 'Wisconsin',
            'Wyoming' => 'Wyoming'
        ];
        return $l;
    }

    public function getSchoolList() {
        $l = [
			'School of Medicine' => 'School of Medicine',
			'School of Veterinary Medicine' => 'School of Veterinary Medicine',
			'Division of Biological Science' => 'Division of Biological Science',
			'Lawrence Livermore National Lab' => 'Lawrence Livermore National Lab',
			'College of Agricultural and Environmental Sciences' => 'College of Agricultural and Environmental Sciences',
			'School of Engineering' => 'School of Engineering',
			'Ernest Gallo Clinic & Research Center' => 'Ernest Gallo Clinic & Research Center',
			'Others' => 'Others'
        ];
        return $l;
    }

    public function getGenotypeList() {
        $l = [
            'Heterozygous (+/-)' =>'Heterozygous (+/-)',
            'Heterozygous (+/-) <tm1.1>' =>'Heterozygous (+/-) <tm1.1>',
            'Heterozygous (+/-) <tm1b>' =>'Heterozygous (+/-) <tm1b>',
            'Heterozygous (+/-) <tm1c>' =>'Heterozygous (+/-) <tm1c>',
            'Heterozygous (+/-) <tm1e.1>' =>'Heterozygous (+/-) <tm1e.1>',
            'Homozygous (-/-)' =>'Homozygous (-/-)',
            'Knock-In' =>'Knock-In',
            'Hemizygous' =>'Hemizygous',
            'Chimera' =>'Chimera',
            'tg/+' =>'tg/+',
            'Wildtype (+/+)' =>'Wildtype (+/+)',
            'Cre+' =>'Cre+',
            'Homo KO' =>'Homo KO',
            'Tg Homo KO' =>'Tg Homo KO',
            'Homo KI' =>'Homo KI',
            'CR Founder' =>'CR Founder',
            'Tg' =>'Tg',
            'b-het, CreR' =>'b-het, CreR',
            'VelociMouse' =>'VelociMouse',
            'Tg +/+' =>'Tg +/+',
            '+/floxed' =>'+/floxed',
            'KO' =>'KO',
            'Frameshift Indel' =>'Frameshift Indel'
        ];
        return $l;
    }

    public function getDonorStrainList() {
        $l = [
        'C57BL/6J' => 'C57BL/6J',
        'Swiss Webster/Tac' => 'Swiss Webster/Tac',
        'FVB/NJ' => 'FVB/NJ',
        'FVB/NTac' => 'FVB/NTac',
        'C57BL/6NTac' => 'C57BL/6NTac',
        'B6D2F1/J' => 'B6D2F1/J',
        'CD-1/Crl' => 'CD-1/Crl',
        // 'B6NCRL' => 'B6NCRL', Not on Jessica's list
        // 'B6NTac' => 'B6NTac',
        'C57BL/6NCrl' => 'C57BL/6NCrl',
        'C57BL/6NJ' => 'C57BL/6NJ',
        'B6129SF1/J' => 'B6129SF1/J',
        '129S1/SvImJ' => '129S1/SvImJ',
        '129S6/SvEvTac' => '129S6/SvEvTac',
        'C57BL/6NHsd' => 'C57BL/6NHsd',
        'NIH Swiss Outbred (Harlan)' => 'NIH Swiss Outbred (Harlan)',
        'B6CBAF1/J' => 'B6CBAF1/J',    
        'FVB/NCrl' => 'FVB/NCrl',
        'ICR/Tac' => 'ICR/Tac',    
        'Balb/cJ' => 'Balb/cJ',
        'Balb/cAnNHSD' => 'Balb/cAnNHSD',    
        'Balb/cAnNTac' => 'Balb/cAnNTac',
        'B6SJLF1/J (stock# 100012)' => 'B6SJLF1/J (stock# 100012)',    
        'Balb/cByJ' => 'Balb/cByJ',
        '129P2/OlaHSD' => '129P2/OlaHSD',    
        'B6(Cg)-Tyrc-2J/J (stock# 000058)' => 'B6(Cg)-Tyrc-2J/J (stock# 000058)',    
        'Mut females' => 'Mut females',  
        ];
        return $l;
    }

    public function getEmbryoResusMembershipList() {
        $l = [
        'MMRRC customer service' => 'MMRRC customer service',
        'KOMP customer service' => 'KOMP customer service',
        'MBP PI' => 'MBP PI',
        'MICM' => 'MICM'
        ];
        return $l;
    }

    public function getEmbryoResusPurposeList() {
        $l = [
        'resuscitation' => 'resuscitation',
        'rederivation' => 'rederivation',
        'rescue' => 'rescue',
        'Test Thaw' => 'Test Thaw',
        'Test' => 'Test',
        ];
        return $l;
    } 

    public function getMembershipList() {
        $l = [
			'MBP customer service (PI)' => 'MBP customer service (PI)',
			'MMRRC' => 'MMRRC',
			'MMRRC customer service' => 'MMRRC customer service',
			'MMRRC GS' => 'MMRRC GS',
			'MMRRC GS BAC Cre' => 'MMRRC GS BAC Cre',
			'MMRRC Genentech' => 'MMRRC Genentech',
			'KOMP' => 'KOMP',
			'KOMP customer service' => 'KOMP customer service',
			'K2' => 'K2',
			'KOMP2 Phase 1' => 'KOMP2 Phase 1',
			'KOMP Regeneron' => 'KOMP Regeneron',
			'KOMP Sanger' => 'KOMP Sanger',
			'MMRRC Lexicon' => 'MMRRC Lexicon',
			'MMRRC BG' => 'MMRRC BG',
			'MMRRC Taconic' => 'MMRRC Taconic',
			'MMRRC Contract' => 'MMRRC Contract',
			'Kent Lloyd' => 'Kent Lloyd',
			'MTGL Projects' => 'MTGL Projects',
			'MCRL' => 'MCRL',
			'MCRL - IVF/SC/EC practice' => 'MCRL - IVF/SC/EC practice',
			'MCRL - ET practice' => 'MCRL - ET practice',
			'MCRL - ICSI practice' => 'MCRL - ICSI practice',
			'MCRL - Ultra Superovulation' => 'MCRL - Ultra Superovulation',
			'MCRL - Zygote Cryo' => 'MCRL - Zygote Cryo',
			'MCRL - Morula & Blast Cryo' => 'MCRL - Morula & Blast Cryo',
			'MCRL - Egg Cryo' => 'MCRL - Egg Cryo',
			'MCRL - IVF Research' => 'MCRL - IVF Research',
			'MCRL - Sperm ED' => 'MCRL - Sperm ED',
			'MCRL - wt embryos' => 'MCRL - wt embryos',
			'Empty job' => 'Empty job'
        ];
        return $l;
    }

    public function getDonorAgeList() {
        $l = [
            '3-4 wks' => '3-4 wks',
            '4 wks' => '4 wks',
            '4-5 wks' => '4-5 wks',
            '5-6 wks' => '5-6 wks',
            '7-8 wks' => '7-8 wks',
            '9-10 wks' => '9-10 wks',
            '11-12 wks' => '11-12 wks',
            '13-14 wks' => '13-14 wks',
            '15-16 wks' => '15-16 wks'
        ];
        return $l;
    }

    public function getFertMethodList() {
        $l = [
            'MBCD-GSH IVF (fresh sperm)' => 'MBCD-GSH IVF (fresh sperm)',
            'MBCD-GSH IVF RS (40-100 ul sperm)' => 'MBCD-GSH IVF RS (40-100 ul sperm)',
            'MBCD-GSH IVF RS (10-15 ul sperm)' => 'MBCD-GSH IVF RS (10-15 ul sperm)',
            'Rescue MBCD-GSH IVF RS (40-100 ul sperml)' => 'Rescue MBCD-GSH IVF RS (40-100 ul sperml)',
            'Rescue MBCD-GSH IVF RS (10-15 ul sperm)' => 'Rescue MBCD-GSH IVF RS (10-15 ul sperm)',
            'Rescue IVF in MBCD (10-15 ul sperm)' => 'Rescue IVF in MBCD (10-15 ul sperm)',
            'Rescue IVF in MBCD (40-100ul sperm)' => 'Rescue IVF in MBCD (40-100ul sperm)',
            'Laser IVF (0.25 M sucrose)' => 'Laser IVF (0.25 M sucrose)',
            'Conventional IVF' => 'Conventional IVF'
        ];
        return $l;
    }

    public function getHousingLocationList() {
        $l = [
			'MBP 116' => 'MBP 116',
			'MBP 112' => 'MBP 112',
			'MBP 111' => 'MBP 111',
			'MBP 115' => 'MBP 115',
			'MBP 110' => 'MBP 110',
			'MBP 114' => 'MBP 114',
			'MBP 109' => 'MBP 109',
			'Freezer' => 'Freezer',
			'Tx from M3' => 'Tx from M3',
      'M1' => 'M1',
			'Refrigerator' => 'Refrigerator'
        ];
        return $l;
    }

    public function getNameList() {
        $l = [
            'Brandon Willis' => 'Brandon Willis',
            'Perminder Kaur' => 'Perminder Kaur',
            'Mark Ruhe' => 'Mark Ruhe',
            'Kristy Kinchen' => 'Kristy Kinchen',
            'Diana Young' => 'Diana Young',
            'Jasmin Zarrabi' => 'Jasmin Zarrabi',
            'Olivia Glass' => 'Olivia Glass',
            'Lisa Baker' => 'Lisa Baker',
            'Ming Wen Li' => 'Ming Wen Li',
            'LB/JZ' => 'LB/JZ',
            'Victoria Gilbert' => 'Victoria Gilbert',
            'Kristy Williams' => 'Kristy Williams'

        ];
        return $l;
    }

    public function getIncubatorList() {
        $l = [
			'1' => '1',
			'2' => '2',
			'3' => '3',
			'4' => '4',
			'SY' => 'SY',
			'Multigas' => 'Multigas'
        ];
        return $l;
    }

    public function getIvfNoteList() {
        $l = [
			'Fresh IVF data' => 'Fresh IVF data',
			'Zonae coming off' => 'Zonae coming off',
			'Low egg yield' => 'Low egg yield',
			'lots of sperm around eggs' => 'lots of sperm around eggs',
			'Zonae coming off and lots of sperm around eggs' => 'Zonae coming off and lots of sperm around eggs',
			'Many Eggs Dead' => 'Many Eggs Dead'
        ];
        return $l;
    }

    public function getIvfMethodList() {
        $l = [
			'MBCD-GSH IVF ' => 'MBCD-GSH IVF ',
			'Rescue MBCD-GSH IVF' => 'Rescue MBCD-GSH IVF',
			'Rescue IVF in MBCD' => 'Rescue IVF in MBCD',
			'Laser IVF (0.25 M sucrose)' => 'Laser IVF (0.25 M sucrose)',
			'Conventional IVF' => 'Conventional IVF',
			'Cumulus free/ZP intact IVF' => 'Cumulus free/ZP intact IVF',
			'ZP-free IVF' => 'ZP-free IVF'
        ];
        return $l;
    }

    public function getCryoMethodList() {
        $l = [
            'PROH' => 'PROH',
            'Vitrification-EG/FCS' => 'Vitrification-EG/FCS',
            'Vitrification-EDS' => 'Vitrification-EDS',
            'Vitrification-DAP213' => 'Vitrification-DAP213'
        ];
        return $l;
    }

    public function getChimeraFertilityList() {
        $l = [
			'Infertile' => 'Infertile',
			'Fertile' => 'Fertile',
			'Unsure' => 'Unsure'
        ];
        return $l;
    }

    public function getFemaleGenotypeList() {
        $l = [
			'Wildtype (+/+)' => 'Wildtype (+/+)',
			'Heterozygous (+/-)' => 'Heterozygous (+/-)',
			'Homozygous (-/-)' => 'Homozygous (-/-)',
			'Hemizygous' => 'Hemizygous',
			'Tg/+' => 'Tg/+',
			'Chimera' => 'Chimera',
			'CD1CRL' => 'CD1CRL',
			'Mut' => 'Mut',
			'het and wt' => 'het and wt'
        ];
        return $l;
    }

    public function getScTtBatchList() {
        $l = [
			'3092016' => '3092016',
			'12142015' => '12142015',
			'8262015' => '8262015',
			'3182015' => '3182015',
			'1092015' => '1092015',
			'10102014' => '10102014',
			'8082014' => '8082014',
			'5232014' => '5232014',
			'4112014' => '4112014',
			'1302014' => '1302014'
        ];
        return $l;
    }

    public function getCryoEmbryoStageList() {
        $l = [
            '2-cell ' => '2-cell ',
            'Zygote' => 'Zygote',
            '8-cell/Early Morula' => '8-cell/Early Morula',
            'Mor/Early Blast (2.5)' => 'Mor/Early Blast (2.5)',
            'Blast (3.5)' => 'Blast (3.5)'
        ];
        return $l;
    }

    public function getMcrlRechargeList() {
        $l = [
			'MR71 - MMRRC Receipt/Archiving' => 'MR71 - MMRRC Receipt/Archiving',
			'MR81 - MMRRC Services+Re-archiving' => 'MR81 - MMRRC Services+Re-archiving',
			'MM05 - Sulfur Metabolism research' => 'MM05 - Sulfur Metabolism research',
			'MM26 - CRISPR Multi-Target research' => 'MM26 - CRISPR Multi-Target research',
			'KP61 - KOMP Production' => 'KP61 - KOMP Production',
			'KL71 - KOMP II, Phase II' => 'KL71 - KOMP II, Phase II',
			'CRL2 - MICL Services' => 'CRL2 - MICL Services',
			'MR93 - MMRRC GS' => 'MR93 - MMRRC GS',
			'CRYC - Distribution of cryo materials from MBP and KOMP' => 'CRYC - Distribution of cryo materials from MBP and KOMP',
			'KL60 - sperm ED' => 'KL60 - sperm ED',
			'VMB4 - MTGL PI' => 'VMB4 - MTGL PI'
        ];
        return $l;
    }

    public function getMvpRechargeList() {
        $l = [
			'MR77 - MMRRC Receipt/Archiving' => 'MR77 - MMRRC Receipt/Archiving',
			'MR87 - MMRRC Services+Re-archiving' => 'MR87 - MMRRC Services+Re-archiving',
			'MM15 - Sulfur Metabolism research' => 'MM15 - Sulfur Metabolism research',
			'MM28 - CRISPR Multi-Target research' => 'MM28 - CRISPR Multi-Target research',
			'KP88 - KOMP Production' => 'KP88 - KOMP Production',
			'KL77 - KOMP II, Phase II' => 'KL77 - KOMP II, Phase II',
			'CRL2 - MICL Services' => 'CRL2 - MICL Services',
			'MR91 - MMRRC GS' => 'MR91 - MMRRC GS',
			'CRYV - Distribution of cryo materials from MBP and KOMP' => 'CRYV - Distribution of cryo materials from MBP and KOMP',
			'KL62 - sperm ED' => 'KL62 - sperm ED',
			'VMB4 - MTGL PI' => 'VMB4 - MTGL PI'
        ];
        return $l;
    }

    public function getMgelRechargeList() {
        $l = [
			'MR73 - MMRRC Receipt/Archiving' => 'MR73 - MMRRC Receipt/Archiving',
			'MR83 - MMRRC Services+Re-archiving' => 'MR83 - MMRRC Services+Re-archiving',
			'MM18 - Sulfur Metabolism research' => 'MM18 - Sulfur Metabolism research',
			'MM21 - CRISPR Multi-Target research' => 'MM21 - CRISPR Multi-Target research',
			'KP83 - KOMP Production' => 'KP83 - KOMP Production',
			'KL70 - KOMP II, Phase II' => 'KL70 - KOMP II, Phase II',
			'VMB7 - MICL Services' => 'VMB7 - MICL Services',
			'MR92 - MMRRC GS' => 'MR92 - MMRRC GS',
			'CRYG - KOMP Repository' => 'CRYG - KOMP Repository',
			'KL60- sperm ED' => 'KL60- sperm ED'
        ];
        return $l;
    }

    public function getGobletColorList() {
        $l = [
            'Pistachio' => 'Pistachio',
            'Green' => 'Green',
            'Purple' => 'Purple',
            'Blue' => 'Blue',
            'Grey' => 'Grey',
            'Clear' => 'Clear',
            'Red' => 'Red',
            'Yellow' => 'Yellow',
            'Orange' => 'Orange',
            'Black' => 'Black',
            'White' => 'White',
            'Brown' => 'Brown'
        ];
        return $l;
    }

    public function getCoatColorList() {
        $l = [
			'White' => 'White',
			'Black' => 'Black',
			'Albino' => 'Albino',
			'Agouti' => 'Agouti',
			'Black/Agouti' => 'Black/Agouti',
			'Brown' => 'Brown',
			'Black/Brown' => 'Black/Brown'
        ];
        return $l;
    }

    public function getescMorphologyList() {
        $l = [
            "1" => "1 = (small size, smooth, round cells)",
            "2" => "2 = (medium size, smooth, round cells)",
            "3" => "3 = (large size, smooth, round cells)",
            "4" => "4 = (any size, round cells, sticky debris)",
            "5" => "5 = (any size,  irregular shape cells)",
            "6" => "6 = (any size, irregular shape cells, sticky debris)"
        ];
        return $l;
    }
    public function getCapColorList() {
        $l = [
			'Red' => 'Red',
			'Orange' => 'Orange',
			'Yellow' => 'Yellow',
			'Green' => 'Green',
			'Blue' => 'Blue',
			'Purple' => 'Purple',
			'Pink' => 'Pink',
			'Brown' => 'Brown',
			'Black' => 'Black',
			'White' => 'White',
			'Grey' => 'Grey',
			'None' => 'None'
        ];
        return $l;
    }

    public function getBlastGenotypeList() {
        $l = [
            'Heterozygous (+/-)' => 'Heterozygous (+/-)',
            'Homozygous (-/-)' => 'Homozygous (-/-)',
            'Knock-In' => 'Knock-In',
            'Hemizygous' => 'Hemizygous',
            'Chimera' => 'Chimera',
            'tg/+' => 'tg/+',
            'Wildtype (+/+)' => 'Wildtype (+/+)',
            'Cre+' => 'Cre+',
            'Homo KO' => 'Homo KO',
            'Tg Homo KO' => 'Tg Homo KO'
        ];
        return $l;
    }


    public function getEcTestEmbryoStageList() {
        $l = [
            '2-cell' => '2-cell',
            '4-cell' => '4-cell',
            'Morula' => 'Morula',
            'Blast' => 'Blast'
        ];
        return $l;
    }

    public function getAnestheticList() {
        $l = [
            "Ketamine&Xylazine (10mg/ml&1mg/ml)" => "Ketamine&Xylazine (10mg/ml&1mg/ml)",
            // "Avertin 1.2%" => "Avertin 1.2%",
            "Isoflurane (%)" => "Isoflurane (%)",
            "Isoflurane (%)&Ketamine/Xylazine" => "Isoflurane (%)&Ketamine/Xylazine"
    	];
        return $l;
    }

    public function getAnalgesicList() {
        $l = [
            'Buprenex 0.03 mg/ml' => 'Buprenex 0.03 mg/ml'
        ];
        return $l;
    }

    public function getKompSourceList() {
        $l = [
			'UCD KOMP2' => 'UCD KOMP2',
			'Baylor KOMP2' => 'Baylor KOMP2',
			'Jax KOMP2' => 'Jax KOMP2',
			'KOMP/PI' => 'KOMP/PI',
			'KOMP312' => 'KOMP312',
			'KOMP MBP/PI' => 'KOMP MBP/PI',
			'MARC KOMP2' => 'MARC KOMP2',
			'Regeneron' => 'Regeneron',
			'Sanger MMRRC' => 'Sanger MMRRC',
			'Sanger EUMODIC' => 'Sanger EUMODIC',
			'Sanger KOMP1' => 'Sanger KOMP1',
			'Sanger BaSH' => 'Sanger BaSH',
			'Sanger BaSH-MMRRC' => 'Sanger BaSH-MMRRC',
			'Sanger MGP' => 'Sanger MGP',
			'Sanger BaSH-KOMP' => 'Sanger BaSH-KOMP',
			'TCP KOMP2' => 'TCP KOMP2'
        ];
        return $l;
    }  

    public function getAssistedIvfEmbryoList() {
        $l = [
            'MBCD/GSH IVF' => 'MBCD/GSH IVF', 
            'Rescue MBCD/GSH IVF' => 'Rescue MBCD/GSH IVF', 
            'Rescue IVF in MBCD' => 'Rescue IVF in MBCD', 
            'Laser IVF (0.25 M Sucrose)' => 'Laser IVF (0.25 M Sucrose)', 
            'Conventional IVF' => 'Conventional IVF', 
            'IVF and Laser' => 'IVF and Laser'
        ];
        return $l;
    }

    public function getPrimaryRechargeList() {
        $l = [
            'KP84' => 'KP84', 
            'CP94' => 'CP94', 
            'KP51' => 'KP51', 
            'KCLX' => 'KCLX', 
            'VMB6' => 'VMB6', 
            'VMB4' => 'VMB4', 
            'CRL2' => 'CRL2', 
            'MGS9' => 'MGS9', 
            'MM02' => 'MM02', 
            'MMGS' => 'MMGS', 
            'MMBG' => 'MMBG', 
            'KL62' => 'KL62', 
            'LLOYD' => 'LLOYD', 
            'KP88' => 'KP88', 
            'KOMP' => 'KOMP', 
            'BPA1' => 'BPA1', 
            'MR87' => 'MR87', 
            'MR77' => 'MR77'
        ];
        return $l;
    }

    public function getSecondaryRechargeList() {
        $l = [
            'CRL2' => 'CRL2', 
            'KP51' => 'KP51', 
            'MM02' => 'MM02'
        ];
        return $l;
    }

    public function getETPurposeList() {
        $l = [
            '8-cell Inj.' => '8-cell Inj.', 
            'BL ET' => 'BL ET', 
            'PN ET' => 'PN ET', 
            'CR ET' => 'CR ET', 
            'Embryo Resuscitation' => 'Embryo Resuscitation', 
            'Sperm Resuscitation' => 'Sperm Resuscitation', 
            'Strain Rederivation' => 'Strain Rederivation', 
            'Embryo Test Thaw QC' => 'Embryo Test Thaw QC', 
            'Sperm Test Thaw QC' => 'Sperm Test Thaw QC', 
            'ET Practice' => 'ET Practice', 
            'ICSI Practice' => 'ICSI Practice', 
            'Aggregation' => 'Aggregation', 
            'Research' => 'Research', 
            'Vasectomy' => 'Vasectomy'
        ];
        return $l;
    }

    public function getKOMPCellLineList() {
        $l = [
            'JM8 Strain C57BL/6N' => 'JM8 Strain C57BL/6N', 
            'JM8.N4 Strain C57BL/6N' => 'JM8.N4 Strain C57BL/6N', 
            'JM8.F6 Strain C57BL/6N' => 'JM8.F6 Strain C57BL/6N',
            'VGB6 Strain C57BL/6NTac' => 'VGB6 Strain C57BL/6NTac',          
            'C2' => 'C2',
            'Z_EG' => 'Z_EG',
            'Z_RED' => 'Z_RED',
            'LB10' => 'LB10',
            'G4 (4n)' => 'G4 (4n)',
            'JM8.N19 Strain C57BL/6N' => 'JM8.N19 Strain C57BL/6N',
            'AB2.2' => 'AB2.2',
            'JM8A (Agouti) Strain C57BL/6N-A<sup>tm1Brd</sup>' => 'JM8A (Agouti) Strain C57BL/6N-A<sup>tm1Brd</sup>',  
            'JM8B (Agouti) Strain C57BL/6N-A<sup>tm1Brd</sup>' => 'JM8B (Agouti) Strain C57BL/6N-A<sup>tm1Brd</sup>',
            'JM8.N3 Strain C57BL/6N' => 'JM8.N3 Strain C57BL/6N',
            'JM8A3.N1 Strain C57BL/6N-A<sup>tm1Brd</sup>' => 'JM8A3.N1 Strain C57BL/6N-A<sup>tm1Brd</sup>',
            'JM8A1.N3 Strain C57BL/6N-A<sup>tm1Brd</sup>' => 'JM8A1.N3 Strain C57BL/6N-A<sup>tm1Brd</sup>',
            'EAP1' => 'EAP1',
            'SNL 76/7' => 'SNL 76/7',
            'JM8A3 Strain C57BL/6N-A<sup>tm1Brd</sup>' => 'JM8A3 Strain C57BL/6N-A<sup>tm1Brd</sup>',
            'JM8A1 Strain C57BL/6N-A<sup>tm1Brd</sup>' => 'JM8A1 Strain C57BL/6N-A<sup>tm1Brd</sup>',
            'JM8A Strain C57BL/6N-A<sup>tm1Brd</sup>' => 'JM8A Strain C57BL/6N-A<sup>tm1Brd</sup>',
            'SI6.C21' => 'SI6.C21',
            'JM8A.N1 Strain C57BL/6N-A<sup>tm1Brd</sup>' => 'JM8A.N1 Strain C57BL/6N-A<sup>tm1Brd</sup>',
            'JM8A3.N1-C2 Strain C57BL/6N-A<sup>tm1Brd</sup>' => 'JM8A3.N1-C2 Strain C57BL/6N-A<sup>tm1Brd</sup>',
        ];
        return $l;
    }

    public function getKOMPContentTypeList() {
        $l = [
            'ES Cells' => 'ES Cells', 
            'Embryo' => 'Embryo', 
            'Sperm' => 'Sperm', 
            'DNA' => 'DNA', 
            'Mice' => 'Mice'
        ];
        return $l;
    }

    public function getKOMPLocationList() {
        $l = [
            'J1 CCM' => 'J1 CCM', 
            'to be installed' => 'to be installed', 
            'MBP' => 'MBP', 
            'M3' => 'M3'
        ];
        return $l;
    }

    public function getKOMPMicroinjectionTypeList() {
        $l = [
            'Blastocyst Injection' => 'Blastocyst Injection', 
            'Morular Injection' => 'Morular Injection', 
            'Morular Aggregation' => 'Morular Aggregation'
        ];
        return $l;
    }

    public function getKOMPPassList() {
        $l = [
            'fail (Score 0)' => 'fail (Score 0)', 
            'pass1 (Score 51)' => 'pass1 (Score 51)', 
            'pass2 (Score 51)' => 'pass2 (Score 51)', 
            'pass3 (Score 51)' => 'pass3 (Score 51)', 
            'pass1.1 (Score 51)' => 'pass1.1 (Score 51)', 
            'pass (Score 51)' => 'pass (Score 51)', 
            'pass2.1b (Score 51)' => 'pass2.1b (Score 51)', 
            'pass4 (Score 2)' => 'pass4 (Score 2)', 
            'pass5 (Score 6)' => 'pass5 (Score 6)', 
            'pass1a (Score 51)' => 'pass1a (Score 51)', 
            'pass2.1a (Score 51)' => 'pass2.1a (Score 51)', 
            'pass2.2a (Score 51)' => 'pass2.2a (Score 51)', 
            'pass2.3a (Score 51)' => 'pass2.3a (Score 51)', 
            'pass3a (Score 51)' => 'pass3a (Score 51)', 
            'pass4.1a (Score 20)' => 'pass4.1a (Score 20)',
            'pass5.2a (Score 8)' => 'pass5.2a (Score 8)',  
            'pass2.2 (Score 51)' => 'pass2.2 (Score 51)', 
            'pass3b (Score 51)' => 'pass3b (Score 51)', 
            'pass4.1 (Score 3)' => 'pass4.1 (Score 3)', 
            'pass4.1b (Score 4)' => 'pass4.1b (Score 4)', 
            'pass4.2a (Score 5)' => 'pass4.2a (Score 5)', 
            'passa (Score 52)' => 'passa (Score 52)', 
            'fail (wrong design) (Score 1)' => 'fail (wrong design) (Score 1)', 
            'pass5.1b (Score 7)' => 'pass5.1b (Score 7)', 
            'pass2.1 (Score 51)' => 'pass2.1 (Score 51)', 
            'pass2.2b (Score 51)' => 'pass2.2b (Score 51)',
            'pass5.1a (Score 7)' => 'pass5.1a (Score 7)',  
            'pass2.3 (Score 51)' => 'pass2.3 (Score 51)', 
            'pass5.2 (Score 8)' => 'pass5.2 (Score 8)', 
            'pass4.2 (Score 5)' => 'pass4.2 (Score 5)', 
            'pass4.2b (Score 5)' => 'pass4.2b (Score 5)',
            'pass2.3b (Score 51)' => 'pass2.3b (Score 51)',
            'pass5.3b (Score 7)' => 'pass5.3b (Score 7)',
            'pass5.3a (Score 7)' => 'pass5.3a (Score 7)',
            'warn_3arm_b (Score 1)' => 'warn_3arm_b (Score 1)',
            'fail_KAN (Score 1)' => 'fail_KAN (Score 1)',
            'passb (Score 51)' => 'passb (Score 51)',
            'failinvert loxp (Score 1)' => 'failinvert loxp (Score 1)',
            'Frame_fail (Score 1)' => 'Frame_fail (Score 1)',
            'warn_3arm_ (Score 1)' => 'warn_3arm_ (Score 1)',
            'pass6 (Score 6)' => 'pass6 (Score 6)',
            'fail/plate30 (Score 1)' => 'fail/plate30 (Score 1)',
            'pass7 (Score 7)' => 'pass7 (Score 7)',
            'pass5.3a (Score 7)' => 'pass5.3a (Score 7)',
            '3arm_warn (Score 1)' => '3arm_warn (Score 1)',
            'passs (Score 51)' => 'passs (Score 51)',
            'pass4.3 (Score 5)' => 'pass4.3 (Score 5)',
            'fail_contam (Score 1)' => 'fail_contam(Score 1)',
            'pass_lox (Score 51)' => 'pass_lox (Score 51)',
            'paasa (Score 51)' => 'paasa (Score 51)',
            'fail_nae (Score 1)' => 'fail_nae (Score 1)',
            'na (Score 1)' => 'na (Score 1)',
            'nd (Score 1)' => 'nd (Score 1)',
            'pass4.3d (Score 5)' => 'pass4.3d (Score 5)',
            'pass4.1d (Score 4)' => 'pass4.1d (Score 4)',
            'pass2.3d (Score 51)' => 'pass2.3d (Score 51)',
            'pass4.3b (Score 5)' => 'pass4.3b (Score 5)',
            'pass4.3a (Score 50)' => 'pass4.3a (Score 50)',
        ];
        return $l;
    }

    public function getKOMPQCResultList() {
        $l = [
            'Fail' => 'Fail', 
            'Pass' => 'Pass', 
            'Inconclusive' => 'Inconclusive', 
            'Pass-for-Shipment' => 'Pass-for-Shipment'
        ];
        return $l;
    }

    public function getKOMPQCSubprojectTestsList() {
        $l = [
            'fail' => 'fail', 
            'pass' => 'pass', 
            'inconclusive' => 'inconclusive', 
            'SA missing' => 'SA missing'
        ];
        return $l;
    }

    public function getKOMPVialContentList() {
        $l = [
            'ES Cells' => 'ES Cells', 
            'Embryos' => 'Embryos', 
            'Sperm' => 'Sperm', 
            'DNA' => 'DNA',
            'Mice' => 'Mice'
        ];
        return $l;
    }

    public function getKOMPSublibraryList() {
        $l = [
            'KOMP-CSD' => 'KOMP-CSD', 
            'KOMP-Vlcg' => 'KOMP-Vlcg', 
            'Parent Line' => 'Parent Line', 
            'Sanger' => 'Sanger',
            'MMRRC' => 'MMRRC',
            'NORCOMM' => 'NORCOMM',
            'TIGM' => 'TIGM',
            'Genentech' => 'Genentech',
            'EUCOMM' => 'EUCOMM'
        ];
        return $l;
    }

    public function getKOMPExpansionPurposeList() {
        $l = [
            'Injection Only' => 'Injection Only', 
            'Batch Release' => 'Batch Release', 
            'Pathogen Only' => 'Pathogen Only', 
            'K312' => 'K312'
        ];
        return $l;
    }

    public function getKOMPDistributeList() {
        $l = [
            'good for genotyping' => 'good for genotyping', 
            'Do Not Distribute' => 'Do Not Distribute', 
            'Distribute' => 'Distribute'
        ];
        return $l;
    }

}

