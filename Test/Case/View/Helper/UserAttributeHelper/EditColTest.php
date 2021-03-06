<?php
/**
 * UserAttributeHelper::editCol()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsHelperTestCase', 'NetCommons.TestSuite');
App::uses('UserAttributeLayout', 'UserAttributes.Model');
class_exists('UserAttributeLayout'); // phpunitでエラーになるため

/**
 * UserAttributeHelper::editCol()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\UserAttributes\Test\Case\View\Helper\UserAttributeHelper
 */
class UserAttributeHelperEditColTest extends NetCommonsHelperTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.user_attributes.user_attribute_layout',
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

		//テストデータ生成
		$viewVars = array();
		$requestData = array();

		//Helperロード
		$this->loadHelper('UserAttributes.UserAttribute', $viewVars, $requestData);
	}

/**
 * editCol()のテスト
 *
 * @return void
 */
	public function testEditCol() {
		//データ生成
		$layout = array(
			'UserAttributeLayout' => array('id' => '1', 'col' => '2')
		);

		//テスト実施
		$result = $this->UserAttribute->editCol($layout);

		//チェック
		$this->assertInput('form', null, '/user_attribute_layouts/edit/1', $result);
		$this->assertInput('input', '_method', 'PUT', $result);
		$this->assertInput('input', 'data[UserAttributeLayout][id]', '1', $result);
		$this->assertInput('select', 'data[UserAttributeLayout][col]', null, $result);
		$this->assertInput('option', '1', null, $result);
		$this->assertInput('option', '2', 'selected', $result);
	}

}
