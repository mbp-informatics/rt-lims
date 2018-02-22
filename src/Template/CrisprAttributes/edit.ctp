<?= $this->Html->script('crispr-design.js')?>
<div class="crisprAttributes form large-9 medium-8 columns content">
    <?= $this->Form->create($crisprAttribute) ?>
    <fieldset>
     <?php $currentCrisprDesignId = $crisprAttribute['crispr_design_id']; ?>
        <legend><?= __('Edit attribute of Crispr design# ') ?><?= $currentCrisprDesignId ?></legend>
         <?php
            echo $this->Form->hidden('crispr_design_id', ['options' => $crisprDesigns, 'empty' => true, 'default' => $currentCrisprDesignId]); ?>
            <div class="form-group text">
                  <label class="control-label" for="recharge">Sequence <img id="spinner" style="display:none;" src="/img/ajax-loader.gif"></label>
                  <select name="sequence" id="seq" class="form-control" placeholder="Enter gRNA sequence (20 characters)" required="required" />
                    <option value="<?= $crisprAttribute["sequence"] ?>" seleted><?= $crisprAttribute["sequence"] ?></option>
                    </select>
            </div>
        <?php
            echo $this->Form->input('chromosome');
            echo $this->Form->input('chr_start');
            echo $this->Form->input('chr_end');
        ?>
    </fieldset>
       <?= $this->Form->button(__('Save'),
        array(
        'class' => 'btn btn-success pad-button',
        'div' => false
        ));
         echo $this->Html->link('' . __('Go back'), ['controller' => 'CrisprDesigns', 'action' => 'view', $currentCrisprDesignId], array(
        'escape' => false,
        'class' => 'btn btn-default pad-button'
    ));?>
    <?= $this->Form->end() ?>
</div>
