<script>
$( document ).ready( function() {
    $('#add-job-comment-button').click(function(event) {
        event.preventDefault();
        var userComment = $('#commentInput').val();
        var commentId = $( "#dialog-add-job-comment" ).data('commentId');
        tableSelector = '#jobComments';
        idPrefix = 'jobComment-';
        tdClass = 'jobComments';
        dialogId = 'dialog-add-job-comment'
        if (userComment) {
            populateRow(dialogId, tableSelector, idPrefix, tdClass, userComment);
        }
    });
    if (typeof startConfirmExit == 'function') { startConfirmExit(); }
});
</script>
<div class="jobComments form large-9 medium-8 columns content">
    <?= $this->Form->create($jobComment, ['id'=>'add-job-comment-form']) ?>
    <fieldset>
        <legend><?= __('Add Job Comment') ?></legend>
        <?php
            echo $this->Form->input('comment', ['id' => 'commentInput']);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit'),
        array(
            'class' => 'btn btn-success',
            'div' => false,
            'id' => 'add-job-comment-button'
            )); 
            ?>
    <?= $this->Form->end() ?>
</div>
