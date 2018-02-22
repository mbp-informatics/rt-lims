<div class="changeLog view large-9 medium-8 columns content">
    <h3><?= 'Saved old version of ' . h(Cake\Utility\Inflector::singularize($changeLog->table_alias).' (change id '. $changeLog->id . ' of '. $changeLog->change_date) ?></h3>
    <table class="table stripe order-column">
    <?php
    $data  = unserialize($changeLog->old_entity);
    foreach ($data as $fieldName=>$value) { ?>
        <tr>
            <th><?= __($fieldName) ?></th>
            <td><?= h($value) ?></td>
        </tr>
    <?php } ?>
    </table>
    <hr/>
    <h3>Later changed by</h3>
    <table class="table stripe order-column">
    <?php
    $data  = unserialize($changeLog->user_info);
    foreach ($data as $fieldName=>$value) { ?>
        <tr>
            <th><?= __($fieldName) ?></th>
            <td><?= h($value) ?></td>
        </tr>
    <?php } ?>
    </table>
</div>
