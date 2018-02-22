
<div class="contacts view large-9 medium-8 columns content">
    <h3><?= __('Contact')." #".h($contact->id) ?>
    <?php
        echo $this->Html->link('<span class="glyphicon glyphicon-pencil"></span> ' . __('Edit Contact'), ['controller' => 'Contacts', 'action' => 'edit', $contact->id], array('escape' => false, 'class' => 'btn btn-warning pull-right'));
        ?>
    </h3>
    <table class="table stripe order-column">
        <tr>
            <th><?= __('Contact Type') ?></th>
            <td><?= $contact->has('contact_type') ? $this->Html->link($contact->contact_type->name, ['controller' => 'ContactTypes', 'action' => 'view', $contact->contact_type->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Name') ?></th>
            <td><?= h($contact->first_name . ' ' . $contact->last_name) ?></td>
        </tr>
        <tr>
            <th><?= __('Campus/Institution') ?></th>
            <td><?= h($contact->campus_company) ?></td>
        </tr>
        <tr>
            <th><?= __('Email') ?></th>
            <td><?= h($contact->email) ?></td>
        </tr>
        <tr>
            <th><?= __('Created') ?></th>
            <td><?= h($contact->created) ?></tr>
        </tr>
        <tr>
            <th><?= __('Modified') ?></th>
            <td><?= h($contact->modified) ?></tr>
        </tr>
    </table>
    <div class="related horizontal-table">
        <h4><?= __('Associated Jobs') ?></h4>
        <?php if (!empty($contact->jobs)): ?>
        <table class="data-table table stripe order-column">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Job Status</th>
                    <th>Strain</th>
                    <th>Background</th>
                    <th>MCRL Note</th>
                    <th>Membership</th>
                    <th>Created</th>
                    <th>Modified</th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <?php foreach ($contact->jobs as $jobs): ?>
            <tr>
                <td><?= h($jobs->id) ?></td>
                <td><?= $jobs->job_status ? __('<span class="bool-yes glyphicon glyphicon-ok"><strong>Open</strong></span>') : __('<span class="bool-no"><strong>Closed</strong></span>'); ?></td>
                <td><?= h($jobs->strain) ?></td>
                <td><?= h($jobs->background) ?></td>
                <td><?= h($jobs->mcrl_note) ?></td>
                <td><?= h($jobs->membership) ?></td>
                <td><?= h($jobs->created) ?></td>
                <td><?= h($jobs->modified) ?></td>
                <td class="actions">
                    <?= '<span data-toggle="tooltip" title="View">'. $this->Html->link('<span class="pad-action-glyph glyphicon glyphicon-eye-open"></span>', ['action' => 'view', 'controller' => 'jobs', $jobs->id],  array('escape' => false, 'class' => 'label label-primary action-pad')) . '</span>' ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
    </div>
</div>
