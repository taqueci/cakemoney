<?php
/**
  * @var \App\View\AppView $this
  */
?>
<div class="row">
  <div class="col-md-12">
	<h2><?= __('Reports') ?></h2>
  </div>
</div>
<div class="row">
  <div class="col-md-9">
    <div><!-- div class="hidden-xs" -->
	  <h3><?= __('Daily') ?></h3>
	  <table class="table table-striped">
		<thead>
		  <tr>
			<th><?= __('Date') ?></th>
			<th><?= __('Incomings') ?></th>
			<th><?= __('Outgoings') ?></th>
			<th><?= __('Balance') ?></th>
			<th><?= __('Actions') ?></th>
		  </tr>
		</thead>
		<tbody>
		  <?php foreach ($daily as $x): ?>
		  <tr>
			<td><?= sprintf('%4d-%02d-%02d', $x->year, $x->month, $x->day) ?></td>
			<td align="right"><?= number_format($x->income) ?></td>
			<td align="right"><?= number_format($x->expense) ?></td>
			<td align="right"><?= number_format($x->income - $x->expense) ?></td>
			<td>
			  <!-- <?= $this->Html->link('<i class="fa fa-bar-chart" aria-hidden="true"></i>', ['action' => 'view', $x->id], ['escape' => false]) ?> -->
			  <i class="fa fa-bar-chart" aria-hidden="true"></i>
			</td>
		  </tr>
		  <?php endforeach; ?>
		</tbody>
	  </table>
	  <h3><?= __('Weekly') ?></h3>
	  <table class="table table-striped">
		<thead>
		  <tr>
			<th><?= __('Week') ?></th>
			<th><?= __('Incomings') ?></th>
			<th><?= __('Outgoings') ?></th>
			<th><?= __('Balance') ?></th>
			<th><?= __('Actions') ?></th>
		  </tr>
		</thead>
		<tbody>
		  <?php foreach ($weekly as $x): ?>
		  <?php
		  $d = new DateTime();

		  $d->setISODate($x->year, $x->week);
		  $start = $d->format('Y-m-d');
		  $d->modify('+6 days');
		  $end = $d->format('Y-m-d');
		  ?>
		  <tr>
			<td><?= sprintf('%4d-W%02d', $x->year, $x->week) ?></td>
			<td align="right"><?= number_format($x->income) ?></td>
			<td align="right"><?= number_format($x->expense) ?></td>
			<td align="right"><?= number_format($x->income - $x->expense) ?></td>
			<td>
			  <?= $this->Html->link('<i class="fa fa-bar-chart" aria-hidden="true"></i>', ['action' => 'view', $x->id, '?' => ['s' => $start, 'e' => $end]], ['escape' => false]) ?>
			</td>
		  </tr>
		  <?php endforeach; ?>
		</tbody>
	  </table>
	  <h3><?= __('Monthly') ?></h3>
	  <table class="table table-striped">
		<thead>
		  <tr>
			<th><?= __('Month') ?></th>
			<th><?= __('Incomings') ?></th>
			<th><?= __('Outgoings') ?></th>
			<th><?= __('Balance') ?></th>
			<th><?= __('Actions') ?></th>
		  </tr>
		</thead>
		<tbody>
		  <?php foreach ($monthly as $x): ?>
		  <?php
		  $d = new DateTime(sprintf('%4d-%02d-01', $x->year, $x->month));

		  $start = $d->format('Y-m-d');
		  $end   = $d->format('Y-m-t');
		  ?>
		  <tr>
			<td><?= sprintf('%4d-%02d', $x->year, $x->month) ?></td>
			<td align="right"><?= number_format($x->income) ?></td>
			<td align="right"><?= number_format($x->expense) ?></td>
			<td align="right"><?= number_format($x->income - $x->expense) ?></td>
			<td>
			  <?= $this->Html->link('<i class="fa fa-bar-chart" aria-hidden="true"></i>', ['action' => 'view', $x->id, '?' => ['s' => $start, 'e' => $end]], ['escape' => false]) ?>
			</td>
		  </tr>
		  <?php endforeach; ?>
		</tbody>
	  </table>
	  <h3><?= __('Annual') ?></h3>
	  <table class="table table-striped">
		<thead>
		  <tr>
			<th><?= __('Year') ?></th>
			<th><?= __('Incomings') ?></th>
			<th><?= __('Outgoings') ?></th>
			<th><?= __('Balance') ?></th>
			<th><?= __('Actions') ?></th>
		  </tr>
		</thead>
		<tbody>
		  <?php foreach ($annual as $x): ?>
		  <?php
		  $start = sprintf('%4d-01-01', $x->year);
		  $end   = sprintf('%4d-12-31', $x->year);
		  ?>
		  <tr>
			<td><?= $x->year ?></td>
			<td align="right"><?= number_format($x->income) ?></td>
			<td align="right"><?= number_format($x->expense) ?></td>
			<td align="right"><?= number_format($x->income - $x->expense) ?></td>
			<td>
			  <?= $this->Html->link('<i class="fa fa-bar-chart" aria-hidden="true"></i>', ['action' => 'view', $x->id, '?' => ['s' => $start, 'e' => $end]], ['escape' => false]) ?>
			</td>
		  </tr>
		  <?php endforeach; ?>
		</tbody>
	  </table>
	</div>
	<div><!-- div class="visible-xs" -->
	</div>
  </div>
  <div class="col-md-3">
	<div class="list-group">
	  <?= $this->Html->link('<i class="fa fa-list" aria-hidden="true"></i> ' . __('List Journals'), ['controller' => 'journals', 'action' => 'index'], ['class' => 'list-group-item', 'escape' => false]) ?>
		<?= $this->Html->link('<i class="fa fa-plus" aria-hidden="true"></i> ' . __('New Journal'), ['controller' => 'journals', 'action' => 'add'], ['class' => 'list-group-item', 'escape' => false]) ?>
	</div>
	<div class="well">
	  <?= $this->Form->create(null, ['id' => 'form-date', 'type' => 'get', 'url' => ['controller' => 'reports', 'action' => 'view']]) ?>
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
$this->prepend('css', $this->Html->css($css));
$this->prepend('script', $this->Html->script($js));
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
