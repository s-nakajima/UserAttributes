<?php
/**
 * UserAttributeLayout::validate()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsValidateTest', 'NetCommons.TestSuite');
App::uses('UserAttributeLayoutFixture', 'UserAttributes.Test/Fixture');

/**
 * UserAttributeLayout::validate()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\UserAttributes\Test\Case\Model\UserAttributeLayout
 */
class UserAttributeLayoutValidateTest extends NetCommonsValidateTest {

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
	protected $_methodName = 'validates';

/**
 * ValidationErrorのDataProvider
 *
 * ### 戻り値
 *  - data 登録データ
 *  - field フィールド名
 *  - value セットする値
 *  - message エラーメッセージ
 *  - overwrite 上書きするデータ(省略可)
 *
 * @return array テストデータ
 */
	public function dataProviderValidationError() {
		$data['UserAttributeLayout'] = (new UserAttributeLayoutFixture())->records[0];

		return array(
			array('data' => $data, 'field' => 'col', 'value' => null,
				'message' => __d('net_commons', 'Invalid request.')),
			array('data' => $data, 'field' => 'col', 'value' => 'aaaa',
				'message' => __d('net_commons', 'Invalid request.')),
			array('data' => $data, 'field' => 'col', 'value' => -1,
				'message' => __d('net_commons', 'Invalid request.')),
			array('data' => $data, 'field' => 'col', 'value' => 3,
				'message' => __d('net_commons', 'Invalid request.')),
		);
	}

}
