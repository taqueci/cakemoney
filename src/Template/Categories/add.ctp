<?php
/**
  * @var \App\View\AppView $this
  */
?>
<div class="row">
  <div class="col-md-9 has-margin-bottom">
	<?= $this->Form->create($category) ?>
	<fieldset>
	  <legend><?= __('Add Category') ?></legend>
	  <?= $this->Form->input('name', ['label' => __('Name')]) ?>
	  <?= $this->Form->input('account', ['label' => __('Account')]) ?>
	  <?= $this->Form->input('description', ['label' => __('Description'), 'type' => 'textarea']) ?>
	</fieldset>
	<?= $this->Form->button('<i class="fa fa-check" aria-hidden="true"></i> ' . __('Submit'), ['class' => 'btn btn-primary', 'type' => 'submit', 'espace' => false]) ?>
	<?= $this->Form->end() ?>
  </div>
  <div class="col-md-3">
	<div class="list-group">
	  <?= $this->Html->link('<i class="fa fa-list" aria-hidden="true"></i> ' . __('List Categoris'), ['action' => 'index'], ['class' => 'list-group-item', 'escape' => false]) ?>
	</div>
  </div>
</div>
