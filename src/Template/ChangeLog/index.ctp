<style>
td {
    vertical-align: top !important;
}
</style>
<hr/>
<div class="changeLog index large-9 medium-8 columns content">
    <h3>Change Log</h3>


    <table class="data-table table stripe order-column">
        <thead>
            <tr>
                <th>Table</th>
                <th>Entry ID</th>
                <th>Field</th>
                <th>Old value</th>
                <th>New value</th>
                <th>Changed by</th>
                <th>Change date</th>
                <th>Deletion?</th>
                <th class="actions">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($changeLog as $entry): ?>
            <tr>
                <td><?= h($entry->table_alias) ?></td>
                <td>id:<?= $this->Number->format($entry->entity_id) ?></td>
                <td>
                <?php
                if (isset($entry->changes)) {
                    $data = unserialize($entry->changes);
                    foreach ($data as $fieldName=>$values) {
                        echo "<strong>". $fieldName . "</strong><hr/>";
                    }
                }
                ?>
                </td>
                <td>
                <?php
                if (isset($data)) {
                    foreach ($data as $fieldName=>$values) { 
                        $oldVal = $values['old_value'];
                        if (is_array($oldVal)) {
                            $oldVal = $oldVal[key($oldVal)] ;
                        }
                        $oldVal = str_replace(' 00:00:00', '', $oldVal);
                        echo $oldVal ? $oldVal : '-';
                        echo "<hr/>";
                    }
                }
                ?>
                </td>
                <td>
                <?php
                if (isset($data)) {
                    foreach ($data as $fieldName=>$values) { 
                        $newVal = $values['new_value'];
                        if (is_array($newVal)) {
                            $newVal = isset($newVal[key($newVal)]) ?  $newVal[key($newVal)] : '-';
                        }
                        $newVal = str_replace(' 00:00:00', '', $newVal);
                        echo $newVal ? $newVal : '-';
                        echo "<hr/>";
                    }
                }
                ?>
                <td style="text-align:center;"><?php 
                $userInfo = unserialize($entry->user_info);
                echo '<strong>'.$userInfo['username'].'</strong><br/>' . $userInfo['email'] .'<br/>';
                echo 'Role: '. $userInfo['role'] . '<br/>Id: ' . $userInfo['id']
                ?></td>
                <td><?= h($entry->change_date) ?></td>
                <td><?= isset($entry->deletion) ? '<span style="color:red;">Entry deleted</span>':'' ?></td>
                <td class="actions">
                    <?= '<span data-toggle="tooltip" title="View old version">'. $this->Html->link('<span class="pad-action-glyph glyphicon glyphicon-eye-open"></span>', ['action' => 'view', $entry->id],  array('escape' => false, 'class' => 'label label-primary action-pad')) . '</span>' ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
