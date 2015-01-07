<div class="pastes view">
<h2><?php echo __('Paste'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($paste['Paste']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($paste['Paste']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Language'); ?></dt>
		<dd>
			<?php echo h($paste['Paste']['language']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Paste'); ?></dt>
		<dd>
			<?php echo h($paste['Paste']['paste']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($paste['Paste']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($paste['Paste']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Paste'), array('action' => 'edit', $paste['Paste']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Paste'), array('action' => 'delete', $paste['Paste']['id']), array(), __('Are you sure you want to delete # %s?', $paste['Paste']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Pastes'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Paste'), array('action' => 'add')); ?> </li>
	</ul>
</div>
