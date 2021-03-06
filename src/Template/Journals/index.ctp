<?php
/**
  * @var \App\View\AppView $this
  */

use Cake\Core\Configure;

$css = <<<CSS
<style>
.has-margin-side {
  margin-right: .5em;
  margin-left: .5em;
}
</style>
CSS;
$this->append('css', $css);
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
		<?= $this->Html->link('<i class="fas fa-plus" aria-hidden="true"></i> ' . __('New Journal'), ['controller' => 'journals', 'action' => 'add', '?' => ['back' => $back]], ['class' => 'btn btn-default', 'escape' => false]) ?>
	  <a href="#q" class="btn btn-default"><i class="fas fa-search" aria-hidden="true"></i> <?= __('Search') ?></a>
	  <a href="#filter" class="btn btn-default"><i class="fas fa-filter" aria-hidden="true"></i> <?= __('Filter') ?></a>
	  </div>
	</div>
	<?php if ($filter['start'] || $filter['end'] || $filter['debit'] || $filter['credit'] || $filter['keyword']): ?>
	<div class="panel panel-info">
	  <div class="panel-body">
		<?php if ($filter['start'] || $filter['end']): ?>
		<span class="inline-block has-margin-side">
		  <small>
			<strong>
			  <i class="fas fa-filter" aria-hidden="true"></i>
			  <?= __('Scope') ?>
			</strong>
			&nbsp;
			<?= h($filter['start']) ?> &ndash; <?= h($filter['end']) ?>
		  </small>
		</span>
		<?php endif; ?>
		<?php if ($filter['debit']): ?>
		<span class="inline-block has-margin-side">
		  <small>
			<strong>
			  <i class="fas fa-filter" aria-hidden="true"></i>
			  <?= __('Debit') ?>
			</strong>
			&nbsp;
			<?= join('&ensp;', array_values($filter['debit'])) ?>
		  </small>
		</span>
		<?php endif; ?>
		<?php if ($filter['credit']): ?>
		<span class="inline-block has-margin-side">
		  <small>
			<strong>
			  <i class="fas fa-filter" aria-hidden="true"></i>
			  <?= __('Credit') ?>
			</strong>
			&nbsp;
			<?= join('&ensp;', array_values($filter['credit'])) ?>
		  </small>
		</span>
		<?php endif; ?>
		<?php if ($filter['keyword']): ?>
		<span class="inline-block has-margin-side">
		  <small>
			<strong>
			  <i class="fas fa-filter" aria-hidden="true"></i>
			  <?= __('Keyword') ?>
			</strong>
			&nbsp;
			<?= $filter['keyword'] ?>
		  </small>
		</span>
		<?php endif; ?>
	  </div>
	</div>
	<?php endif; ?>
	<div class="hidden-xs">
	  <table class="table table-striped">
		<thead>
		  <tr>
			<th><?= $this->Paginator->sort('id', __('ID')) ?></th>
			<th><?= $this->Paginator->sort('date', __('Date')) ?></th>
			<th><?= $this->Paginator->sort('debit_id', __('Debit')) ?></th>
			<th><?= $this->Paginator->sort('credit_id', __('Credit')) ?></th>
			<th><?= $this->Paginator->sort('amount', __('Amount')) ?></th>
			<th></th>
			<th><?= $this->Paginator->sort('summary', __('Summary')) ?></th>
			<th><?= __('Actions') ?></th>
		  </tr>
		</thead>
		<tbody>
		  <?php foreach ($journals as $x): ?>
		  <tr>
			<td align="right"><?= $x->id ?></td>
			<td><?= h($x->date) ?></td>
			<td><?= $this->Html->link($x->debit->name, ['?' => ['s' => $filter['start'], 'e' => $filter['end'], 'd[]' => $x->debit_id]]) ?></td>
			<td><?= $this->Html->link($x->credit->name, ['?' => ['s' => $filter['start'], 'e' => $filter['end'], 'c[]' => $x->credit_id]]) ?></td>
			<td align="right"><?= number_format($x->amount) ?></td>
			<td>
			  <?= $this->element('Journal/label', ['debit' => $account[$x->debit_id], 'credit' => $account[$x->credit_id]]) ?>
			</td>
			<td><?= h($x->summary) ?></td>
			<td>
			  <?= $this->Html->link('<i class="fas fa-list-alt" aria-hidden="true"></i>', ['action' => 'view', $x->id, '?' => ['back' => $back]], ['escape' => false]) ?>
			  &nbsp;
			  <?= $this->Html->link('<i class="fas fa-edit" aria-hidden="true"></i>', ['action' => 'edit', $x->id, '?' => ['back' => $back]], ['escape' => false]) ?>
			  &nbsp;
			  <?= $this->Html->link('<i class="fas fa-copy" aria-hidden="true"></i> ', ['action' => 'add', '?' => ['b' => $x->id, 'back' => $back]], ['escape' => false]) ?>
			  &nbsp;
			  <?= $this->Form->postLink('<i class="fas fa-trash" aria-hidden="true"></i>', ['action' => 'delete', $x->id, '?' => ['back' => $back]], ['escape' => false, 'confirm' => __('Are you sure you want to delete # {0}?', $x->id)]) ?>
			</td>
		  </tr>
		  <?php endforeach; ?>
		</tbody>
	  </table>
	</div>
	<div class="visible-xs">
	  <p class="text-right">
		<i class="fas fa-sort" aria-hidden="true"></i>
		<?= $this->Paginator->sort('date', __('Date')) ?>
		&nbsp;
		<i class="fas fa-sort" aria-hidden="true"></i>
		<?= $this->Paginator->sort('debit_id', __('Debit')) ?>
		&nbsp;
		<i class="fas fa-sort" aria-hidden="true"></i>
		<?= $this->Paginator->sort('credit_id', __('Credit')) ?>
		&nbsp;
		<i class="fas fa-sort" aria-hidden="true"></i>
		<?= $this->Paginator->sort('amount', __('Amount')) ?>
	  </p>
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
			<?= $this->Html->link($x->debit->name, ['?' => ['s' => $filter['start'], 'e' => $filter['end'], 'd[]' => $x->debit_id]]) ?>
			/
			<?= $this->Html->link($x->credit->name, ['?' => ['s' => $filter['start'], 'e' => $filter['end'], 'c[]' => $x->credit_id]]) ?>
			<span class="xs-icon float-right">
			  <?= $this->Html->link('<i class="fas fa-list-alt" aria-hidden="true"></i>', ['action' => 'view', $x->id, '?' => ['back' => $back]], ['escape' => false]) ?>
			  &nbsp;
			  <?= $this->Html->link('<i class="fas fa-edit" aria-hidden="true"></i>', ['action' => 'edit', $x->id, '?' => ['back' => $back]], ['escape' => false]) ?>
			  &nbsp;
			  <?= $this->Html->link('<i class="fas fa-copy" aria-hidden="true"></i> ', ['action' => 'add', '?' => ['b' => $x->id, 'back' => $back]], ['escape' => false]) ?>
			  &nbsp;
			  <?= $this->Form->postLink('<i class="fas fa-trash" aria-hidden="true"></i>', ['action' => 'delete', $x->id, '?' => ['back' => $back]], ['escape' => false, 'confirm' => __('Are you sure you want to delete # {0}?', $x->id), 'block' => true]) ?>
			</span>
		  </p>
		</li>
		<?php endforeach; ?>
	  </ul>
	</div>
    <?= $this->Paginator->numbers(['prev' => '&lsaquo;', 'next' => '&rsaquo;']) ?>
  </div>
  <div class="col-md-3">
	<?= $this->Form->create(null, ['type' => 'get']) ?>
	<fieldset>
	  <?= $this->Form->input('q', ['label' => false, 'placeholder' => __('Search'), 'append' => '<button class="btn btn-primary" type="submit"><i class="fas fa-search"></i></button>']) ?>
	</fieldset>
	<?= $this->Form->end() ?>
	<div class="list-group">
	  <?= $this->Html->link('<i class="fas fa-plus" aria-hidden="true"></i> ' . __('New Journal'), ['action' => 'add', '?' => ['back' => $back]], ['class' => 'list-group-item', 'escape' => false]) ?>
	</div>
	<div class="list-group">
	  <?= $this->Html->link('<i class="fas fa-chart-bar" aria-hidden="true"></i> ' . __('View Report'), ['controller' => 'reports', 'action' => 'view', '?' => ['s' => $filter['start'], 'e' => $filter['end']]], ['class' => 'list-group-item', 'escape' => false]) ?>
	</div>
	<div id="filter" class="well">
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
	  <?= $this->Form->input('q', ['label' => __('Keyword')]) ?>
	  <?= $this->Form->button('<i class="fas fa-filter" aria-hidden="true"></i> ' . __('Filter'), ['class' => 'btn btn-primary', 'type' => 'submit', 'espace' => false]) ?>
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

	$('#s').val('<?= h($filter['start']) ?>');
	$('#e').val('<?= h($filter['end']) ?>');

	$.fn.select2.defaults.set("theme", "bootstrap");
	$('#d').select2();
	$('#c').select2();
});
<?php $this->Html->scriptEnd(); ?>
