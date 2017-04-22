<?php
/**
  * @var \App\View\AppView $this
  */
?>
<div class="row">
  <div class="col-md-9">
	<div class="row">
	  <div class="col-md-12">
		<legend><?= h($journal->summary) ?></legend>
	  </div>
	</div>
	<div class="row">
	  <div class="col-md-6">
		<dl class="dl-horizontal">
		  <dt><?= __('Date') ?></dt>
          <dd><?= h($journal->date) ?></dd>
		  <dt><?= __('Debit') ?></dt>
		  <dd><?= h($journal->debit->name) ?></dd>
		  <dt><?= __('Credit') ?></dt>
		  <dd><?= h($journal->credit->name) ?></dd>
		  <dt><?= __('Amount') ?></dt>
		  <dd><?= number_format($journal->amount) ?></dd>
		</dl>
		<dl class="dl-horizontal">
		  <dt><?= __('Description') ?></dt>
          <dd><?= $this->Text->autoParagraph($this->Text->autoLink($journal->description)) ?></dd>
		</dl>
	  </div>
	  <div class="col-md-6">
		<dl class="dl-horizontal">
		  <dt><?= __('ID') ?></dt>
          <dd><?= h($journal->id) ?></dd>
          <dt><?= __('Created') ?></dt>
          <dd><?= h($journal->created) ?></dd>
          <dt><?= __('Modified') ?></dt>
		  <dd><?= h($journal->modified) ?></dd>
		</dl>
		<dl class="dl-horizontal">
          <dt><?= __('Asset') ?></dt>
          <dd><?= number_format($journal->asset) ?></dd>
          <dt><?= __('Liability') ?></dt>
          <dd><?= number_format($journal->liability) ?></dd>
          <dt><?= __('Income') ?></dt>
          <dd><?= number_format($journal->income) ?></dd>
            <dt><?= __('Expense') ?></dt>
          <dd><?= number_format($journal->expense) ?></dd>
          <dt><?= __('Equity') ?></dt>
          <dd><?= number_format($journal->equity) ?></dd>
		</dl>
	  </div>
	</div>
  </div>
  <div class="col-md-3">
	<div class="list-group">
	  <?= $this->Html->link('<i class="fa fa-pencil" aria-hidden="true"></i> ' . __('Edit Journal'), ['action' => 'edit', $journal->id, '?' => ['back' => $back]], ['class' => 'list-group-item', 'escape' => false]) ?>
	  <?= $this->Html->link('<i class="fa fa-copy" aria-hidden="true"></i> ' . __('Copy Journal'), ['action' => 'add', '?' => ['b' => $journal->id, 'back' => $back]], ['class' => 'list-group-item', 'escape' => false]) ?>
	  <?= $this->Form->postLink('<i class="fa fa-trash" aria-hidden="true"></i> ' . __('Delete Journal'), ['action' => 'delete', $journal->id], ['confirm' => __('Are you sure you want to delete # {0}?', $journal->id), 'class' => 'list-group-item', 'escape' => false]) ?>
	</div>
	<div class="list-group">
	  <?= $this->Html->link('<i class="fa fa-list" aria-hidden="true"></i> ' . __('List Journals'), ['action' => 'index'], ['class' => 'list-group-item', 'escape' => false]) ?>
	</div>
  </div>
</div>
