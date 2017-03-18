<?php
/**
  * @var \App\View\AppView $this
  */

use Cake\Core\Configure;
?>
<div class="row">
  <div class="col-md-12">
	<h2><?= __('Journals') ?></h2>
  </div>
</div>
<div class="row">
  <div class="col-md-9">
	<div class="visible-xs">
	  <div class="has-margin-bottom">
		<?= $this->Html->link('<i class="fa fa-plus" aria-hidden="true"></i> ' . __('New Journal'), ['controller' => 'journals', 'action' => 'add'], ['class' => 'btn btn-default', 'escape' => false]) ?>
	  <?= $this->Html->link('<i class="fa fa-search" aria-hidden="true"></i> ' . __('Search'), ['#' => 'q'], ['class' => 'btn btn-default', 'escape' => false]) ?>
	  <?= $this->Html->link('<i class="fa fa-filter" aria-hidden="true"></i> ' . __('Filter'), ['#' => 's'], ['class' => 'btn btn-default', 'escape' => false]) ?>
	  </div>
	</div>
	<div class="hidden-xs">
	  <table class="table table-striped">
		<thead>
		  <tr>
			<th><?= $this->Paginator->sort('id', __('ID')) ?></th>
			<th><?= $this->Paginator->sort('date', __('Date')) ?></th>
			<th><?= $this->Paginator->sort('debit_id', __('Debit')) ?></th>
			<th><?= $this->Paginator->sort('credit_id', __('Credit')) ?></th>
			<th><?= $this->Paginator->sort('amount', __('Amount')) ?></th>
			<th><?= $this->Paginator->sort('summary', __('Summary')) ?></th>
			<th><?= __('Actions') ?></th>
		  </tr>
		</thead>
		<tbody>
		  <?php foreach ($journals as $x): ?>
		  <tr>
			<td align="right"><?= $x->id ?></td>
			<td><?= h($x->date) ?></td>
			<td><?= h($x->debit->name) ?></td>
			<td><?= h($x->credit->name) ?></td>
			<td align="right"><?= number_format($x->amount) ?></td>
			<td><?= h($x->summary) ?></td>
			<td>
			  <?= $this->Html->link('<i class="fa fa-list-alt" aria-hidden="true"></i>', ['action' => 'view', $x->id], ['escape' => false]) ?>
			  &nbsp;
			  <?= $this->Html->link('<i class="fa fa-pencil" aria-hidden="true"></i>', ['action' => 'edit', $x->id], ['escape' => false]) ?>
			  &nbsp;
			  <?= $this->Html->link('<i class="fa fa-copy" aria-hidden="true"></i> ', ['action' => 'copy', $x->id], ['escape' => false]) ?>
			  &nbsp;
			  <?= $this->Form->postLink('<i class="fa fa-trash" aria-hidden="true"></i>', ['action' => 'delete', $x->id], ['escape' => false, 'confirm' => __('Are you sure you want to delete # {0}?', $x->id)]) ?>
			</td>
		  </tr>
		  <?php endforeach; ?>
		</tbody>
	  </table>
	</div>
	<div class="visible-xs">
	  <p class="text-right">
		<i class="fa fa-sort" aria-hidden="true"></i>
		<?= $this->Paginator->sort('date', __('Date')) ?>
		&nbsp;
		<i class="fa fa-sort" aria-hidden="true"></i>
		<?= $this->Paginator->sort('debit_id', __('Debit')) ?>
		&nbsp;
		<i class="fa fa-sort" aria-hidden="true"></i>
		<?= $this->Paginator->sort('credit_id', __('Credit')) ?>
		&nbsp;
		<i class="fa fa-sort" aria-hidden="true"></i>
		<?= $this->Paginator->sort('amount', __('Amount')) ?>
	  </p>
	  <ul class="list-group">
		<?php foreach ($journals as $x): ?>
		<li class="list-group-item">
		  <span class="badge"><?= number_format($x->amount) ?></span>
		  <h4 class="list-group-item-heading"><?= h($x->date) ?></h4>
		  <p><?= h($x->summary) ?></p>
		  <p><?= h($x->debit->name) . ' / ' . h($x->credit->name) ?>
			<span class="xs-icon" style="float: right">
			  <?= $this->Html->link('<i class="fa fa-list-alt" aria-hidden="true"></i>', ['action' => 'view', $x->id], ['escape' => false]) ?>
			  &nbsp;
			  <?= $this->Html->link('<i class="fa fa-pencil" aria-hidden="true"></i>', ['action' => 'edit', $x->id], ['escape' => false]) ?>
			  &nbsp;
			  <?= $this->Html->link('<i class="fa fa-copy" aria-hidden="true"></i> ', ['action' => 'copy', $x->id], ['escape' => false]) ?>
			  &nbsp;
			  <?= $this->Form->postLink('<i class="fa fa-trash" aria-hidden="true"></i>', ['action' => 'delete', $x->id], ['escape' => false, 'confirm' => __('Are you sure you want to delete # {0}?', $x->id), 'block' => true]) ?>
			</span>
		  </p>
		</li>
		<?php endforeach; ?>
	  </ul>
	</div>
    <?= $this->Paginator->numbers(['prev' => '&lsaquo;', 'next' => '&rsaquo;']) ?>
  </div>
  <div class="col-md-3">
	<div class="list-group">
		<?= $this->Html->link('<i class="fa fa-plus" aria-hidden="true"></i> ' . __('New Journal'), ['action' => 'add'], ['class' => 'list-group-item', 'escape' => false]) ?>
	</div>
    <?= $this->Form->create() ?>
	<fieldset>
	  <?= $this->Form->input('q', ['label' => false, 'placeholder' => __('Search'), 'append' => '<button class="btn btn-default" type="submit"><i class="fa fa-search"></i></button>']) ?>
	</fieldset>
	<?= $this->Form->end() ?>
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
	  <?= $this->Form->input('d', ['label' => __('Debit'), 'showParents' => true, 'options' => $debits, 'multiple' => true]) ?>
	  <?= $this->Form->input('c', ['label' => __('Credit'), 'showParents' => true, 'options' => $credits, 'multiple' => true]) ?>
	  <?= $this->Form->submit(__('Submit'), ['class' => 'btn btn-primary']) ?>
	  <?= $this->Form->end() ?>
	</div>
  </div>
</div>

<?= $this->fetch('postLink') ?>

<?php
$this->prepend('css', $this->Html->css([Configure::read('Css.bootstrapDatepicker'), Configure::read('Css.select2'), Configure::read('Css.select2bootstrap')]));
$this->prepend('script', $this->Html->script([Configure::read('Js.bootstrapDatepicker'), Configure::read('Js.select2')]));
?>

<?php $this->Html->scriptStart(['block' => true]); ?>
$(function() {
	$('#datepicker').datepicker({
		format: "yyyy-mm-dd",
		todayBtn: "linked",
		clearBtn: true,
		calendarWeeks: true,
		orientation: "bottom auto",
		autoclose: true,
		todayHighlight: true
	});

	$('#s').val('<?= $start ?>');
	$('#e').val('<?= $end ?>');

	$.fn.select2.defaults.set("theme", "bootstrap");
	$('#d').select2();
	$('#c').select2();
});
<?php $this->Html->scriptEnd(); ?>
