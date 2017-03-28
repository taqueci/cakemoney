<?php
/**
  * @var \App\View\AppView $this
  */

use Cake\Core\Configure;
?>
<div class="row">
  <div class="col-md-12">
	<h2><?= __('Report') ?></h2>
  </div>
</div>
<div class="row">
  <div class="col-md-9">
	<div class="visible-xs">
	  <div class="row">
		<div class="col-md-12">
		  <div class="has-margin-bottom" align="right">
			<div class="btn-group" role="group" aria-label="Page navigation">
			  <?= $this->Html->link('<i class="fa fa-arrow-left" aria-hidden="true"></i>', ['?' => ['s' => $page['prev']['start'], 'e' => $page['prev']['end']]], ['class' => 'btn btn-default btn-sm', 'escape' => false]) ?>
			  <?= $this->Html->link('<i class="fa fa-arrow-right" aria-hidden="true"></i>', ['?' => ['s' => $page['next']['start'], 'e' => $page['next']['end']]], ['class' => 'btn btn-default btn-sm', 'escape' => false]) ?>
			</div>
		  </div>
		</div>
	  </div>
	</div>
	<div class="row">
	  <div class="col-md-12">
		<legend><?= h($start) ?> &ndash; <?= h($end) ?></legend>
	  </div>
	</div>
	<div class="row">
	  <div class="col-md-4">
		<h3><?= __('Summary') ?></h3>
		<h4><?= __('Balance') ?></h4>
		<table>
		  <tr>
			<td align="center"><small><span class="label label-default"><?= __('Incomings') ?></span></small></td>
			<td>&emsp;&emsp;</td>
			<td align="center"><small><span class="label label-default"><?= __('Outgoings') ?></span></small></td>
			<td>&emsp;&emsp;</td>
			<td align="center"><small><span class="label label-default"><?= __('Balance') ?></span></small></td>
		  </tr>
		  <tr>
			<td align="center"><span class="font-large"><?= number_format($sum->income) ?></span></td>
			<td align="center"><tt>-</tt></td>
			<td align="center"><span class="font-large"><?= number_format($sum->expense) ?></span></td>
			<td align="center"><tt>=</tt></td>
			<td align="center"><span class="font-xlarge"><?= $this->element('Format/numberWithStatus', ['value' => $sum->income - $sum->expense]) ?></span></td>
		  </tr>
		</table>
		<h4><?= __('Net Assets') ?></h4>
		<table>
		  <tr>
			<td align="center"><small><span class="label label-default"><?= __('Assets') ?></span></small></td>
			<td>&emsp;&emsp;</td>
			<td align="center"><small><span class="label label-default"><?= __('Liabilities') ?></span></small></td>
			<td>&emsp;&emsp;</td>
			<td align="center"><small><span class="label label-default"><?= __('Net Assets') ?></span></small></td>
		  </tr>
		  <tr>
			<td align="center"><span class="font-large"><?= number_format($sum->asset) ?></span></td>
			<td align="center"><tt>-</tt></td>
			<td align="center"><span class="font-large"><?= number_format($sum->liability) ?></span></td>
			<td align="center"><tt>=</tt></td>
			<td align="center"><span class="font-xlarge"><?= $this->element('Format/numberWithStatus', ['value' => $sum->asset - $sum->liability]) ?></span></td>
		  </tr>
		</table>
		<h4><?= __('Equities') ?></h4>
		<table>
		  <tr>
			<td align="center"><small><span class="label label-default"><?= __('Equities') ?></span></small></td>
		  </tr>
		  <tr>
			<td align="center"><span class="font-xlarge"><?= number_format($sum->equity) ?></span></td>
		  </tr>
		</table>
	  </div>
	  <div class="col-md-4">
		<h3><?= __('Incomings') ?></h3>
		<div align="right">
		  <div class="btn-group" role="group" aria-label="Page navigation">
			<button id="incomings-btn-chart" class="btn btn-default btn-sm" type="button">
			  <i class="fa fa-pie-chart" aria-hidden="true"></i>
			</button>
			<button id="incomings-btn-table" class="btn btn-default btn-sm" type="button">
			  <i class="fa fa-table" aria-hidden="true"></i>
			</button>
		  </div>
		</div>
		<div id="incomings-chart">
		  <canvas id="incomings-canvas" width="400" height="400"></canvas>
		</div>
		<div id="incomings-table">
		  <table class="table table-striped">
			<thead>
			  <tr>
				<th><?= __('Category') ?></th>
				<th><?= __('Amount') ?></th>
				<th><?= __('Ratio') ?></th>
				<th><i class="fa fa-ellipsis-h" aria-hidden="true"></i></th>
			  </tr>
			</thead>
			<tbody>
			  <?php foreach ($income as $x): ?>
			  <tr>
				<td><?= h($x->name) ?></td>
				<td align="right"><?= number_format($x->sum) ?></td>
				<td align="right"><?= sprintf('%.1f %%', 100 * $x->sum / $sum->income) ?></td>
				<td>
				  <?= $this->Html->link('<i class="fa fa-list" aria-hidden="true"></i>', ['controller' => 'journals', 'action' => 'index', '?' => ['s' => $start, 'e' => $end, 'c[]' => $x->credit_id]], ['escape' => false]) ?>
				</td>
			  </tr>
			  <?php endforeach; ?>
			</tbody>
		  </table>
		</div>
	  </div>
	  <div class="col-md-4">
		<h3><?= __('Outgoings') ?></h3>
		<div align="right">
		  <div class="btn-group" role="group" aria-label="Page navigation">
			<button id="outgoings-btn-chart" class="btn btn-default btn-sm" type="button">
			  <i class="fa fa-pie-chart" aria-hidden="true"></i>
			</button>
			<button id="outgoings-btn-table" class="btn btn-default btn-sm" type="button">
			  <i class="fa fa-table" aria-hidden="true"></i>
			</button>
		  </div>
		</div>
		<div id="outgogins-chart">
		  <canvas id="outgoings-canvas" width="400" height="400"></canvas>
		</div>
		<div id="outgogins-table">
		  <table class="table table-striped">
			<thead>
			  <tr>
				<th><?= __('Category') ?></th>
				<th><?= __('Amount') ?></th>
				<th><?= __('Ratio') ?></th>
				<th><i class="fa fa-ellipsis-h" aria-hidden="true"></i></th>
			  </tr>
			</thead>
			<tbody>
			  <?php foreach ($expense as $x): ?>
			  <tr>
				<td><?= h($x->name) ?></td>
				<td align="right"><?= number_format($x->sum) ?></td>
				<td align="right"><?= sprintf('%.1f %%', 100 * $x->sum / $sum->expense) ?></td>
				<td>
				  <?= $this->Html->link('<i class="fa fa-list" aria-hidden="true"></i>', ['controller' => 'journals', 'action' => 'index', '?' => ['s' => $start, 'e' => $end, 'd[]' => $x->debit_id]], ['escape' => false]) ?>
				</td>
			  </tr>
			  <?php endforeach; ?>
			</tbody>
		  </table>
		</div>
	  </div>
	</div>
	<div class="row">
	  <div class="col-md-12 has-margin-bottom">
		<h3><?= __('Chart') ?></h3>
		<div align="right">
		  <div id="chart-sel" class="btn-group btn-group-sm" role="group" aria-label="Chart selector">
			<button id="chart-btn-y" type="button" class="btn btn-default"><?= __('Year') ?></button>
			<button id="chart-btn-m" type="button" class="btn btn-default"><?= __('Month') ?></button>
			<button id="chart-btn-w" type="button" class="btn btn-default"><?= __('Week') ?></button>
			<button id="chart-btn-d" type="button" class="btn btn-default"><?= __('Day') ?></button>
		  </div>
		</div>
		<div id="chart-canvas">
		  <canvas id="chart-canvas-y" width="400" height="15"></canvas>
		  <canvas id="chart-canvas-m" width="400" height="15"></canvas>
		  <canvas id="chart-canvas-w" width="400" height="15"></canvas>
		  <canvas id="chart-canvas-d" width="400" height="15"></canvas>
		</div>
	  </div>
	</div>
  </div>
  <div class="col-md-3">
	<div class="list-group">
		<?= $this->Html->link('<i class="fa fa-arrow-right" aria-hidden="true"></i> ' . __('Next Report'), ['?' => ['s' => $page['next']['start'], 'e' => $page['next']['end']]], ['class' => 'list-group-item', 'escape' => false]) ?>
		<?= $this->Html->link('<i class="fa fa-arrow-left" aria-hidden="true"></i> ' . __('Previous Report'), ['?' => ['s' => $page['prev']['start'], 'e' => $page['prev']['end']]], ['class' => 'list-group-item', 'escape' => false]) ?>
		<?= $this->Html->link('<i class="fa fa-list" aria-hidden="true"></i> ' . __('Related Journals'), ['controller' => 'journals', 'action' => 'index', '?' => ['s' => $start, 'e' => $end]], ['class' => 'list-group-item', 'escape' => false]) ?>
	</div>
	<div class="list-group">
		<?= $this->Html->link('<i class="fa fa-list-ol" aria-hidden="true"></i> ' . __('List Reports'), ['controller' => 'reports', 'action' => 'index'], ['class' => 'list-group-item', 'escape' => false]) ?>
	  <?= $this->Html->link('<i class="fa fa-list" aria-hidden="true"></i> ' . __('List Journals'), ['controller' => 'journals', 'action' => 'index'], ['class' => 'list-group-item', 'escape' => false]) ?>
		<?= $this->Html->link('<i class="fa fa-plus" aria-hidden="true"></i> ' . __('New Journal'), ['controller' => 'journals', 'action' => 'add'], ['class' => 'list-group-item', 'escape' => false]) ?>
	</div>
	<div class="well">
	  <?= $this->Form->create(null, ['id' => 'form-date', 'type' => 'get']) ?>
	  <div class="form-group">
		<label for="s"><?= __('Scope') ?></label>
		<div class="input-daterange input-group" id="datepicker">
		  <input id="s" type="text" class="input-sm form-control" name="s" />
		  <span class="input-group-addon">&ndash;</span>
		  <input id="e" type="text" class="input-sm form-control" name="e" />
		</div>
	  </div>
	  <?= $this->Form->button('<i class="fa fa-bar-chart" aria-hidden="true"></i> ' . __('Report'), ['class' => 'btn btn-primary', 'type' => 'submit', 'espace' => false]) ?>
	  <?= $this->Form->end() ?>
	</div>
  </div>	
</div>

<?php
$this->prepend('css', $this->Html->css([Configure::read('Css.bootstrapDatepicker')]));
$this->prepend('script', $this->Html->script([Configure::read('Js.bootstrapDatepicker'), Configure::read('Js.chartjs')]));
?>

<?php $this->Html->scriptStart(['block' => true]); ?>
$(function() {
	$('#datepicker').datepicker({
		format: "yyyy-mm-dd",
		todayBtn: "linked",
		autoclose: true,
		calendarWeeks: true,
		todayHighlight: true
	});

	$('#s').val('<?= h($start) ?>');
	$('#e').val('<?= h($end) ?>');
});
<?php $this->Html->scriptEnd(); ?>

<?php $this->Html->scriptStart(['block' => true]); ?>
<?= $this->element('Chart/doughnut', ['id' => 'outgoings-canvas', 'data' => $expense]) ?>
<?= $this->element('Chart/doughnut', ['id' => 'incomings-canvas', 'data' => $income]) ?>

$(function() {
	$('#incomings-table').hide();
	$('#incomings-btn-chart').addClass('active');

	$('#incomings-btn-chart').click(function() {
		$('#incomings-btn-table').removeClass('active');
		$('#incomings-btn-chart').addClass('active');

		$('#incomings-table').hide();
		$('#incomings-chart').show();
	});

	$('#incomings-btn-table').click(function() {
		$('#incomings-btn-chart').removeClass('active');
		$('#incomings-btn-table').addClass('active');

		$('#incomings-chart').hide();
		$('#incomings-table').show();
	});

	$('#outgogins-table').hide();
	$('#outgoings-btn-chart').addClass('active');

	$('#outgoings-btn-chart').click(function() {
		$('#outgoings-btn-table').removeClass('active');
		$('#outgoings-btn-chart').addClass('active');

		$('#outgogins-table').hide();
		$('#outgogins-chart').show();
	});

	$('#outgoings-btn-table').click(function() {
		$('#outgoings-btn-chart').removeClass('active');
		$('#outgoings-btn-table').addClass('active');

		$('#outgogins-chart').hide();
		$('#outgogins-table').show();
	});
});
<?php $this->Html->scriptEnd(); ?>

<?php $this->Html->scriptStart(['block' => true]); ?>
<?= $this->element('Chart/balance', ['id' => 'chart-canvas-y', 'data' => $balance['annual'], 'format' => function ($x) {return sprintf('%d', $x->year);}]) ?>
<?= $this->element('Chart/balance', ['id' => 'chart-canvas-m', 'data' => $balance['monthly'], 'format' => function ($x) {return sprintf('%d-%02d', $x->year, $x->month);}]) ?>
<?= $this->element('Chart/balance', ['id' => 'chart-canvas-w', 'data' => $balance['weekly'], 'format' => function ($x) {return sprintf('%d-W%02d', $x->year, $x->week);}]) ?>
<?= $this->element('Chart/balance', ['id' => 'chart-canvas-d', 'data' => $balance['daily'], 'format' => function ($x) {return sprintf('%d-%02d-%02d', $x->year, $x->month, $x->day);}]) ?>

$(function() {
	$('#chart-btn-d').addClass('active');
	$('#chart-canvas canvas').hide();
	$('#chart-canvas-d').show();

	$('#chart-sel button').click(function() {
		$('#chart-sel button').removeClass('active');
		$(this).addClass('active');
	});

	$('#chart-btn-d').click(function() {
		$('#chart-canvas canvas').hide();
		$('#chart-canvas-d').show();
	});

	$('#chart-btn-w').click(function() {
		$('#chart-canvas canvas').hide();
		$('#chart-canvas-w').show();
	});

	$('#chart-btn-m').click(function() {
		$('#chart-canvas canvas').hide();
		$('#chart-canvas-m').show();
	});

	$('#chart-btn-y').click(function() {
		$('#chart-canvas canvas').hide();
		$('#chart-canvas-y').show();
	});
});
<?php $this->Html->scriptEnd(); ?>
