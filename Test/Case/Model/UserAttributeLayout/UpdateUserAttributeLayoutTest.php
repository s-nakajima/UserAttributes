<?php
/**
 * UserAttributeLayout::updateUserAttributeLayout()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsModelTestCase', 'NetCommons.TestSuite');

/**
 * UserAttributeLayout::updateUserAttributeLayout()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\UserAttributes\Test\Case\Model\UserAttributeLayout
 */
class UserAttributeLayoutUpdateUserAttributeLayoutTest extends NetCommonsModelTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.user_attributes.user_attribute',
		'plugin.user_attributes.user_attribute_choice',
		'plugin.user_attributes.user_attribute_layout',
		'plugin.user_attributes.user_attribute_setting',
	);

/**
 * Plugin name
 *
 * @var string
 */
	public $plugin = 'user_attributes';

/**
 * Model name
 *
 * @var string
 */
	protected $_modelName = 'UserAttributeLayout';

/**
 * Method name
 *
 * @var string
 */
	protected $_methodName = 'updateUserAttributeLayout';

/**
 * updateUserAttributeLayout()のテスト
 *
 * @return void
 */
	public function testUpdateUserAttributeLayout() {
		//データ生成
		$data = array(
			'UserAttributeLayout' => array('id' => '3', 'col' => '2')
		);
		$fieldName = 'col';

		//テスト実施
		$model = $this->_modelName;
		$methodName = $this->_methodName;
		$result = $this->$model->$methodName($data, $fieldName);

		//チェック
		$this->assertTrue($result);
		$actual = $this->$model->find('first', array('recursive' => -1,
			'conditions' => array('id' => $data['UserAttributeLayout']['id'])
		));
		$this->assertEquals($data['UserAttributeLayout']['col'], $actual['UserAttributeLayout']['col']);
	}

/**
 * データエラーのDataProvider
 *
 * ### 戻り値
 *  - data 登録データ
 *  - fieldName フィールド名
 *
 * @return array テストデータ
 */
	public function dataProvider() {
		return array(
			// * 存在しないID
			array(array('UserAttributeLayout' => array('id' => '5', 'col' => '2')), 'col'),
			// * 存在しないフィールド
			array(array('UserAttributeLayout' => array('id' => '5', 'aaaa' => '2')), 'aaaa'),
			// * 数値以外
			array(array('UserAttributeLayout' => array('id' => '1', 'col' => 'aaaa')), 'col'),
		);
	}

/**
 * データエラーのテスト
 *
 * @param array $data 登録データ
 * @param string $fieldName フィールド名
 * @dataProvider dataProvider
 * @return void
 */
	public function testDataError($data, $fieldName) {
		//テスト実施
		$model = $this->_modelName;
		$methodName = $this->_methodName;
		$result = $this->$model->$methodName($data, $fieldName);

		//チェック
		$this->assertFalse($result);
	}

/**
 * ErrorExceptionのテスト
 *
 * @return void
 */
	public function testErrorException() {
		$this->_mockForReturnFalse('UserAttributeLayout', 'UserAttributes.UserAttributeLayout', 'saveField');

		$this->setExpectedException('InternalErrorException');
		//データ生成
		$data = array(
			'UserAttributeLayout' => array('id' => '3', 'col' => '2')
		);
		$fieldName = 'col';

		//テスト実施
		$model = $this->_modelName;
		$methodName = $this->_methodName;
		$this->$model->$methodName($data, $fieldName);
	}

}
