<div class="jobComments form large-9 medium-8 columns content">
    <?= $this->Form->create($jobComment) ?>
    <fieldset>
        <legend><?= __('Add Job Comment') ?></legend>
        <?php
             echo $this->Form->hidden('job_id', [
                'options' => $jobs,
                'empty' => false,
                'default' => $job_id[0],
                'label' => 'Job ID'
                ]);
            echo $this->Form->hidden('user_id', [
                'label' => 'Added by',
                'options' => $users,
                'empty' => false,
                'default' => $this->request->session()->read('Auth.User.id'),
                ]);
            echo $this->Form->input('comment');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit'),
        array(
            'class' => 'btn btn-success',
            'div' => false
            )); 
            ?>
    <?= $this->Form->end() ?>
</div>
