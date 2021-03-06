<?php
/**
 * View/Elements/UserAttributes/edit_formのテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsControllerTestCase', 'NetCommons.TestSuite');

/**
 * View/Elements/UserAttributes/edit_formのテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\UserAttributes\Test\Case\View\Elements\UserAttributes\EditForm
 */
class UserAttributesViewElementsUserAttributesEditFormTest extends NetCommonsControllerTestCase {

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

		//テストコントローラ生成
		$this->generateNc('TestUserAttributes.TestViewElementsUserAttributesEditForm');
	}

/**
 * 共通チェックメソッド
 *
 * @return void
 */
	private function __commonAssert() {
		//チェック
		$pattern = '/' . preg_quote('View/Elements/UserAttributes/edit_form', '/') . '/';
		$this->assertRegExp($pattern, $this->view);

		$this->assertInput('input', 'data[UserAttributeSetting][id]', '1', $this->view);
		$this->assertInput('input', 'data[UserAttributeSetting][row]', '1', $this->view);
		$this->assertInput('input', 'data[UserAttributeSetting][col]', '1', $this->view);
		$this->assertInput('input', 'data[UserAttributeSetting][weight]', '1', $this->view);
		$this->assertInput('input', 'data[UserAttributeSetting][display]', '1', $this->view);
		$this->assertInput('input', 'data[UserAttributeSetting][user_attribute_key]', 'user_attribute_key', $this->view);

		$this->assertInput('input', 'data[UserAttributeSetting][is_system]', null, $this->view);
		$this->assertInput('input', 'data[UserAttributeSetting][display_label]', null, $this->view);
		$this->assertInput('select', 'data[UserAttributeSetting][data_type_key]', null, $this->view);
		$this->assertInput('input', 'data[UserAttributeSetting][is_multilingualization]', null, $this->view);
		$this->assertInput('input', 'data[UserAttributeSetting][required]', null, $this->view);
		$this->assertInput('input', 'data[UserAttributeSetting][only_administrator_readable]', null, $this->view);
		$this->assertInput('input', 'data[UserAttributeSetting][only_administrator_editable]', null, $this->view);
		$this->assertInput('input', 'data[UserAttributeSetting][self_public_setting]', null, $this->view);
		$this->assertInput('input', 'data[UserAttributeSetting][self_email_setting]', null, $this->view);

		$this->assertInput('input', 'data[UserAttribute][0][id]', '1', $this->view);
		$this->assertInput('input', 'data[UserAttribute][0][key]', 'user_attribute_key', $this->view);
		$this->assertInput('input', 'data[UserAttribute][0][language_id]', '1', $this->view);
		$this->assertInput('input', 'data[UserAttribute][0][name]', 'English name', $this->view);
		$this->assertInput('textarea', 'data[UserAttribute][0][description]', 'English description', $this->view);

		$this->assertInput('input', 'data[UserAttribute][1][id]', '2', $this->view);
		$this->assertInput('input', 'data[UserAttribute][1][key]', 'user_attribute_key', $this->view);
		$this->assertInput('input', 'data[UserAttribute][1][language_id]', '2', $this->view);
		$this->assertInput('input', 'data[UserAttribute][1][name]', 'Japanese name', $this->view);
		$this->assertInput('textarea', 'data[UserAttribute][1][description]', 'Japanese description', $this->view);

		$pattern = '/' . preg_quote('data[UserAttribute][2][id]', '/') . '/';
		$this->assertNotRegExp($pattern, $this->view);

		$pattern = '/' . preg_quote('data[UserAttribute][2][name]', '/') . '/';
		$this->assertNotRegExp($pattern, $this->view);
		$pattern = '/' . preg_quote('data[UserAttribute][2][description]', '/') . '/';
		$this->assertNotRegExp($pattern, $this->view);
	}

/**
 * View/Elements/UserAttributes/edit_formのテスト
 *
 * @return void
 */
	public function testEditForm() {
		//テスト実行
		$this->_testGetAction('/test_user_attributes/test_view_elements_user_attributes_edit_form/edit_form',
				array('method' => 'assertNotEmpty'), null, 'view');

		//チェック
		$this->__commonAssert();

		$pattern = '/' . preg_quote('data[UserAttributeSetting][data_type_key_]', '/') . '/';
		$this->assertNotRegExp($pattern, $this->view);
	}

/**
 * UserAttributeSetting.is_system=1のテスト
 *
 * @return void
 */
	public function testEditFormIsSystem() {
		//テスト実行
		$this->_testGetAction('/test_user_attributes/test_view_elements_user_attributes_edit_form/edit_form_is_system',
				array('method' => 'assertNotEmpty'), null, 'view');

		//チェック
		$this->__commonAssert();
		$this->assertInput('input', 'data[UserAttributeSetting][data_type_key]', null, $this->view);
	}

/**
 * UserAttributeSetting.is_system=1のテスト
 *
 * @return void
 */
	public function testEditFormByActionEdit() {
		//テスト実行
		$this->_testGetAction('/test_user_attributes/test_view_elements_user_attributes_edit_form/edit_form_action_edit',
				array('method' => 'assertNotEmpty'), null, 'view');

		//チェック
		$this->__commonAssert();
		$this->assertInput('input', 'data[UserAttributeSetting][data_type_key]', null, $this->view);
	}

}
