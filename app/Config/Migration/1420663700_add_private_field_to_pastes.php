<?php
class AddPrivateFieldToPastes extends CakeMigration {

/**
 * Migration description
 *
 * @var string
 */
	public $description = 'add_private_field_to_pastes';

/**
 * Actions to be performed
 *
 * @var array $migration
 */
	public $migration = array(
		'up' => array(
			'create_field' => array(
				'pastes' => array(
					'private' => array('type' => 'boolean', 'null' => false, 'default' => null),
				),
			),
		),
		'down' => array(
			'drop_field' => array(
				'pastes' => array('private'),
			),
		),
	);

/**
 * Before migration callback
 *
 * @param string $direction Direction of migration process (up or down)
 * @return bool Should process continue
 */
	public function before($direction) {
		return true;
	}

/**
 * After migration callback
 *
 * @param string $direction Direction of migration process (up or down)
 * @return bool Should process continue
 */
	public function after($direction) {
		return true;
	}
}
