<?php
/**
  * @var \App\View\AppView $this
  */
?>
<div class="row">
  <div class="col-md-9">
	<div class="row">
	  <div class="col-md-12">
		<legend><?= h($template->name) ?></legend>
	  </div>
	</div>
	<div class="row">
	  <div class="col-md-6">
		<dl class="dl-horizontal">
		  <dt><?= __('Debit') ?></dt>
		  <dd><?= h($template->debit->name) ?></dd>
		  <dt><?= __('Credit') ?></dt>
		  <dd><?= h($template->credit->name) ?></dd>
		  <dt><?= __('Amount') ?></dt>
		  <dd><?= number_format($template->amount) ?></dd>
		  <dt><?= __('Summary') ?></dt>
		  <dd><?= h($template->summary) ?></dd>
		</dl>
		<dl class="dl-horizontal">
		  <dt><?= __('Description') ?></dt>
          <dd><?= $this->Text->autoParagraph($this->Text->autoLink($template->description)) ?></dd>
		</dl>
	  </div>
	  <div class="col-md-6">
		<dl class="dl-horizontal">
		  <dt><?= __('ID') ?></dt>
          <dd><?= h($template->id) ?></dd>
          <dt><?= __('Created') ?></dt>
          <dd><?= h($template->created) ?></dd>
          <dt><?= __('Modified') ?></dt>
		  <dd><?= h($template->modified) ?></dd>
		</dl>
	  </div>
	</div>
  </div>
  <div class="col-md-3">
	<div class="list-group">
	  <?= $this->Html->link('<i class="fas fa-edit" aria-hidden="true"></i> ' . __('Edit Template'), ['action' => 'edit', $template->id], ['class' => 'list-group-item', 'escape' => false]) ?>
	  <?= $this->Form->postLink('<i class="fas fa-trash" aria-hidden="true"></i> ' . __('Delete Template'), ['action' => 'delete', $template->id], ['confirm' => __('Are you sure you want to delete # {0}?', $template->id), 'class' => 'list-group-item', 'escape' => false]) ?>
	</div>
	<div class="list-group">
	  <?= $this->Html->link('<i class="fas fa-list" aria-hidden="true"></i> ' . __('List Templates'), ['action' => 'index'], ['class' => 'list-group-item', 'escape' => false]) ?>
	</div>
  </div>
</div>
