<div class="row">
  <div class="col-md-12">
	<h2><?php echo __('Journals'); ?></h2>
  </div>
</div>
<div class="row">
  <div class="col-md-9">
	<div class="hidden-xs">
	  <table class="table table-striped">
		<thead>
		  <tr>
			<th><?php echo $this->Paginator->sort('id', __('ID')); ?></th>
			<th><?php echo $this->Paginator->sort('date', __('Date')); ?></th>
			<th><?php echo $this->Paginator->sort('debit_id', __('Debit')); ?></th>
			<th><?php echo $this->Paginator->sort('credit_id', __('Credit')); ?></th>
			<th><?php echo $this->Paginator->sort('amount', __('Amount')); ?></th>
			<th><?php echo $this->Paginator->sort('description', __('Description')); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
		  </tr>
		</thead>
		<tbody>
		  <?php foreach ($journals as $journal): ?>
		  <tr>
			<td align="right"><?php echo $journal['Journal']['id']; ?></td>
			<td><?php echo $journal['Journal']['date']; ?></td>
			<td><?php echo h($journal['Debit']['name']); ?></td>
			<td><?php echo h($journal['Credit']['name']); ?></td>
			<td align="right"><?php echo number_format($journal['Journal']['amount']); ?></td>
			<td><?php echo nl2br(h($journal['Journal']['description'])); ?></td>
			<td class="actions">
			  <?php echo $this->Html->link($this->element('glyphicon', array('name' => 'edit')), array('action' => 'edit', $journal['Journal']['id']), array('escape' => false)); ?>
			  <?php echo $this->Form->postLink($this->element('glyphicon', array('name' => 'remove')), array('action' => 'delete', $journal['Journal']['id']), array('escape' => false), __('Are you sure you want to delete # %s?', $journal['Journal']['id'])); ?>
			</td>
		  </tr>
		  <?php endforeach; ?>
		</tbody>
	  </table>
	</div>
	<div class="visible-xs">
	  <ul class="list-group">
		<?php foreach ($journals as $journal): ?>
		<li class="list-group-item">
		  <span class="badge"><?php echo number_format($journal['Journal']['amount']); ?></span>
		  <h4 class="list-group-item-heading"><?php echo h($journal['Journal']['date']); ?></h4>
		  <p><?php echo nl2br(h($journal['Journal']['description'])); ?></p>
		  <p><?php echo $journal['Debit']['name'] . ' / ' . $journal['Credit']['name']; ?>
			<span style="float: right">
			  <?php echo $this->Html->link($this->element('glyphicon', array('name' => 'edit')), array('action' => 'edit', $journal['Journal']['id']), array('escape' => false)); ?>
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
		<?php echo $this->Html->link($this->element('glyphicon', array('name' => 'plus')) . ' ' . __('New Journal'), array('action' => 'add'), array('class' => 'list-group-item', 'escape' => false)); ?>
	</div>

	<?php echo $this->Form->create('Journal', array(
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
