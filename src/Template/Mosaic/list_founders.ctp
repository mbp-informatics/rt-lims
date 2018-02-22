<div class="users index large-9 medium-8 columns content">
  <?php
  $colonyStr = $colony ? " ({$colony})" : '';
  ?>
    <h2><?= __("Founders{$colonyStr}") ?></h2>
    <hr/>

    <?php if(!$colony) { ?>
        <form id ="colony-form">
          <div class="row">
            <div class="col-lg-6">
              <div class="input-group">
                <input id="colony-input" type="text" class="form-control" placeholder="Enter colony name (e.g. CR10000)">
                <span class="input-group-btn">
                  <button class="btn btn-success" type="submit">Find Founders!</button>
                </span>
              </div><!-- /input-group -->
            </div><!-- /.col-lg-6 -->
          </div><!-- /.row -->
        </form>
        <hr/>
    <?php } ?>

    <div id="spinner"><img src="/img/balls.gif"><br/><strong>Loading the view. Please wait...</strong></div>
	<div id="foundersTable"></div>
</div>

<script>
$( document ).ready(function() {
    var colony = '<?= $colony ?>';
    if (colony.length > 0) {
      goAjax(colony);  
    } else {
      $('#colony-form').submit(function(e){
        e.preventDefault();
        var colony = $('#colony-input').val();
        goAjax(colony);  ;        
      })
    }

function goAjax(colony) {
  $("#foundersTable").html('');
  $("#spinner").show();
  $.ajax({
  url: '/mosaic/get_founders_table/'+colony,
    success: function(data) {
      $("#spinner").hide();
      $("#foundersTable").html(data);
    }
  });
}

});
</script>
<style>
#spinner {
	text-align:center;
  display:none;
}
</style>