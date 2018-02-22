<div class="contactsJobs view large-9 medium-8 columns content">
    <h3><?= __('ContactsJob')." #".h($contactsJob->id) ?></h3>
    <table class="table stripe order-column">
        <tr>
            <th><?= __('Job') ?></th>
            <td><?= $contactsJob->has('job') ? $this->Html->link($contactsJob->job->id, ['controller' => 'Jobs', 'action' => 'view', $contactsJob->job->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Contact') ?></th>
            <td><?= $contactsJob->has('contact') ? $this->Html->link($contactsJob->contact->id, ['controller' => 'Contacts', 'action' => 'view', $contactsJob->contact->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($contactsJob->id) ?></td>
        </tr>
    </table>
</div>
