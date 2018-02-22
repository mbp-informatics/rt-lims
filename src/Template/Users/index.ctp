<hr/>
<?php
        echo $this->Html->link('<span class="glyphicon glyphicon-plus"></span> ' .__('New User'), ['action' => 'add'] , array('escape' => false, 'class' => 'btn btn-warning pad-button'));
        echo $this->Html->link('<span class="glyphicon glyphicon-list-alt"></span> ' .__('List Roles'), ['controller' => 'Roles', 'action' => 'index'], array('escape' => false, 'class' => 'btn btn-warning pad-button'));
?>
<hr/>
<div class="users index large-9 medium-8 columns content">
    <h3><?= __('Users') ?></h3>
    <table class="data-table table stripe order-column">
        <thead>
            <tr>
                <th>ID</th>
                <th>Role</th>
                <th>Name</th>
                <th>Username</th>
                <th>Email</th>
                <th>Created</th>
                <th>Modified</th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
            <tr>
                <td><?= $this->Number->format($user->id) ?></td>
                <td><?= $user->has('role') ? $this->Html->link($user->role->name, ['controller' => 'Roles', 'action' => 'view', $user->role->id]) : '' ?></td>
                <td><?= h($user->name) ?></td>
                <td><?= h($user->username) ?></td>
                <td><?= h($user->email) ?></td>
                <td><?= h($user->created) ?></td>
                <td><?= h($user->modified) ?></td>
                <td class="actions">
                <?php
                echo '<span data-toggle="tooltip" title="View">' . $this->Html->link('<span class="pad-action-glyph glyphicon glyphicon-eye-open"></span>', ['action' => 'view', $user->id], array('escape' => false, 'class' => 'label label-primary action-pad')) . '</span>';
                echo '<span data-toggle="tooltip" title="Edit">' . $this->Html->link('<span class="pad-action-glyph glyphicon glyphicon-pencil"></span>', ['action' => 'edit', $user->id], array('escape' => false, 'class' => 'label label-success action-pad')) . '</span>';
                echo '<span data-toggle="tooltip" title="Delete">' . $this->Form->postLink('<span class="pad-action-glyph glyphicon glyphicon glyphicon-trash"></span> ',
                                ['action' => 'delete', $user->id],
                                array(
                                    'escape' => false,
                                    'class' => 'label label-danger action-pad',
                                    'confirm' => __('Are you sure you want to delete # {0}?', $user->id)
                                )) . '</span>';
                ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
