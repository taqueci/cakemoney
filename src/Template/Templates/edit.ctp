<?php
/**
  * @var \App\View\AppView $this
  */

use Cake\Core\Configure;
?>
<div class="row">
  <div class="col-md-9 has-margin-bottom">
    <?= $this->Form->create($template) ?>
	<fieldset>
	  <legend><?= __('Edit Template') ?></legend>
	  <?= $this->Form->input('id') ?>
	  <div class="has-margin-bottom" align="right">
		<?= $this->element('Category/filter', ['debit_id' => '#debit-id', 'credit_id' => '#credit-id']) ?>
	  </div>
	  <?= $this->Form->input('name', ['label' => __('Name')]) ?>
	  <?= $this->Form->input('debit_id', ['label' => __('Debit'), 'showParents' => true]) ?>
	  <?= $this->Form->input('credit_id', ['label' => __('Credit'), 'showParents' => true]) ?>
	  <?= $this->Form->input('amount', ['label' => __('Amount')]) ?>
	  <?= $this->Form->input('summary', ['label' => __('Summary')]) ?>
	  <?= $this->Form->input('description', ['label' => __('Description'), 'type' => 'textarea']) ?>
	</fieldset>
	<?= $this->Form->button('<i class="fa fa-check" aria-hidden="true"></i> ' . __('Submit'), ['class' => 'btn btn-primary', 'type' => 'submit', 'espace' => false]) ?>
	<?= $this->Form->end() ?>
  </div>
  <div class="col-md-3">
	<div class="list-group">
	  <?= $this->Html->link('<i class="fa fa-list" aria-hidden="true"></i> ' . __('List Templates'), ['action' => 'index'], ['class' => 'list-group-item', 'escape' => false]) ?>
	</div>
  </div>
</div>

<?php $this->Html->scriptStart(['block' => true]); ?>
function setCategory(did, cid) {
	category_filter_reset();

	$('#debit-id').val(did);
	$('#credit-id').val(cid);
}
<?php $this->Html->scriptEnd(); ?>
