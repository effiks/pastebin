<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
App::uses('Controller', 'Controller');
App::uses('CrudControllerTrait', 'Crud.Lib');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @property 	CrudComponent $Crud
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {

	use CrudControllerTrait;

/**
 * List of global controller components
 *
 * @var array
 */
	public $components = [
		'RequestHandler',
		'Session',
		'Auth' => [
			'authenticate' => [
				'Form' => ['passwordHasher' => 'Blowfish']
			],
			'authorize' => ['Controller'],
			'flash' => [
				'element' => 'default',
				'key' => 'flash',
				'params' => []
			],
			'loginRedirect' => [
				'controller' => 'pastes', 'action' => 'index'
			],
			'logoutRedirect' => [
				'controller' => 'pages', 'action' => 'display', 'home'
			]
		],
		'Crud.Crud' => [
			'listeners' => [
				'Crud.Api',
				'Crud.ApiPagination',
				'Crud.ApiQueryLog'
			]
		],
		'Paginator' => [
			'settings' => ['paramType' => 'querystring', 'limit' => 30]
		]
	];

	/*function __construct($request = null, $response = null) {
		if (Configure::read('debug')) {
			$this->components['DebugKit.Toolbar'] = [
				'panels' => ['ConfigurePanel.Configure']
			];
		}
		parent::__construct($request, $response);
	}*/

	public function beforeFilter() {
		parent::beforeFilter();
		// other beforeFilter() logic here

		// Allow users access to display action
		// in the PagesController
		$this->Auth->allow('display');
	}

	public function isAuthorized($user = null) {
		return true;
	}

}
