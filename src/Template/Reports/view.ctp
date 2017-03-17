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
	<div class="row">
	  <div class="col-md-12">
		<legend><?= $start ?> &ndash; <?= $end ?></legend>
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
		<div id="chart-incomings">
		  <canvas id="canvas-incomings" width="400" height="400"></canvas>
		</div>
	  </div>
	  <div class="col-md-4">
		<h3><?= __('Outgoings') ?></h3>
		<div id="chart-outgoings">
		  <canvas id="canvas-outgoings" width="400" height="400"></canvas>
		</div>
	  </div>
	</div>
	<div class="row">
	  <div class="col-md-12">
		<h3><?= __('Chart') ?></h3>
		<div align="right">
		  <div id="chart-sel" class="btn-group btn-group-sm" role="group" aria-label="Chart selector">
			<button id="chart-btn-y" type="button" class="btn btn-default"><?= __('Year') ?></button>
			<button id="chart-btn-m" type="button" class="btn btn-default"><?= __('Month') ?></button>
			<button id="chart-btn-w" type="button" class="btn btn-default"><?= __('Week') ?></button>
			<button id="chart-btn-d" type="button" class="btn btn-default"><?= __('Day') ?></button>
		  </div>
		</div>
		<div id="chart-lines">
		  <canvas id="canvas-line-d" width="400" height="100"></canvas>
		  <canvas id="canvas-line-w" width="400" height="100"></canvas>
		  <canvas id="canvas-line-m" width="400" height="100"></canvas>
		  <canvas id="canvas-line-y" width="400" height="100"></canvas>
		</div>
	  </div>
	</div>
  </div>
  <div class="col-md-3">
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
	  <?= $this->Form->submit(__('Submit'), ['class' => 'btn btn-primary']) ?>
	  <?= $this->Form->end() ?>
	</div>
  </div>	
</div>

<?php
$this->prepend('css', $this->Html->css([Configure::read('Css.bootstrapDatepicker')]));
$this->prepend('script', $this->Html->script([Configure::read('Js.bootstrapDatepicker'), Configure::read('Js.chartjs')]));
?>

<?php $this->Html->scriptStart(['block' => true]) ?>
$(function() {
	$('#datepicker').datepicker({
		format: "yyyy-mm-dd",
		todayBtn: "linked",
		autoclose: true,
		calendarWeeks: true,
		todayHighlight: true
	});

	$('#s').val('<?= $start ?>');
	$('#e').val('<?= $end ?>');
});
<?php $this->Html->scriptEnd() ?>

<?php
$label = array();
$data = array();
foreach ($expense as $x) {
	$label[] = $x->name;
	$data[] = $x->sum;
}

if (count($label)) {
	$this->Html->scriptStart(['block' => true]);
	echo $this->element('Chart/doughnut', ['id' => 'canvas-outgoings', 'label' => $label, 'data' => $data]);
	$this->Html->scriptEnd();
}
else {
	$this->Html->scriptStart(['block' => true]);
?>
$(function() {
    $('#chart-outgoings').append('<div class="alert alert-warning" role="alert"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> <?= __('No data') ?></div>');
    $('#canvas-outgoings').hide();
});
<?php
	$this->Html->scriptEnd();
}
?>

<?php
$label = array();
$data = array();
foreach ($income as $x) {
	$label[] = $x->name;
	$data[] = $x->sum;
}

if (count($label)) {
	$this->Html->scriptStart(['block' => true]);
	echo $this->element('Chart/doughnut', ['id' => 'canvas-incomings', 'label' => $label, 'data' => $data]);
	$this->Html->scriptEnd();
}
else {
	$this->Html->scriptStart(['block' => true]);
?>
$(function() {
    $('#chart-incomings').append('<div class="alert alert-warning" role="alert"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> <?= __('No data') ?></div>');
    $('#canvas-incomings').hide();
});
<?php
	$this->Html->scriptEnd();
}
?>

<?php
$label = array();
$incoming = array();
$outgoing = array();

foreach ($daily as $x) {
	$label[] = sprintf('%04d-%02d-%02d', $x->year, $x->month, $x->day);
	$incoming[] = $x->income;
	$outgoing[] = $x->expense;
}

$this->Html->scriptStart(['block' => true]);
echo $this->element('Chart/line', ['id' => 'canvas-line-d', 'label' => $label, 'incoming' => $incoming, 'outgoing' => $outgoing]);
$this->Html->scriptEnd();
?>

<?php
$label = array();
$incoming = array();
$outgoing = array();

foreach ($weekly as $x) {
	$label[] = sprintf('%04d-W%02d', $x->year, $x->week);
	$incoming[] = $x->income;
	$outgoing[] = $x->expense;
}

$this->Html->scriptStart(['block' => true]);
echo $this->element('Chart/line', ['id' => 'canvas-line-w', 'label' => $label, 'incoming' => $incoming, 'outgoing' => $outgoing]);
$this->Html->scriptEnd();
?>

<?php
$label = array();
$incoming = array();
$outgoing = array();

foreach ($monthly as $x) {
	$label[] = sprintf('%04d-%02d', $x->year, $x->month);
	$incoming[] = $x->income;
	$outgoing[] = $x->expense;
}

$this->Html->scriptStart(['block' => true]);
echo $this->element('Chart/line', ['id' => 'canvas-line-m', 'label' => $label, 'incoming' => $incoming, 'outgoing' => $outgoing]);
$this->Html->scriptEnd();
?>

<?php
$label = array();
$incoming = array();
$outgoing = array();

foreach ($annual as $x) {
	$label[] = $x->year;
	$incoming[] = $x->income;
	$outgoing[] = $x->expense;
}

$this->Html->scriptStart(['block' => true]);
echo $this->element('Chart/line', ['id' => 'canvas-line-y', 'label' => $label, 'incoming' => $incoming, 'outgoing' => $outgoing]);
$this->Html->scriptEnd();
?>

<?php $this->Html->scriptStart(['block' => true]); ?>
$(function() {
	$('#chart-btn-d').addClass('active');
	$('#chart-lines canvas').hide();
	$('#canvas-line-d').show();

	$('#chart-sel button').click(function() {
		$('#chart-sel button').removeClass('active');
		$(this).addClass('active');

		$('#chart-lines canvas').hide();
	});

	$('#chart-btn-d').click(function() {
		$('#canvas-line-d').show();
	});

	$('#chart-btn-w').click(function() {
		$('#canvas-line-w').show();
	});

	$('#chart-btn-m').click(function() {
		$('#canvas-line-m').show();
	});

	$('#chart-btn-y').click(function() {
		$('#canvas-line-y').show();
	});
});
<?php $this->Html->scriptEnd(); ?>
