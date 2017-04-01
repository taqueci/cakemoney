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
			  <?php $incoming_category = [] ?>
			  <?php foreach ($income as $x): ?>
			  <?php $incoming_category[] = $x->name ?>
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
			  <?php $outgoing_category = [] ?>
			  <?php foreach ($expense as $x): ?>
			  <?php $outgoing_category[] = $x->name ?>
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
		  <div id="chart-sel-view" class="btn-group btn-group-sm" role="group" aria-label="Chart selector">
			<button id="chart-btn-b" type="button" class="btn btn-default"><?= __('Balance') ?></button>
			<button id="chart-btn-i" type="button" class="btn btn-default"><?= __('Incomings') ?></button>
			<button id="chart-btn-o" type="button" class="btn btn-default"><?= __('Outgoings') ?></button>
		  </div>
		  <div id="chart-sel-scope" class="btn-group btn-group-sm" role="group" aria-label="Chart selector">
			<button id="chart-btn-y" type="button" class="btn btn-default"><?= __('Year') ?></button>
			<button id="chart-btn-m" type="button" class="btn btn-default"><?= __('Month') ?></button>
			<button id="chart-btn-w" type="button" class="btn btn-default"><?= __('Week') ?></button>
			<button id="chart-btn-d" type="button" class="btn btn-default"><?= __('Day') ?></button>
		  </div>
		</div>
		<div>
		  <canvas id="chart-canvas" width="400" height="400"></canvas>
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
$(function() {
	<?= $this->element('Chart/doughnut', ['id' => 'outgoings-canvas', 'data' => $expense]) ?>
	<?= $this->element('Chart/doughnut', ['id' => 'incomings-canvas', 'data' => $income]) ?>

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
$(function() {
	var data = {
		balance: {
			annual: <?= $this->element('Chart/Data/balance', ['data' => $balance['annual'], 'format' => function ($x) {return sprintf('%d', $x->year);}]) ?>,
			monthly: <?= $this->element('Chart/Data/balance', ['data' => $balance['monthly'], 'format' => function ($x) {return sprintf('%d-%02d', $x->year, $x->month);}]) ?>,
			weekly: <?= $this->element('Chart/Data/balance', ['data' => $balance['weekly'], 'format' => function ($x) {return sprintf('%d-W%02d', $x->year, $x->week);}]) ?>,
			daily: <?= $this->element('Chart/Data/balance', ['data' => $balance['daily'], 'format' => function ($x) {return sprintf('%d-%02d-%02d', $x->year, $x->month, $x->day);}]) ?>
		},
		incomings: {
			annual: <?= $this->element('Chart/Data/stacked', ['data' => $incomings['annual'], 'category' => $incoming_category, 'format' => function ($x) {return sprintf('%d', $x->year);}]) ?>,
			monthly: <?= $this->element('Chart/Data/stacked', ['data' => $incomings['monthly'], 'category' => $incoming_category, 'format' => function ($x) {return sprintf('%d-%02d', $x->year, $x->month);}]) ?>,
			weekly: <?= $this->element('Chart/Data/stacked', ['data' => $incomings['weekly'], 'category' => $incoming_category, 'format' => function ($x) {return sprintf('%d-W%02d', $x->year, $x->week);}]) ?>,
			daily: <?= $this->element('Chart/Data/stacked', ['data' => $incomings['daily'], 'category' => $incoming_category, 'format' => function ($x) {return sprintf('%d-%02d-%02d', $x->year, $x->month, $x->day);}]) ?>
		},
		outgoings: {
			annual: <?= $this->element('Chart/Data/stacked', ['data' => $outgoings['annual'], 'category' => $outgoing_category, 'format' => function ($x) {return sprintf('%d', $x->year);}]) ?>,
			monthly: <?= $this->element('Chart/Data/stacked', ['data' => $outgoings['monthly'], 'category' => $outgoing_category, 'format' => function ($x) {return sprintf('%d-%02d', $x->year, $x->month);}]) ?>,
			weekly: <?= $this->element('Chart/Data/stacked', ['data' => $outgoings['weekly'], 'category' => $outgoing_category, 'format' => function ($x) {return sprintf('%d-W%02d', $x->year, $x->week);}]) ?>,
			daily: <?= $this->element('Chart/Data/stacked', ['data' => $outgoings['daily'], 'category' => $outgoing_category, 'format' => function ($x) {return sprintf('%d-%02d-%02d', $x->year, $x->month, $x->day);}]) ?>
		}
	};

	function number_format(value, index, values) {
		return value.toFixed(0).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
	}

	var option = {
		balance: {
			maintainAspectRatio: false,
			scales: {yAxes: [{ticks: {userCallback: number_format}}]}
		},
		incomings: {
			maintainAspectRatio: false,
			scales: {
				xAxes: [{stacked: true}],
				yAxes: [{stacked: true, ticks: {userCallback: number_format}}]
			}
		},
		outgoings: {
			maintainAspectRatio: false,
			scales: {
				xAxes: [{stacked: true}],
				yAxes: [{stacked: true, ticks: {userCallback: number_format}}]
			}
		}
	};

	function chart_new(c, o, d) {
		return new Chart(c, {type: 'line', options: o, data: d});
	}

	var view  = 'balance';
	var scope = 'daily';

	var ctx = document.getElementById('chart-canvas').getContext('2d');

	var chart = chart_new(ctx, option[view], data[view][scope]);

	$('#chart-btn-b').addClass('active');
	$('#chart-btn-d').addClass('active');

	$('#chart-sel-view button').click(function() {
		$('#chart-sel-view button').removeClass('active');
		$(this).addClass('active');
	});

	$('#chart-sel-scope button').click(function() {
		$('#chart-sel-scope button').removeClass('active');
		$(this).addClass('active');
	});

	$('#chart-btn-b').click(function() {
		view = 'balance';

		chart.destroy();
		chart = chart_new(ctx, option[view], data[view][scope]);
	});

	$('#chart-btn-i').click(function() {
		view = 'incomings';

		chart.destroy();
		chart = chart_new(ctx, option[view], data[view][scope]);
	});

	$('#chart-btn-o').click(function() {
		view = 'outgoings';

		chart.destroy();
		chart = chart_new(ctx, option[view], data[view][scope]);
	});

	$('#chart-btn-y').click(function() {
		scope = 'annual';

		chart.destroy();
		chart = chart_new(ctx, option[view], data[view][scope]);
	});

	$('#chart-btn-m').click(function() {
		scope = 'monthly';

		chart.destroy();
		chart = chart_new(ctx, option[view], data[view][scope]);
	});

	$('#chart-btn-w').click(function() {
		scope = 'weekly';

		chart.destroy();
		chart = chart_new(ctx, option[view], data[view][scope]);
	});

	$('#chart-btn-d').click(function() {
		scope = 'daily';

		chart.destroy();
		chart = chart_new(ctx, option[view], data[view][scope]);
	});
});
<?php $this->Html->scriptEnd(); ?>
