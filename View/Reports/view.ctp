<div class="row">
  <div class="col-md-12">
	<h2><?php echo __('Report'); ?>
	  <small><?php echo h($display); ?></small>
	</h2>
  </div>
</div>
<div class="row">
  <div class="col-md-9">
	<div class="row">
	  <div class="col-md-12">
		<h3><?php echo __('Summary'); ?></h3>
		<div class="hidden-xs">
		  <table class="table table-striped">
			<thead>
			  <tr>
				<th><?php echo __('Name'); ?></th>
				<th><?php echo __('Description'); ?></th>
				<th><?php echo __('Amount'); ?></th>
			  </tr>
			</thead>
			<tbody>
			  <tr>
				<td><?php echo __('Balance'); ?></td>
				<td>
				  <?php echo __('Incomes'); ?>
				  <small><?php echo number_format($total[ACCOUNT_INCOME]); ?></small>
				  -
				  <?php echo __('Expenses'); ?>
				  <small><?php echo number_format($total[ACCOUNT_EXPENSE]); ?></small>
				</td>
				<td align="right">
				  <?php echo number_format($total[ACCOUNT_INCOME] - $total[ACCOUNT_EXPENSE]); ?>
				</td>
			  </tr>
			  <tr>
				<td><?php echo __('Net Assets'); ?></td>
				<td>
				  <?php echo __('Assets'); ?>
				  <small><?php echo number_format($total[ACCOUNT_ASSET]); ?></small>
				  -
				  <?php echo __('Liabilities'); ?>
				  <small><?php echo number_format($total[ACCOUNT_LIABILITY]); ?></small>
				</td>
				<td align="right">
				  <?php echo number_format($total[ACCOUNT_ASSET] - $total[ACCOUNT_LIABILITY]); ?>
				</td>
			  </tr>
			  <tr>
				<td><?php echo __('Equities'); ?></td>
				<td></td>
				<td align="right">
				  <?php echo number_format($total[ACCOUNT_EQUITY]); ?>
				</td>
			  </tr>
			</tbody>
		  </table>
		</div>
		<div class="visible-xs">
		  <ul class="list-group">
			<li class="list-group-item">
			  <span class="badge"><?php echo number_format($total[ACCOUNT_INCOME] - $total[ACCOUNT_EXPENSE]); ?></span>
			  <h4 class="list-group-item-heading"><?php echo __('Balance') ?></h4>
			  <p>
				<?php echo __('Incomes'); ?>
				<small><?php echo number_format($total[ACCOUNT_INCOME]); ?></small> -
				<?php echo __('Expenses'); ?>
				<small><?php echo number_format($total[ACCOUNT_EXPENSE]); ?></small>
			  </p>
			</li>
			<li class="list-group-item">
			  <span class="badge"><?php echo number_format($total[ACCOUNT_ASSET] - $total[ACCOUNT_LIABILITY]); ?></span>
			  <h4 class="list-group-item-heading"><?php echo __('Net Assets') ?></h4>
			  <p>
				<?php echo __('Assets'); ?>
				<small><?php echo number_format($total[ACCOUNT_ASSET]); ?></small> -
				<?php echo __('Liabilities'); ?>
				<small><?php echo number_format($total[ACCOUNT_LIABILITY]); ?></small>
			  </p>
			</li>
			<li class="list-group-item">
			  <span class="badge"><?php echo number_format($total[ACCOUNT_EQUITY]); ?></span>
			  <h4 class="list-group-item-heading"><?php echo __('Equities') ?></h4>
			</li>
		  </ul>
		</div>
	  </div>
	  <div class="col-md-12">
		<h3><?php echo __('Incomes'); ?></h3>
	  </div>
	  <div class="col-md-6">
		<table class="table table-striped">
		  <thead>
			<tr>
			  <th><?php echo __('Name'); ?></th>
			  <th><?php echo __('Amount'); ?></th>
			</tr>
		  </thead>
		  <tbody>
			<?php foreach ($data[ACCOUNT_INCOME] as $x): ?>
			<tr>
			  <td><?php echo $x[0]; ?></td>
			  <td align="right"><?php echo number_format($x[1]); ?></td>
			</tr>
			<?php endforeach; ?>
			<tr class="info">
			  <td><strong><?php echo __('Total'); ?></strong></td>
			  <td align="right"><strong><?php echo number_format($total[ACCOUNT_INCOME]); ?></strong></td>
			</tr>
		  </tbody>
		</table>
	  </div>
	  <div class="col-md-6">
		<div id="chart_incomes" style="width: 100%"></div>
	  </div>
	</div>
	<div class="row">
	  <div class="col-md-12">
		<h3><?php echo __('Expenses'); ?></h3>
	  </div>
	  <div class="col-md-6">
		<table class="table table-striped">
		  <thead>
			<tr>
			  <th><?php echo __('Name'); ?></th>
			  <th><?php echo __('Amount'); ?></th>
			</tr>
		  </thead>
		  <tbody>
			<?php foreach ($data[ACCOUNT_EXPENSE] as $x): ?>
			<tr>
			  <td><?php echo $x[0]; ?></td>
			  <td align="right"><?php echo number_format($x[1]); ?></td>
			</tr>
			<?php endforeach; ?>
			<tr class="info">
			  <td><strong><?php echo __('Total'); ?></strong></td>
			  <td align="right"><strong><?php echo number_format($total[ACCOUNT_EXPENSE]); ?></strong></td>
			</tr>
		  </tbody>
		</table>
	  </div>
	  <div class="col-md-6">
		<div id="chart_expenses" style="width: 100%"></div>
	  </div>
	</div>
	<div class="row">
	  <div class="col-md-12">
		<h3><?php echo __('Assets'); ?></h3>
	  </div>
	  <div class="col-md-6">
		<table class="table table-striped">
		  <thead>
			<tr>
			  <th><?php echo __('Name'); ?></th>
			  <th><?php echo __('Amount'); ?></th>
			</tr>
		  </thead>
		  <tbody>
			<?php foreach ($data[ACCOUNT_ASSET] as $x): ?>
			<tr>
			  <td><?php echo $x[0]; ?></td>
			  <td align="right"><?php echo number_format($x[1]); ?></td>
			</tr>
			<?php endforeach; ?>
			<tr class="info">
			  <td><strong><?php echo __('Total'); ?></strong></td>
			  <td align="right"><strong><?php echo number_format($total[ACCOUNT_ASSET]); ?></strong></td>
			</tr>
		  </tbody>
		</table>
	  </div>
	  <div class="col-md-6">
		<div id="chart_assets" style="width: 100%"></div>
	  </div>
	</div>
	<div class="row">
	  <div class="col-md-12">
		<h3><?php echo __('Liabilities'); ?></h3>
	  </div>
	  <div class="col-md-6">
		<table class="table table-striped">
		  <thead>
			<tr>
			  <th><?php echo __('Name'); ?></th>
			  <th><?php echo __('Amount'); ?></th>
			</tr>
		  </thead>
		  <tbody>
			<?php foreach ($data[ACCOUNT_LIABILITY] as $x): ?>
			<tr>
			  <td><?php echo $x[0]; ?></td>
			  <td align="right"><?php echo number_format($x[1]); ?></td>
			</tr>
			<?php endforeach; ?>
			<tr class="info">
			  <td><strong><?php echo __('Total'); ?></strong></td>
			  <td align="right"><strong><?php echo number_format($total[ACCOUNT_LIABILITY]); ?></strong></td>
			</tr>
		  </tbody>
		</table>
	  </div>
	  <div class="col-md-6">
		<div id="chart_liabilities" style="width: 100%"></div>
	  </div>
	</div>
	<div class="row">
	  <div class="col-md-12">
		<h3><?php echo __('Equities'); ?></h3>
	  </div>
	  <div class="col-md-6">
		<table class="table table-striped">
		  <thead>
			<tr>
			  <th><?php echo __('Name'); ?></th>
			  <th><?php echo __('Amount'); ?></th>
			</tr>
		  </thead>
		  <tbody>
			<?php foreach ($data[ACCOUNT_EQUITY] as $x): ?>
			<tr>
			  <td><?php echo $x[0]; ?></td>
			  <td align="right"><?php echo number_format($x[1]); ?></td>
			</tr>
			<?php endforeach; ?>
			<tr class="info">
			  <td><strong><?php echo __('Total'); ?></strong></td>
			  <td align="right"><strong><?php echo number_format($total[ACCOUNT_EQUITY]); ?></strong></td>
			</tr>
		  </tbody>
		</table>
	  </div>
	  <div class="col-md-6">
		<div id="chart_equities" style="width: 100%"></div>
	  </div>
	</div>
  </div>
  <div class="col-md-3">
	<div class="list-group">
	  <?php echo $this->Html->link($this->element('glyphicon', array('name' => 'th')) . ' ' . __('List Reports'), array('action' => 'index'), array('class' => 'list-group-item', 'escape' => false)); ?>
	  <?php if (isset($next)) echo $this->Html->link($this->element('glyphicon', array('name' => 'chevron-right')) . ' ' . __('Next'), array($format, $next), array('class' => 'list-group-item', 'escape' => false)); ?>
	  <?php if (isset($prev)) echo $this->Html->link($this->element('glyphicon', array('name' => 'chevron-left')) . ' ' . __('Previous'), array($format, $prev), array('class' => 'list-group-item', 'escape' => false)); ?>
	</div>
  </div>
</div>

<?php echo $this->Html->script('https://www.google.com/jsapi'); ?>
<?php $this->Html->scriptBlock($this->element('piechart', array('id' => 'chart_incomes', 'data' => $data[ACCOUNT_INCOME])), array('inline' => false)); ?>
<?php $this->Html->scriptBlock($this->element('piechart', array('id' => 'chart_expenses', 'data' => $data[ACCOUNT_EXPENSE])), array('inline' => false)); ?>
<?php $this->Html->scriptBlock($this->element('piechart', array('id' => 'chart_assets', 'data' => $data[ACCOUNT_ASSET])), array('inline' => false)); ?>
<?php $this->Html->scriptBlock($this->element('piechart', array('id' => 'chart_liabilities', 'data' => $data[ACCOUNT_LIABILITY])), array('inline' => false)); ?>
<?php $this->Html->scriptBlock($this->element('piechart', array('id' => 'chart_equities', 'data' => $data[ACCOUNT_EQUITY])), array('inline' => false)); ?>
