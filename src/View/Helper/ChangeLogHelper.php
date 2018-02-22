<?php
namespace App\View\Helper;

use Cake\View\Helper;
use Cake\ORM\TableRegistry;

class ChangeLogHelper extends Helper
{
  /**
  * Produces an HTML table with change log 
  *
  * @param array Data set containing changes, produced by getAssocChangeLog()['tableName'] in the ChangeLog component.
  * @return string An HTML string with tables showing changes.
  */
  public function showChanges($entries) {
    $html = '';
    foreach ($entries as $entry) {
        
        if (!$entry->deletion) {
            $idString = "<a target='_BLANK' href='/{$entry->table_alias}/view/{$entry->entity_id}'>{$entry->entity_id} <small><span class='glyphicon glyphicon-link dark-gray'></span></small></a>";
        } else {
            $idString = $entry->entity_id;    
        }

        $html .= "
            <tr>
            <td><strong>{$entry->table_alias}</strong></td>
            <td>{$idString}</td>
            <td>
        ";

        if (isset($entry->changes)) {
            $data = unserialize($entry->changes);
            foreach ($data as $fieldName=>$values) {
                $html .= "<strong>". $fieldName . "</strong><hr/>";
            }
        }

        $html .= "</td><td>";

        if (isset($data) && isset($entry->changes)) {
            foreach ($data as $fieldName=>$values) {
                $oldVal = $values['old_value'];
                if (is_array($oldVal)) {
                    $oldVal = $oldVal[key($oldVal)] ;
                }
                $oldVal = str_replace(' 00:00:00', '', $oldVal);
                $html .= $oldVal ? $oldVal : '-';
                $html .= "<hr/>";
            }
        }

        $html .= "</td><td>";

        if (isset($data) && isset($entry->changes)) {
            foreach ($data as $fieldName=>$values) { 
                $newVal = $values['new_value'];
                if (is_array($newVal) && !empty($newVal)) {
                    $newVal = $newVal[key($newVal)] ;
                }
                $newVal = str_replace(' 00:00:00', '', $newVal);
                $html .= $newVal ? $newVal : '-';
                $html .= "<hr/>";
            }
        }
        $userInfo = unserialize($entry->user_info);
        $html .= '<td>';
        $html .= $userInfo['username'].' <span data-toggle="tooltip" title="id:'.$userInfo['id'].', email:'.$userInfo['email'].', role: '.$userInfo['role'].'"><span class="glyphicon glyphicon-question-sign" style="cursor:pointer; color:gray"></span></span>';
        $html .= "</td><td>";
        $html .= h($entry->change_date);
        $html .= "</td><td>";
        $html .= isset($entry->deletion) ? '<small><span style="color:red;"><strong>Entry deleted</strong></span></small>':'';
        $html .= "</td><td>";
        $html .= isset($entry->addition) ? '<small><span style="color:green;"><strong>Entry added</strong></span></small>':'';
        $html .= "</td><td>";
        $html .= "<span data-toggle='tooltip' title='View old version'><a href='/change-log/view/{$entry->id}' class='label label-primary action-pad'><span class='pad-action-glyph glyphicon glyphicon-eye-open'></span></a></span>"; 
        $html .= "</td></tr>";

    } //end foreach
    return $html;
  }

    public function displayChangeLog($changes){

        $ret = 
        "
        <script>
        $(document).ready(function() {
            $('.change-log').DataTable( {
                'paging':   false,
                'searching': false,
                'info':     false
            } );
        });
        </script>
        <hr/ style='border-top:4px grey solid; margin-top:80px'>
        <div class='panel panel-default horizontal-table' id='change-log-wrapper'>
        <span class='accord-head collapsed accord-head' data-toggle='collapse' data-parent='#accordion' href='#collapseSix' aria-expanded='false' aria-controls='collapseSix'>
            <div class='panel-heading alert-warning' role='tab' id='headingSix'>
                <h4 class='panel-title'>
                    Change log Report <span class='caret'></span>
                </h4>
            </div>
        </span>
        <div id='collapseSix' class='panel-collapse collapse role='tabpanel' aria-labelledby='headingSix'>
            <div class='changeLog index large-9 medium-8 columns content'>
              <h3><span class='glyphicon glyphicon-list-alt'></span> Change Log</h3>
        <table class='change-log table stripe order-column'>
            <thead>
                <tr class='info'>
                    <th>Entity</th>
                    <th>Entry&nbsp;ID</th>
                    <th>Field</th>
                    <th>Old&nbsp;value</th>
                    <th>New&nbsp;value</th>
                    <th>Changed by</th>
                    <th>Change&nbsp;date</th>
                    <th>Deletion?</th>
                    <th>Addition?</th>
                    <th class='actions'>Actions</th>
                </tr>
            </thead>
            <tbody>";

            foreach ($changes as $tablename => $entries) {
                    if (!empty($entries)) {
                        $ret .= $this->showChanges($entries);
                    }
            }

            $ret .= "
            </tbody>
            </table>
            </div>
            </div>
            </div>";
            return $ret;
    }

}

   