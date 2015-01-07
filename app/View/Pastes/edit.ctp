<div class="pastes form">
<?php echo $this->Form->create('Paste'); ?>
	<fieldset>
		<legend><?php echo __('Edit Paste'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name');
		echo $this->Form->input('private');
		echo $this->Form->input('language');
		echo $this->Form->input('paste');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Paste.id')), array(), __('Are you sure you want to delete # %s?', $this->Form->value('Paste.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Pastes'), array('action' => 'index')); ?></li>
	</ul>
</div>
