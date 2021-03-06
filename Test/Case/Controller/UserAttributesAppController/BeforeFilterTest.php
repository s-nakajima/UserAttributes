<?php
/**
 * UserAttributesAppController::beforeFilter()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsControllerTestCase', 'NetCommons.TestSuite');
App::uses('UserRole', 'UserRoles.Model');

/**
 * UserAttributesAppController::beforeFilter()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\UserAttributes\Test\Case\Controller\UserAttributesAppController
 */
class UserAttributesAppControllerBeforeFilterTest extends NetCommonsControllerTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.user_attributes.plugin4permission',
		'plugin.user_attributes.plugins_role4permission',
	);

/**
 * Plugin name
 *
 * @var string
 */
	public $plugin = 'user_attributes';

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();

		//テストプラグインのロード
		NetCommonsCakeTestCase::loadTestPlugin($this, 'UserAttributes', 'TestUserAttributes');
		$this->generateNc('TestUserAttributes.TestUserAttributesAppControllerIndex');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		//ログアウト
		TestAuthGeneral::logout($this);

		parent::tearDown();
	}

/**
 * beforeFilter()のテスト
 *
 * @return void
 */
	public function testBeforeFilter() {
		//ログイン
		TestAuthGeneral::login($this);

		//テスト実行
		$this->_testGetAction('/test_user_attributes/test_user_attributes_app_controller_index/index',
				array('method' => 'assertNotEmpty'), null, 'view');

		//チェック
		$pattern = '/' . preg_quote('Controller/UserAttributesAppController', '/') . '/';
		$this->assertRegExp($pattern, $this->view);
	}

/**
 * ログインなしのテスト
 *
 * @return void
 */
	public function testBeforeFilterNoLogin() {
		//テスト実行
		$this->_testGetAction('/test_user_attributes/test_user_attributes_app_controller_index/index',
				null, 'ForbiddenException', 'view');
	}

}
