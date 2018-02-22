<div class="qcMicroinjections view large-9 medium-8 columns content">
    <h3><?= __('QcMicroinjection')." #".h($qcMicroinjection->id) ?></h3>
    <table class="table stripe order-column">
        <tr>
            <th><?= __('Comment') ?></th>
            <td><?= h($qcMicroinjection->comment) ?></td>
        </tr>
        <tr>
            <th><?= __('Bl') ?></th>
            <td><?= h($qcMicroinjection->bl) ?></td>
        </tr>
        <tr>
            <th><?= __('User') ?></th>
            <td><?= $qcMicroinjection->has('user') ? $this->Html->link($qcMicroinjection->user->name, ['controller' => 'Users', 'action' => 'view', $qcMicroinjection->user->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($qcMicroinjection->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Inventory Vial Id') ?></th>
            <td><?= $this->Number->format($qcMicroinjection->inventory_vial_id) ?></td>
        </tr>
        <tr>
            <th><?= __('Started By') ?></th>
            <td><?= $this->Number->format($qcMicroinjection->started_by) ?></td>
        </tr>
        <tr>
            <th><?= __('Finished By') ?></th>
            <td><?= $this->Number->format($qcMicroinjection->finished_by) ?></td>
        </tr>
        <tr>
            <th><?= __('Pass') ?></th>
            <td><?= $this->Number->format($qcMicroinjection->pass) ?></td>
        </tr>
        <tr>
            <th><?= __('Npups') ?></th>
            <td><?= $this->Number->format($qcMicroinjection->npups) ?></td>
        </tr>
        <tr>
            <th><?= __('Nmale') ?></th>
            <td><?= $this->Number->format($qcMicroinjection->nmale) ?></td>
        </tr>
        <tr>
            <th><?= __('Chimerism') ?></th>
            <td><?= $this->Number->format($qcMicroinjection->chimerism) ?></td>
        </tr>
        <tr>
            <th><?= __('Max Chimerism') ?></th>
            <td><?= $this->Number->format($qcMicroinjection->max_chimerism) ?></td>
        </tr>
        <tr>
            <th><?= __('Number Injected') ?></th>
            <td><?= $this->Number->format($qcMicroinjection->number_injected) ?></td>
        </tr>
        <tr>
            <th><?= __('Parent Strain') ?></th>
            <td><?= $this->Number->format($qcMicroinjection->parent_strain) ?></td>
        </tr>
        <tr>
            <th><?= __('Number Pups Born') ?></th>
            <td><?= $this->Number->format($qcMicroinjection->number_pups_born) ?></td>
        </tr>
        <tr>
            <th><?= __('Injection Type') ?></th>
            <td><?= $this->Number->format($qcMicroinjection->injection_type) ?></td>
        </tr>
        <tr>
            <th><?= __('Number Recipients') ?></th>
            <td><?= $this->Number->format($qcMicroinjection->number_recipients) ?></td>
        </tr>
        <tr>
            <th><?= __('Number Litters') ?></th>
            <td><?= $this->Number->format($qcMicroinjection->number_litters) ?></td>
        </tr>
        <tr>
            <th><?= __('Kompvialid') ?></th>
            <td><?= $this->Number->format($qcMicroinjection->kompvialid) ?></td>
        </tr>
        <tr>
            <th><?= __('Quality Control Id') ?></th>
            <td><?= $this->Number->format($qcMicroinjection->quality_control_id) ?></td>
        </tr>
        <tr>
            <th><?= __('Started') ?></th>
            <td><?= h($qcMicroinjection->started) ?></tr>
        </tr>
        <tr>
            <th><?= __('Finished') ?></th>
            <td><?= h($qcMicroinjection->finished) ?></tr>
        </tr>
        <tr>
            <th><?= __('Birthdate') ?></th>
            <td><?= h($qcMicroinjection->birthdate) ?></tr>
        </tr>
        <tr>
            <th><?= __('Modified') ?></th>
            <td><?= h($qcMicroinjection->modified) ?></tr>
        </tr>
        <tr>
            <th><?= __('Created') ?></th>
            <td><?= h($qcMicroinjection->created) ?></tr>
        </tr>
    </table>
</div>
