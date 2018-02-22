<div class="users index large-9 medium-8 columns content">
    <h2><?= __('Cryomice') ?></h2>
    <hr/>
    <div id="spinner"><img src="/img/balls.gif"><br/><strong>Loading the view. Please wait...</strong></div>
	<div id="cryomiceTable"></div>
</div>

<script>
$( document ).ready(function() {
$.ajax({
  url: '/mosaic/get_cryomice_table',
  success: function(data) {
  		$("#spinner").hide();
    	$("#cryomiceTable").html(data);
    	$('.data-table').DataTable();
	}
});
});
</script>
<style>
#spinner {
	text-align:center;
}
</style>