<?php
/**
  * @var \App\View\AppView $this
  */
?>
<div class="row">
  <div class="col-md-12">
	<h2><?= __('Templates') ?></h2>
  </div>
</div>
<div class="row">
  <div class="col-md-9">
	<div class="hidden-xs">
	  <table class="table table-striped">
		<thead>
		  <tr>
            <th><?= $this->Paginator->sort('id', __('ID')) ?></th>
            <th><?= $this->Paginator->sort('name', __('Name')) ?></th>
            <th><?= $this->Paginator->sort('debit_id', __('Debit')) ?></th>
            <th><?= $this->Paginator->sort('credit_id', __('Credit')) ?></th>
            <th><?= $this->Paginator->sort('amount', __('Amount')) ?></th>
            <th><?= $this->Paginator->sort('summary', __('Summary')) ?></th>
			<th><?= __('Actions') ?></th>
		  </tr>
		</thead>
		<tbody>
		  <?php foreach ($templates as $x): ?>
		  <tr>
			<td class="text-right"><?= $x->id ?></td>
			<td><?= h($x->name) ?></td>
			<td><?= h($x->debit->name) ?></td>
			<td><?= h($x->credit->name) ?></td>
			<td align="right"><?= number_format($x->amount) ?></td>
			<td><?= h($x->summary) ?></td>
			<td>
			  <?= $this->Html->link('<i class="fa fa-list-alt" aria-hidden="true"></i>', ['action' => 'view', $x->id], ['escape' => false]) ?>
			  &nbsp;
			  <?= $this->Html->link('<i class="fa fa-pencil" aria-hidden="true"></i>', ['action' => 'edit', $x->id], ['escape' => false]) ?>
			  &nbsp;
			  <?= $this->Form->postLink('<i class="fa fa-trash" aria-hidden="true"></i>', ['action' => 'delete', $x->id], ['escape' => false, 'confirm' => __('Are you sure you want to delete # {0}?', $x->id), 'block' => true]) ?>
			</td>
		  </tr>
		  <?php endforeach; ?>
		</tbody>
	  </table>
	</div>
	<div class="visible-xs">
	  <p class="text-right">
		<i class="fa fa-sort" aria-hidden="true"></i>
		<?= $this->Paginator->sort('id', __('ID')) ?>
		&nbsp;
		<i class="fa fa-sort" aria-hidden="true"></i>
		<?= $this->Paginator->sort('name', __('Name')) ?>
		&nbsp;
		<i class="fa fa-sort" aria-hidden="true"></i>
		<?= $this->Paginator->sort('amount', __('Amount')) ?>
	  </p>
	  <ul class="list-group">
		<?php foreach ($templates as $x): ?>
		<li class="list-group-item">
		  <span class="float-right">
			<strong><?= number_format($x->amount) ?></strong>
		  </span>
		  <h4 class="list-group-item-heading"><?= h($x->name) ?></h4>
		  <p><?= h($x->summary) ?></p>
		  <p><?= h($x->debit->name) . ' / ' . h($x->credit->name) ?>
			<span class="xs-icon" style="float: right">
			  <?= $this->Html->link('<i class="fa fa-list-alt" aria-hidden="true"></i>', ['action' => 'view', $x->id], ['escape' => false]) ?>
			  &nbsp;
			  <?= $this->Html->link('<i class="fa fa-pencil" aria-hidden="true"></i>', ['action' => 'edit', $x->id], ['escape' => false]) ?>
			  &nbsp;
			  <?= $this->Html->link('<i class="fa fa-copy" aria-hidden="true"></i> ', ['action' => 'add'], ['escape' => false]) ?>
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
		<?= $this->Html->link('<i class="fa fa-plus" aria-hidden="true"></i> ' . __('New Template'), array('action' => 'add'), array('class' => 'list-group-item', 'escape' => false)) ?>
	</div>
    <?= $this->Form->create() ?>
	<fieldset>
	  <?= $this->Form->input('q', ['label' => false, 'placeholder' => __('Search'), 'append' => '<button class="btn btn-primary" type="button"><i class="fa fa-search"></i></button>']) ?>
	</fieldset>
	<?= $this->Form->end() ?>
  </div>
</div>
