<?php
/**
 * UserAttributeLayoutHelper::beforeRender()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsControllerTestCase', 'NetCommons.TestSuite');

/**
 * UserAttributeLayoutHelper::beforeRender()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\UserAttributes\Test\Case\Controller\Component\UserAttributeLayoutHelper
 */
class UserAttributeLayoutHelperBeforeRenderTest extends NetCommonsControllerTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array();

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
	}

/**
 * beforeRender()のテスト
 *
 * @return void
 */
	public function testBeforeRender() {
		//テストコントローラ生成
		$this->generateNc('TestUserAttributes.TestUserAttributeLayoutHelperBeforeRender');

		//テスト実行
		$this->_testGetAction('/test_user_attributes/test_user_attribute_layout_helper_before_render/index',
				array('method' => 'assertNotEmpty'), null, 'view');

		//チェック
		$pattern = '/' . preg_quote('View/Helper/TestUserAttributeLayoutHelperBeforeRender', '/') . '/';
		$this->assertRegExp($pattern, $this->view);

		//cssのURLチェック
		$pattern = '/<link.*?' . preg_quote('/user_attributes/css/style.css', '/') . '.*?>/';
		$this->assertRegExp($pattern, $this->contents);
	}

}
