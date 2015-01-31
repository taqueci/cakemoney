<div class="row">
  <div class="col-md-9">
	<?php echo $this->Form->create('Journal', array(
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
	  <legend><?php echo __('Add Journal'); ?></legend>
	  <div align="right" style="margin-bottom: 15px">
		<?php echo $this->element('categoryfilter', array('debit' => '#JournalDebitId', 'credit' => '#JournalCreditId', 'account' => $account)); ?>
	  </div>
	  <?php
		echo $this->Form->input('debit_id', array('label' => __('Debit'), 'showParents' => true));
		echo $this->Form->input('credit_id', array('label' => __('Credit'), 'showParents' => true));
		echo $this->Form->input('date', array(
			'label' => __('Date'), 'type'=>'text',
			'beforeInput' => '<div id="input-date" class="input-group date">',
			'afterInput' => '<span class="input-group-addon">' . $this->element('glyphicon', array('name' => 'calendar')) . '</span></div>',
		));
		echo $this->Form->input('amount', array('label' => __('Amount')));
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
	  <?php echo $this->Html->link($this->element('glyphicon', array('name' => 'th')) . ' ' . __('List Journals'), array('action' => 'index'), array('class' => 'list-group-item', 'escape' => false)); ?>
	</div>
  </div>
</div>

<?php $this->Html->script('bootstrap-datepicker', array('inline' => false)); ?>
<?php $this->Html->scriptBlock($this->element('datepicker', array('id' => '#input-date')), array('inline' => false)); ?>

