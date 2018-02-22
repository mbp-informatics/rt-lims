<div class="qcCreflips form large-9 medium-8 columns content">
    <?= $this->Form->create($qcCreflip) ?>
    <fieldset>
        <legend><?= __('Edit Qc Creflip') ?></legend>
        <?php
            echo $this->Form->input('vial_id');
            echo $this->Form->input('started', ['empty' => true, 'default' => '']);
            echo $this->Form->input('finished', ['empty' => true, 'default' => '']);
            echo $this->Form->input('started_by');
            echo $this->Form->input('finished_by');
            echo $this->Form->input('pass');
            echo $this->Form->input('comment');
            echo $this->Form->input('pcr1');
            echo $this->Form->input('southern1');
            echo $this->Form->input('northern1');
            echo $this->Form->input('electroporation1');
            echo $this->Form->input('pcr2');
            echo $this->Form->input('southern2');
            echo $this->Form->input('northern2');
            echo $this->Form->input('electroporation2');
            echo $this->Form->input('pcr3');
            echo $this->Form->input('southern3');
            echo $this->Form->input('northern3');
            echo $this->Form->input('user_id', ['options' => $users, 'empty' => true]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit'),
        array(
            'class' => 'btn btn-success',
            'div' => false
            )); ?>
    <?= $this->Form->end() ?>
</div>
