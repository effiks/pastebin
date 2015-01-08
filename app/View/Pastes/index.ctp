<div class="pastes index">
	<h2><?php echo __('Pastes'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<thead>
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('name'); ?></th>
			<th><?php echo $this->Paginator->sort('language'); ?></th>
			<th><?php echo $this->Paginator->sort('paste'); ?></th>
			<th><?php echo $this->Paginator->sort('user_id'); ?></th>
			<th><?php echo $this->Paginator->sort('modified'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($pastes as $paste): ?>
	<tr>
		<td><?php echo h($paste['Paste']['id']); ?>&nbsp;</td>
		<td><?php echo h($paste['Paste']['name']); ?>&nbsp;</td>
		<td><?php echo h($paste['Paste']['language']); ?>&nbsp;</td>
		<td><?php echo h($paste['Paste']['paste']); ?>&nbsp;</td>
		<td><?php echo h($paste['Paste']['user_id']); ?>&nbsp;</td>
		<td><?php echo h($paste['Paste']['modified']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $paste['Paste']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $paste['Paste']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $paste['Paste']['id']), array(), __('Are you sure you want to delete # %s?', $paste['Paste']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</tbody>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>
	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Paste'), array('action' => 'add')); ?></li>
	</ul>
</div>
