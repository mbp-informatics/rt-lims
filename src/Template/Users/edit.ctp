<div class="users form large-9 medium-8 columns content">
    <?= $this->Form->create($user) ?>
    <fieldset>
        <legend><?= __('Edit User') ?></legend>
        <?php
            echo $this->Form->input('role_id', ['options' => $roles, 'empty' => true]);
            echo $this->Form->input('name');
            echo $this->Form->input('username');
            echo $this->Form->input('email');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Save')) ?>
    <?= $this->Form->end() ?>
</div>
