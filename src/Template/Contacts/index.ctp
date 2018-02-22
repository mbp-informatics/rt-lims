<hr/>
    <?= $this->Html->link('<span class="glyphicon glyphicon-plus"></span> '.__('New Contact'), ['action' => 'add'], array('escape' => false, 'class' => 'btn btn-warning pad-button')) ?>
<hr/>
<div class="contacts index large-9 medium-8 columns content horizontal-table">
    <h3><?= __('Contacts') ?></h3>
    <table class="data-table table stripe order-column">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('id') ?></th>
                <th><?= $this->Paginator->sort('contact_type_id') ?></th>
                <th><?= $this->Paginator->sort('first_name') ?></th>
                <th><?= $this->Paginator->sort('last_name') ?></th>
                <th><?= $this->Paginator->sort('campus_company') ?></th>
                <th><?= $this->Paginator->sort('school') ?></th>
                <th><?= $this->Paginator->sort('email') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($Contacts as $contact): ?>
            <tr>
                <td><?= $this->Number->format($contact->id) ?></td>
                <td><?= $contact->has('contact_type') ? $this->Html->link($contact->contact_type->name, ['controller' => 'ContactTypes', 'action' => 'view', $contact->contact_type_id]) : '' ?></td>
                <td><?= h($contact->first_name) ?></td>
                <td><?= h($contact->last_name) ?></td>
                <td><?= h($contact->campus_company) ?></td>
                <td><?= h($contact->school) ?></td>
                <td><?= h($contact->email) ?>
                    <a href="mailto:<?= h($contact->email) ?>"><span class="glyphicon glyphicon-envelope"></span></a>
                </td>
                <td class="actions">
                    <?= '<span data-toggle="tooltip" title="View">'. $this->Html->link('<span class="pad-action-glyph glyphicon glyphicon-eye-open"></span>', ['action' => 'view', $contact->id],  array('escape' => false, 'class' => 'label label-primary action-pad')) . '</span>' ?>
                    <?= '<span data-toggle="tooltip" title="Edit">'. $this->Html->link('<span class="pad-action-glyph glyphicon glyphicon-pencil"></span>', ['action' => 'edit', $contact->id], array('escape' => false, 'class' => 'label label-success action-pad')) . '</span>' ?>
                    <?= '<span data-toggle="tooltip" title="Delete">'. $this->Form->postLink('<span class="pad-action-glyph glyphicon glyphicon glyphicon-trash"></span> ', ['action' => 'delete', $contact->id], ['escape' => false, 'class' => 'label label-danger action-pad', 'confirm' => __('Are you sure you want to delete # {0}?', $contact->id)]) . '</span>' ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
