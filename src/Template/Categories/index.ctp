<?php
/**
  * @var \App\View\AppView $this
  */
?>
<div class="row">
  <div class="col-md-12">
	<h2><?= __('Categories') ?></h2>
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
			<th><?= $this->Paginator->sort('account_id', __('Account')) ?></th>
			<th><?= $this->Paginator->sort('description', __('Description')) ?></th>
			<th><?= __('Actions') ?></th>
		  </tr>
		</thead>
		<tbody>
		  <?php foreach ($categories as $x): ?>
		  <tr>
			<td class="text-right"><?= $x->id ?></td>
			<td><?= h($x->name) ?></td>
			<td><?= h($account[$x->account]) ?></td>
			<td><?= h($x->description) ?></td>
			<td>
			  <?= $this->Html->link('<i class="fa fa-pencil" aria-hidden="true"></i>', ['action' => 'edit', $x->id], ['escape' => false]) ?>
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
		<?= $this->Paginator->sort('account_id', __('Account')) ?>
	  </p>
	  <ul class="list-group">
		<?php foreach ($categories as $x): ?>
		<li class="list-group-item">
		  <h4 class="list-group-item-heading"><?= h($x->name) ?></h4>
		  <p><?= h($x->description) ?></p>
		  <p>
			<?= $account[$x->account] ?>
			<span style="float: right">
			  <?= $this->Html->link('<i class="fa fa-pencil" aria-hidden="true"></i>', array('action' => 'edit', $x->id), array('escape' => false)) ?>
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
		<?= $this->Html->link('<i class="fa fa-plus" aria-hidden="true"></i> ' . __('New Category'), array('action' => 'add'), array('class' => 'list-group-item', 'escape' => false)) ?>
	</div>
	<div class="well">
      <?= $this->Form->create() ?>
	  <fieldset>
		<?= $this->Form->input('q', ['label' => false, 'placeholder' => __('Search'), 'append' => '<button class="btn btn-default" type="button"><i class="fa fa-search"></i></button>']) ?>
	  </fieldset>
	  <?= $this->Form->end() ?>
	</div>
  </div>
</div>
