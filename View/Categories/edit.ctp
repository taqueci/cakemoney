<div class="row">
  <div class="col-md-9">
	<?php echo $this->Form->create('Category', array(
		'inputDefaults' => array(
			'div' => 'form-group',
			'label' => array(
				'class' => 'col col-md-3 control-label'
			),
			'wrapInput' => 'col col-md-9',
			'class' => 'form-control'
		),
		'class' => 'form-horizontal'
	)); ?>
	<fieldset>
	  <legend><?php echo __('Edit Category'); ?></legend>
	  <?php
		echo $this->Form->input('id');
		echo $this->Form->input('name', array('label' => __('Name')));
		echo $this->Form->input('account_id', array('label' => __('Account')));
		echo $this->Form->input('description', array('label' => __('Description'), 'type' => 'textarea'));
	  ?>
	</fieldset>
	<div class="form-group">
	  <?php echo $this->Form->submit(__('Submit'), array(
		  'div' => 'col col-md-9 col-md-offset-3',
		  'class' => 'btn btn-primary'
	  )); ?>
	</div>
	<?php echo $this->Form->end(); ?>
  </div>
  <div class="col-md-3">
	<div class="list-group">
	  <?php echo $this->Html->link($this->element('glyphicon', array('name' => 'th')) . ' ' . __('List Categoris'), array('action' => 'index'), array('class' => 'list-group-item', 'escape' => false)); ?>
	</div>
  </div>
</div>
