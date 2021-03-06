<?php
/**
  * @var \App\View\AppView $this
  */

use Cake\Core\Configure;
?>
<div class="row">
  <div class="col-md-12">
	<h2><?= __('Dashboard') ?></h2>
  </div>
</div>
<div class="row">
  <div class="col-md-9">
	<div class="visible-xs">
	  <div class="row">
		<div class="col-md-12">
		  <?= $this->Html->link('<i class="fas fa-plus" aria-hidden="true"></i> ' . __('New Journal'), ['controller' => 'journals', 'action' => 'add', '?' => ['back' => $back]], ['class' => 'btn btn-default', 'escape' => false]) ?>
		  <?= $this->Html->link('<i class="fas fa-chart-bar" aria-hidden="true"></i> ' . __('Report'), ['controller' => 'reports', 'action' => 'view'], ['class' => 'btn btn-default', 'escape' => false]) ?>
		  <a href="#q" class="btn btn-default"><i class="fas fa-search" aria-hidden="true"></i> <?= __('Search') ?></a>
		</div>
	  </div>
	</div>
	<div class="row">
	  <div class="col-md-6">
		<h3><?= __('Summary') ?></h3>
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
		<h3><?= __('Outgoings') ?></h3>
		<div align="right">
		  <div class="btn-group" role="group" aria-label="Page navigation">
			<button id="outgoings-btn-chart" class="btn btn-default btn-sm" type="button">
			  <i class="fas fa-chart-pie" aria-hidden="true"></i>
			</button>
			<button id="outgoings-btn-table" class="btn btn-default btn-sm" type="button">
			  <i class="fas fa-table" aria-hidden="true"></i>
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
				<th><i class="fas fa-ellipsis-h" aria-hidden="true"></i></th>
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
				  <?= $this->Html->link('<i class="fas fa-list" aria-hidden="true"></i>', ['controller' => 'journals', 'action' => 'index', '?' => ['s' => $start, 'e' => $end, 'd[]' => $x->debit_id]], ['escape' => false]) ?>
				</td>
			  </tr>
			  <?php endforeach; ?>
			</tbody>
		  </table>
		</div>
	  </div>
	  <div class="col-md-6">
		<h3><?= __('Recent Journals') ?></h3>
		<ul class="list-group">
		  <?php foreach ($journals as $x): ?>
		  <li class="list-group-item">
			<span class="float-right">
			  <strong><?= number_format($x->amount) ?></strong>
			</span>
			<h4 class="list-group-item-heading"><?= h($x->date) ?></h4>
			<p>
			  <?= h($x->summary) ?>
			  <span class="float-right">
				<?= $this->element('Journal/label', ['debit' => $account[$x->debit_id], 'credit' => $account[$x->credit_id]]) ?>
			  </span>
			</p>
			<p>
			  <?= $this->Html->link($x->debit->name, ['controller' => 'journals', '?' => ['d[]' => $x->debit_id]]) ?>
			  /
			  <?= $this->Html->link($x->credit->name, ['controller' => 'journals', '?' => ['c[]' => $x->credit_id]]) ?>
			  <span class="xs-icon float-right">
				<?= $this->Html->link('<i class="fas fa-list-alt" aria-hidden="true"></i>', ['controller' => 'journals', 'action' => 'view', $x->id, '?' => ['back' => $back]], ['escape' => false]) ?>
				&nbsp;
				<?= $this->Html->link('<i class="fas fa-edit" aria-hidden="true"></i>', ['controller' => 'journals', 'action' => 'edit', $x->id, '?' => ['back' => $back]], ['escape' => false]) ?>
			  </span>
			</p>
		  </li>
		  <?php endforeach; ?>
		</ul>
	  </div>
	</div>
  </div>
  <div class="col-md-3">
    <?= $this->Form->create(null, ['type' => 'get', 'url' => ['controller' => 'journals', 'action' => 'index']]) ?>
	<fieldset>
	  <?= $this->Form->input('q', ['label' => false, 'placeholder' => __('Search'), 'append' => '<button class="btn btn-primary" type="submit"><i class="fas fa-search"></i></button>']) ?>
	</fieldset>
	<?= $this->Form->end() ?>
	<div class="list-group">
	  <?= $this->Html->link('<i class="fas fa-chart-bar" aria-hidden="true"></i> ' . __('View Report'), ['controller' => 'reports', 'action' => 'view'], ['class' => 'list-group-item', 'escape' => false]) ?>
	</div>
	<div class="list-group">
	  <?= $this->Html->link('<i class="fas fa-list" aria-hidden="true"></i> ' . __('List Journals'), ['controller' => 'journals', 'action' => 'index'], ['class' => 'list-group-item', 'escape' => false]) ?>
	  <?= $this->Html->link('<i class="fas fa-plus" aria-hidden="true"></i> ' . __('New Journal'), ['controller' => 'journals', 'action' => 'add', '?' => ['back' => $back]], ['class' => 'list-group-item', 'escape' => false]) ?>
	  <?= $this->Html->link('<i class="fas fa-list-ol" aria-hidden="true"></i> ' . __('List Reports'), ['controller' => 'reports', 'action' => 'index'], ['class' => 'list-group-item', 'escape' => false]) ?>
	</div>
  </div>	
</div>

<?= $this->fetch('postLink') ?>

<?php $this->prepend('script', $this->Html->script([Configure::read('Js.chartjs')])) ?>

<?php $this->Html->scriptStart(['block' => true]); ?>
$(function() {
	<?= $this->element('Chart/doughnut', ['id' => 'outgoings-canvas', 'data' => $expense]) ?>

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
