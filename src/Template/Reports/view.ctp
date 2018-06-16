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
	  <div class="col-md-12">
		<h3><?= __('Summary') ?></h3>
		<ul class="list-inline">
		  <li class="has-margin-right">
			<h4><?= __('Balance') ?></h4>
			<ul class="list-inline">
			  <li>
				<table>
				  <tr>
					<td align="center"><small><span class="label label-default"><?= __('Incomings') ?></span></small></td>
				  </tr>
				  <tr>
					<td align="center"><span class="font-xlarge"></span><span class="font-large"><?= number_format($sum->income) ?></span></td>
				  </tr>
				</table>
			  </li>
			  <li>
				<table>
				  <tr>
					<td><span class="font-xlarge"></span><tt>-</tt></td>
				  </tr>
				</table>
			  </li>
			  <li>
				<table>
				  <tr>
					<td align="center"><small><span class="label label-default"><?= __('Outgoings') ?></span></small></td>
				  </tr>
				  <tr>
					<td align="center"><span class="font-xlarge"></span><span class="font-large"><?= number_format($sum->expense) ?></span></td>
				  </tr>
				</table>
			  </li>
			  <li>
				<table>
				  <tr>
					<td><span class="font-xlarge"></span><tt>=</tt></td>
				  </tr>
				</table>
			  </li>
			  <li>
				<table>
				  <tr>
					<td align="center"><small><span class="label label-default"><?= __('Balance') ?></span></small></td>
				  </tr>
				  <tr>
					<td align="center"><span class="font-xlarge"><?= $this->element('Format/numberWithStatus', ['value' => $sum->income - $sum->expense]) ?></span></td>
				  </tr>
				</table>
			  </li>
			</ul>
		  </li>
		  <li class="has-margin-right">
			<h4><?= __('Net Assets') ?></h4>
			<ul class="list-inline">
			  <li>
				<table>
				  <tr>
					<td align="center"><small><span class="label label-default"><?= __('Assets') ?></span></small></td>
				  </tr>
				  <tr>
					<td align="center"><span class="font-xlarge"></span><span class="font-large"><?= number_format($sum->asset) ?></span></td>
				  </tr>
				</table>
			  </li>
			  <li>
				<table>
				  <tr>
					<td><span class="font-xlarge"></span><tt>-</tt></td>
				  </tr>
				</table>
			  </li>
			  <li>
				<table>
				  <tr>
					<td align="center"><small><span class="label label-default"><?= __('Liabilities') ?></span></small></td>
				  </tr>
				  <tr>
					<td align="center"><span class="font-xlarge"></span><span class="font-large"><?= number_format($sum->liability) ?></span></td>
				  </tr>
				</table>
			  </li>
			  <li>
				<table>
				  <tr>
					<td><span class="font-xlarge"></span><tt>=</tt></td>
				  </tr>
				</table>
			  </li>
			  <li>
				<table>
				  <tr>
					<td align="center"><small><span class="label label-default"><?= __('Net Assets') ?></span></small></td>
				  </tr>
				  <tr>
					<td align="center"><span class="font-xlarge"><?= $this->element('Format/numberWithStatus', ['value' => $sum->asset - $sum->liability]) ?></span></td>
				  </tr>
				</table>
			  </li>
			</ul>
		  </li>
		  <li class="has-margin-right">
			<h4><?= __('Equities') ?></h4>
			<ul class="list-inline">
			  <li>
				<table>
				  <tr>
					<td align="center"><small><span class="label label-default"><?= __('Equities') ?></span></small></td>
				  </tr>
				  <tr>
					<td align="center"><span class="font-xlarge"><?= number_format($sum->equity) ?></span></td>
				  </tr>
				</table>
			  </li>
			</ul>
		  </li>
		</ul>
	  </div>
	</div>
	<div class="row">
	  <div class="col-md-5">
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
	  <div class="col-md-7">
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
		<div id="outgoings-chart">
		  <canvas id="outgoings-canvas" width="400" height="400"></canvas>
		</div>
		<div id="outgoings-table">
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
			<button id="chart-btn-n" type="button" class="btn btn-default"><?= __('Assets') ?></button>
			<button id="chart-btn-i" type="button" class="btn btn-default"><?= __('Incomings') ?></button>
			<button id="chart-btn-o" type="button" class="btn btn-default"><?= __('Outgoings') ?></button>
		  </div>
		  <div id="chart-sel-scope" class="btn-group btn-group-sm" role="group" aria-label="Chart selector">
			<?php
foreach (['Year', 'Month', 'Week', 'Day'] as $x) {
	if (!array_key_exists($x, $chart)) continue;
?>
			<button id="chart-btn-<?= strtolower($x) ?>" type="button" class="btn btn-default"><?= __($x) ?></button>
			<?php
}
?>
		  </div>
		  <div id="chart-sel-accu" class="btn-group btn-group-sm" role="group" aria-label="Chart selector">
			<button id="chart-btn-a" type="button" class="btn btn-default">
			  <i class="fa fa-signal" aria-hidden="true"></i>
			</button>
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
		<?= $this->Html->link('<i class="fa fa-plus" aria-hidden="true"></i> ' . __('New Journal'), ['controller' => 'journals', 'action' => 'add', '?' => ['back' => $back]], ['class' => 'list-group-item', 'escape' => false]) ?>
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

	$('#outgoings-table').hide();
	$('#outgoings-btn-chart').addClass('active');

	$('#outgoings-btn-chart').click(function() {
		$('#outgoings-btn-table').removeClass('active');
		$('#outgoings-btn-chart').addClass('active');

		$('#outgoings-table').hide();
		$('#outgoings-chart').show();
	});

	$('#outgoings-btn-table').click(function() {
		$('#outgoings-btn-chart').removeClass('active');
		$('#outgoings-btn-table').addClass('active');

		$('#outgoings-chart').hide();
		$('#outgoings-table').show();
	});
});
<?php $this->Html->scriptEnd(); ?>

<?php $this->Html->scriptStart(['block' => true]); ?>
$(function() {
	var normal = {
		balance: {
			annual: <?= $this->element('Chart/Data/balance', ['data' => array_key_exists('Year', $chart) ? $chart['Year']['sum'] : [], 'format' => function ($x) {return sprintf('%d', $x->year);}]) ?>,
			monthly: <?= $this->element('Chart/Data/balance', ['data' => array_key_exists('Month', $chart) ? $chart['Month']['sum'] : [], 'format' => function ($x) {return sprintf('%d-%02d', $x->year, $x->month);}]) ?>,
			weekly: <?= $this->element('Chart/Data/balance', ['data' => array_key_exists('Week', $chart) ? $chart['Week']['sum'] : [], 'format' => function ($x) {return sprintf('%d-W%02d', $x->year, $x->week);}]) ?>,
			daily: <?= $this->element('Chart/Data/balance', ['data' => array_key_exists('Day', $chart) ? $chart['Day']['sum'] : [], 'format' => function ($x) {return sprintf('%d-%02d-%02d', $x->year, $x->month, $x->day);}]) ?>
		},
		asset: {
			annual: <?= $this->element('Chart/Data/asset', ['data' => array_key_exists('Year', $chart) ? $chart['Year']['sum'] : [], 'format' => function ($x) {return sprintf('%d', $x->year);}]) ?>,
			monthly: <?= $this->element('Chart/Data/asset', ['data' => array_key_exists('Month', $chart) ? $chart['Month']['sum'] : [], 'format' => function ($x) {return sprintf('%d-%02d', $x->year, $x->month);}]) ?>,
			weekly: <?= $this->element('Chart/Data/asset', ['data' => array_key_exists('Week', $chart) ? $chart['Week']['sum'] : [], 'format' => function ($x) {return sprintf('%d-W%02d', $x->year, $x->week);}]) ?>,
			daily: <?= $this->element('Chart/Data/asset', ['data' => array_key_exists('Day', $chart) ? $chart['Day']['sum'] : [], 'format' => function ($x) {return sprintf('%d-%02d-%02d', $x->year, $x->month, $x->day);}]) ?>
		},
		incomings: {
			annual: <?= $this->element('Chart/Data/stacked', ['data' => array_key_exists('Year', $chart) ? $chart['Year']['income'] : [], 'category' => $incoming_category, 'format' => function ($x) {return sprintf('%d', $x->year);}]) ?>,
			monthly: <?= $this->element('Chart/Data/stacked', ['data' => array_key_exists('Month', $chart) ? $chart['Month']['income'] : [], 'category' => $incoming_category, 'format' => function ($x) {return sprintf('%d-%02d', $x->year, $x->month);}]) ?>,
			weekly: <?= $this->element('Chart/Data/stacked', ['data' => array_key_exists('Week', $chart) ? $chart['Week']['income'] : [], 'category' => $incoming_category, 'format' => function ($x) {return sprintf('%d-W%02d', $x->year, $x->week);}]) ?>,
			daily: <?= $this->element('Chart/Data/stacked', ['data' => array_key_exists('Day', $chart) ? $chart['Day']['income'] : [], 'category' => $incoming_category, 'format' => function ($x) {return sprintf('%d-%02d-%02d', $x->year, $x->month, $x->day);}]) ?>
		},
		outgoings: {
			annual: <?= $this->element('Chart/Data/stacked', ['data' => array_key_exists('Year', $chart) ? $chart['Year']['expense'] : [], 'category' => $outgoing_category, 'format' => function ($x) {return sprintf('%d', $x->year);}]) ?>,
			monthly: <?= $this->element('Chart/Data/stacked', ['data' => array_key_exists('Month', $chart) ? $chart['Month']['expense'] : [], 'category' => $outgoing_category, 'format' => function ($x) {return sprintf('%d-%02d', $x->year, $x->month);}]) ?>,
			weekly: <?= $this->element('Chart/Data/stacked', ['data' => array_key_exists('Week', $chart) ? $chart['Week']['expense'] : [], 'category' => $outgoing_category, 'format' => function ($x) {return sprintf('%d-W%02d', $x->year, $x->week);}]) ?>,
			daily: <?= $this->element('Chart/Data/stacked', ['data' => array_key_exists('Day', $chart) ? $chart['Day']['expense'] : [], 'category' => $outgoing_category, 'format' => function ($x) {return sprintf('%d-%02d-%02d', $x->year, $x->month, $x->day);}]) ?>
		}
	};

	var accumulated = $.extend(true, {}, normal);

	$.each(accumulated, function(i, u) {
		$.each(u, function(j, v) {
			v.datasets.forEach(function(w) {
				var sum = 0;

				w.data.forEach(function(val, index) {
					w.data[index] += sum;
					sum += val;
				});
			});
		});
	});

	function number_format(value, index, values) {
		return value.toFixed(0).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
	}

	function number_format_tooltip(tooltipItem, data) {
		return tooltipItem.yLabel.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
	}

	var option = {
		balance: {
			maintainAspectRatio: false,
			tooltips: {callbacks: {label: number_format_tooltip}},
			scales: {yAxes: [{ticks: {callback: number_format}}]}
		},
		asset: {
			maintainAspectRatio: false,
			tooltips: {callbacks: {label: number_format_tooltip}},
			scales: {yAxes: [{ticks: {callback: number_format}}]}
		},
		incomings: {
			maintainAspectRatio: false,
			tooltips: {callbacks: {label: number_format_tooltip}},
			scales: {
				xAxes: [{stacked: true}],
				yAxes: [{stacked: true, ticks: {callback: number_format}}]
			}
		},
		outgoings: {
			maintainAspectRatio: false,
			tooltips: {callbacks: {label: number_format_tooltip}},
			scales: {
				xAxes: [{stacked: true}],
				yAxes: [{stacked: true, ticks: {callback: number_format}}]
			}
		}
	};

	var data = {normal: normal, accumulated: accumulated};

	var view_index = {
		'chart-btn-b': 'balance',
		'chart-btn-n': 'asset',
		'chart-btn-i': 'incomings',
		'chart-btn-o': 'outgoings'
	};

	var scope_index = {
		'chart-btn-year': 'annual',
		'chart-btn-month': 'monthly',
		'chart-btn-week': 'weekly',
		'chart-btn-day': 'daily'
	};

	function ReportChart(ctx) {
		this._ctx = ctx;
		this._curve = 'normal';
		this._view  = 'balance';
		this._scope = 'daily';
	}

	ReportChart.prototype = {
		setOption: function(x) {this._option = x},
		setData: function(x) {this._data = x},
		setCurve: function(x) {this._curve = x},
		setView: function(x) {this._view = x},
		setScope: function(x) {this._scope = x},
		draw: function() {
			if (this._obj) this._obj.destroy();

			this._obj = new Chart(this._ctx, {
				type: 'line',
				options: this._option[this._view],
				data: this._data[this._curve][this._view][this._scope]
			});
		}
	};

	$('#chart-sel-view button').click(function() {
		$('#chart-sel-view button').removeClass('active');
		$(this).addClass('active');

		chart.setView(view_index[$(this).attr('id')]);
		chart.draw();
	});

	$('#chart-sel-scope button').click(function() {
		$('#chart-sel-scope button').removeClass('active');
		$(this).addClass('active');

		chart.setScope(scope_index[$(this).attr('id')]);
		chart.draw();
	});

	$('#chart-btn-a').click(function() {
		if ($(this).hasClass('active')) {
			$(this).removeClass('active');
			chart.setCurve('normal');
		}
		else {
			$(this).addClass('active');
			chart.setCurve('accumulated');
		}

		chart.draw();
	});

	var ctx = document.getElementById('chart-canvas').getContext('2d');
	var chart = new ReportChart(ctx);

	chart.setOption(option);
	chart.setData(data);

	$('#chart-btn-b').addClass('active');
	$('#chart-sel-scope button').filter(':last').click();
});
<?php $this->Html->scriptEnd(); ?>
