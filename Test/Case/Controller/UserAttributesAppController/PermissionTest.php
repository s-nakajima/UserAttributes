<?php
/**
 * アクセス権限(Permission)のテスト
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
 * アクセス権限(Permission)のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\UserAttributes\Test\Case\Controller\UserAttributesAppController
 */
class UserAttributesAppControllerPermissionTest extends NetCommonsControllerTestCase {

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
		$this->generateNc('TestUserAttributes.TestUserAttributesAppControllerPermission');
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
 * アクセスチェック用DataProvider
 *
 * ### 戻り値
 *  - role 会員権限、nullはログインなし
 *  - exception Exception文字列
 *
 * @return array
 */
	public function dataProvider() {
		$results = array();

		//テストデータ
		// * ログインなし
		$results[0] = array('role' => null, 'exception' => 'ForbiddenException');
		// * 一般権限
		$results[1] = array('role' => UserRole::USER_ROLE_KEY_COMMON_USER, 'exception' => 'ForbiddenException');
		// * サイト権限
		$results[2] = array('role' => UserRole::USER_ROLE_KEY_ADMINISTRATOR, 'exception' => false);
		// * システム権限
		$results[3] = array('role' => UserRole::USER_ROLE_KEY_SYSTEM_ADMINISTRATOR, 'exception' => false);

		return $results;
	}

/**
 * アクセスチェック
 *
 * @param string|null $role 会員権限、nullはログインなし
 * @param string $exception Exception文字列
 * @dataProvider dataProvider
 * @return void
 */
	public function testPermission($role, $exception) {
		if (isset($role)) {
			TestAuthGeneral::login($this, $role);
		}

		//テスト実行
		$this->_testGetAction('/test_user_attributes/test_user_attributes_app_controller_permission/index',
				array('method' => 'assertNotEmpty'), $exception, 'view');
	}

}
