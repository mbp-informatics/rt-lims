<?php
/**
  * @var \App\View\AppView $this
  */
?>
<div class="errors view large-9 medium-8 columns content">
    <h3><?= h($error->id) ?></h3>
    <table class="table stripe order-column">
        <tr>
            <th scope="row"><?= __('Error Type') ?></th>
            <td><?= h($error->error_type) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Error') ?></th>
            <td><?= h($error->error) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('User') ?></th>
            <td><?= $error->has('user') ? $this->Html->link($error->user->name, ['controller' => 'Users', 'action' => 'view', $error->user->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($error->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($error->id) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('This Object Dump Json') ?></h4>
        <?php
            echo "<pre>";
            print_r( json_decode($error->this_object_dump_json) );
        ?>
    </div>
</div>
