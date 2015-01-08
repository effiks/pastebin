<?php
class AddUserToPastes extends CakeMigration {

/**
 * Migration description
 *
 * @var string
 */
	public $description = 'add_user_to_pastes';

/**
 * Actions to be performed
 *
 * @var array $migration
 */
	public $migration = array(
		'up' => array(
			'create_field' => array(
				'pastes' => array(
					'user_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'index'),
					'indexes' => array(
						'BY_USER_ID' => array('column' => 'user_id', 'unique' => false),
					),
				),
			),
		),
		'down' => array(
			'drop_field' => array(
				'pastes' => array('user_id'),
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
