<?php
        echo $this->Html->link('<span class="glyphicon glyphicon-pencil"></span> ' . __('Edit Job Comment'), ['controller' => 'JobComments', 'action' => 'edit', $jobComment->id], array('escape' => false, 'class' => 'btn btn-warning pull-right'));
?>
<div class="jobComments view large-9 medium-8 columns content">
    <h3><?= __('JobComment')." #".h($jobComment->id) ?></h3>
    <table class="table stripe order-column">
        <tr>
            <th><?= __('Job') ?></th>
            <td><?= $jobComment->has('job') ? $this->Html->link($jobComment->job->id, ['controller' => 'Jobs', 'action' => 'view', $jobComment->job->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Created by') ?></th>
            <td><?= $jobComment->has('user') ? $this->Html->link($jobComment->user->name, ['controller' => 'Users', 'action' => 'view', $jobComment->user->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Comment ID') ?></th>
            <td><?= $this->Number->format($jobComment->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Created on') ?></th>
            <td><?= h($jobComment->created) ?></tr>
        </tr>
        <tr>
            <th><?= __('Modified on') ?></th>
            <td><?= h($jobComment->modified) ?></tr>
        </tr>
    </table>
  <div class="jumbotron" style="padding:20px;">
    <h4><?= __('Comment') ?></h4>
    <p><?= $this->Text->autoParagraph(h($jobComment->comment)); ?></p>
  </div>
<hr/>
    <?php
         echo $this->Html->link('' . __('Go back'), ['controller' => 'Jobs', 'action' => 'view', $jobComment->job_id], array(
                'escape' => false,
                'class' => 'btn btn-default',
                'style' => 'margin-left:10px'
        ));
?>
</div>


