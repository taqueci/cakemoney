<div class="row">
  <div class="col-md-12">
	<h2><?php echo __('Categories'); ?></h2>
  </div>
</div>
<div class="row">
  <div class="col-md-9">
	<div class="hidden-xs">
	  <table class="table table-striped">
		<thead>
		  <tr>
			<th><?php echo $this->Paginator->sort('id', __('ID')); ?></th>
			<th><?php echo $this->Paginator->sort('name', __('Name')); ?></th>
			<th><?php echo $this->Paginator->sort('account_id', __('Account')); ?></th>
			<th><?php echo $this->Paginator->sort('description', __('Description')); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
		  </tr>
		</thead>
		<tbody>
		  <?php foreach ($categories as $c): ?>
		  <tr>
			<td align="right"><?php echo $c['Category']['id']; ?></td>
			<td><?php echo h($c['Category']['name']); ?></td>
			<td><?php echo h($account[$c['Category']['account_id']]); ?></td>
			<td><?php echo h($c['Category']['description']); ?></td>
			<td class="actions">
			  <?php echo $this->Html->link($this->element('glyphicon', array('name' => 'edit')), array('action' => 'edit', $c['Category']['id']), array('escape' => false)); ?>
			</td>
		  </tr>
		  <?php endforeach; ?>
		</tbody>
	  </table>
	</div>
	<div class="visible-xs">
	  <ul class="list-group">
		<?php foreach ($categories as $c): ?>
		<li class="list-group-item">
		  <h4 class="list-group-item-heading"><?php echo h($c['Category']['name']); ?></h4>
		  <p><?php echo h($c['Category']['description']); ?></p>
		  <p>
			<?php echo $account[$c['Category']['account_id']]; ?>
			<span style="float: right">
			  <?php echo $this->Html->link($this->element('glyphicon', array('name' => 'edit')), array('action' => 'edit', $c['Category']['id']), array('escape' => false)); ?>
			</span>
		  </p>
		</li>
		<?php endforeach; ?>
	  </ul>
	</div>
	<div class="paging">
	  <?php echo $this->Paginator->pagination(array('ul' => 'pagination')); ?>
	</div>
  </div>
  <div class="col-md-3">
	<div class="list-group">
		<?php echo $this->Html->link($this->element('glyphicon', array('name' => 'plus')) . ' ' . __('New Category'), array('action' => 'add'), array('class' => 'list-group-item', 'escape' => false)); ?>
	</div>

	<?php echo $this->Form->create('Category', array(
			'action' => 'index',
			'inputDefaults' => array(
				'div' => 'form-group',
				'wrapInput' => false,
				'class' => 'form-control'
			),
			'class' => 'well'
		)); ?>
	<fieldset>
	  <?php echo $this->Form->input('keyword', array(
			'label' => false,
			'beforeInput' => '<div class="input-group"><span class="input-group-addon">' . $this->element('glyphicon', array('name' => 'search')) . '</span>',
			'afterInput' => '</div>',
			'placeholder' => 'Search',
		)); ?>
	  <?php echo $this->Form->submit(__('Search'), array(
			'div' => 'form-group',
			'class' => 'btn btn-default'
		)); ?>
	</fieldset>
	<?php echo $this->Form->end(); ?>

  </div>
</div>
