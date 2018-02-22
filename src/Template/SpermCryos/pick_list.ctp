<div class="spermCryos view large-9 medium-8 columns content">
	<div class='container-fluid'>
	    <form method="post">
	    	<div class='row'>
	   	        <div class='col-xs-4'><label for="strain_name">Strain Name: </label><input type="text" name="strain_name" id="strain-name"></div>
	   	        <div class='col-xs-2'><strong>-or-</strong></div>
		        <div class='col-xs-4'><label for="stock_number">Stock Number: </label><input type="text" name="stock_number" id="stock-number"></div>
			</div>
			<div class='row'>
				<div class='col-xs-1'></div>
		        <div class='col-xs-4'><input type="submit" value="Submit"></div>
			</div>
	    </form>
    </div>
	<?php if (!empty($stocks) || !empty($strains)) { ?>
	  <div class="panel panel-default horizontal-table">

	    <div class="panel-heading alert-info">
	      <h4 class="panel-title">
	          Sperm Cryos</span>
	      </h4>
	    </div>
	    <div class="panel">
            <table class="table stripe order-column">
                <tr>
                	<th></th>
                    <th><?= __('SC #') ?></th>
                    <th><?= __('Job ID') ?></th>
                    <th><?= __('Strain Name') ?></th>             
                    <th><?= __('Concentration') ?></th>
                    <th><?= __('Total Motility') ?></th>
                    <th><?= __('Prog Motility') ?></th>
                    <th><?= __('Rapid Motility') ?></th>
                    <th><?= __('Abn. Heads') ?></th>
                    <th><?= __('Abn. Tails') ?></th>  
                    <th><?= __('# of Vials') ?></th>  
                </tr>
                <?php if (!empty($stocks)) { foreach ($stocks as $stock){ ?>
                <tr>
                	<td><input id="<?php echo htmlspecialchars($stock[0]); ?>" type="checkbox"></td>
                    <td><?= h($stock[0]) ?></td>
                    <td><?= h($stock[1]) ?></td>
                    <td><?= h($stock[2]) ?></td>
                    <td><?= h($stock[3]) ?></td>
                    <td><?= h($stock[4]) ?></td>
                    <td><?= h($stock[5]) ?></td>
                    <td><?= h($stock[6]) ?></td>
                    <td><?= h($stock[7]) ?></td>
                    <td><?= h($stock[8]) ?></td>
                    <td><?= h($stock[9]) ?></td>
                </tr>
                <?php }} ?>
                <?php if (!empty($strains)) { foreach ($strains as $strain){ ?>
                <tr>
                	<td><input id="<?php echo htmlspecialchars($strain[0]); ?>" type="checkbox"></td>
                    <td><?= h($strain[0]) ?></td>
                    <td><?= h($strain[1]) ?></td>
                    <td><?= h($strain[2]) ?></td>
                    <td><?= h($strain[3]) ?></td>
                    <td><?= h($strain[4]) ?></td>
                    <td><?= h($strain[5]) ?></td>
                    <td><?= h($strain[6]) ?></td>
                    <td><?= h($strain[7]) ?></td>
                    <td><?= h($strain[8]) ?></td>
                    <td><?= h($strain[9]) ?></td>
                </tr>
                <?php }} ?>
            </table>
	    </div>
	  </div>
	<?php } else { ?>	
		<p style='color:red'><strong>No Results</strong></p>		
	<?php } ?>	
</div>
