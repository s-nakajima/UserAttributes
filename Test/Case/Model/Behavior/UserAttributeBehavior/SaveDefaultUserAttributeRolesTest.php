<?php
/**
 * UserAttributeBehavior::saveDefaultUserAttributeRoles()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsModelTestCase', 'NetCommons.TestSuite');
App::uses('UserAttributeSettingFixture', 'UserAttributes.Test/Fixture');
App::uses('UserAttribute', 'UserAttributes.Model');
App::uses('DataType', 'DataTypes.Model');

/**
 * UserAttributeBehavior::saveDefaultUserAttributeRoles()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\UserAttributes\Test\Case\Model\Behavior\UserAttributeBehavior
 */
class UserAttributeBehaviorSaveDefaultUserAttributeRolesTest extends NetCommonsModelTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.user_attributes.plugin4test',
		'plugin.user_attributes.plugins_role4test',
		'plugin.user_roles.user_attributes_role',
		'plugin.user_roles.user_role_setting',
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
		$this->TestModel = ClassRegistry::init('TestUserAttributes.TestUserAttributeBehaviorModel');
	}

/**
 * テストデータセット
 *
 * @param string $userAttributeKey UserAttribute.key
 * @param array $sysAdmin システム管理者の期待値
 * @param array $admin 管理者の期待値
 * @param array $commonUser 一般の期待値
 * @return void
 */
	private function __data($userAttributeKey, $sysAdmin = array(), $admin = array(), $commonUser = array()) {
		$data['UserAttributeSetting'] = (new UserAttributeSettingFixture())->records[0];
		$data['UserAttributeSetting']['user_attribute_key'] = $userAttributeKey;
		if ($userAttributeKey === UserAttribute::PASSWORD_FIELD) {
			$data['UserAttributeSetting']['data_type_key'] = DataType::DATA_TYPE_PASSWORD;
		} elseif ($userAttributeKey === 'label_test') {
			$data['UserAttributeSetting']['data_type_key'] = DataType::DATA_TYPE_LABEL;
		} else {
			$data['UserAttributeSetting']['data_type_key'] = DataType::DATA_TYPE_TEXT;
		}
		$data['UserAttributeSetting']['only_administrator_readable'] = false;
		$data['UserAttributeSetting']['only_administrator_editable'] = false;

		$expected = array(
			0 => array('UserAttributesRole' => Hash::merge(array(
				'id' => '5', 'role_key' => 'system_administrator',
				'user_attribute_key' => $userAttributeKey,
			), $sysAdmin)),
			1 => array('UserAttributesRole' => Hash::merge(array(
				'id' => '6', 'role_key' => 'administrator',
				'user_attribute_key' => $userAttributeKey,
			), $admin)),
			2 => array('UserAttributesRole' => Hash::merge(array(
				'id' => '7', 'role_key' => 'common_user',
				'user_attribute_key' => $userAttributeKey,
			), $commonUser)),
			3 => array('UserAttributesRole' => Hash::merge(array(
				'id' => '8', 'role_key' => 'test_user',
				'user_attribute_key' => $userAttributeKey,
			), $commonUser)),
		);

		return array('data' => $data, 'expected' => $expected);
	}

/**
 * チェック用データ取得
 *
 * @param string $userAttrKey user_attribute_key
 * @return void
 */
	private function __actual($userAttrKey) {
		$actual = array();
		$actual = $this->TestModel->UserAttributesRole->find('all', array(
			'recursive' => -1,
			'conditions' => array('user_attribute_key' => $userAttrKey),
			'order' => array('id' => 'asc'),
		));
		$actual = Hash::remove($actual, '{n}.{s}.modified');
		$actual = Hash::remove($actual, '{n}.{s}.modified_user');
		$actual = Hash::remove($actual, '{n}.{s}.created');
		$actual = Hash::remove($actual, '{n}.{s}.created_user');

		return $actual;
	}

/**
 * saveDefaultUserAttributeRoles()テストのDataProvider
 *
 * ### 戻り値
 *  - data 登録データ
 *  - expected 期待値データ
 *
 * @return array データ
 */
	public function dataProvider() {
		$data = array();

		// * パスワード＝自分／他人とも読み取り不可
		$data[0] = $this->__data(UserAttribute::PASSWORD_FIELD,
			array('self_readable' => false, 'self_editable' => true, 'other_readable' => false, 'other_editable' => true),
			array('self_readable' => false, 'self_editable' => true, 'other_readable' => false, 'other_editable' => true),
			array('self_readable' => false, 'self_editable' => true, 'other_readable' => false, 'other_editable' => false)
		);
		// * ラベル項目＝自分／他人とも書き込み不可
		$data[1] = $this->__data('label_test',
			array('self_readable' => true, 'self_editable' => false, 'other_readable' => true, 'other_editable' => false),
			array('self_readable' => true, 'self_editable' => false, 'other_readable' => true, 'other_editable' => false),
			array('self_readable' => true, 'self_editable' => false, 'other_readable' => false, 'other_editable' => false)
		);
		// * ハンドル＝自分は、読み・書き可。他人は、読み取り可／書き込み不可。
		$data[2] = $this->__data(UserAttribute::AVATAR_FIELD,
			array('self_readable' => true, 'self_editable' => true, 'other_readable' => true, 'other_editable' => true),
			array('self_readable' => true, 'self_editable' => true, 'other_readable' => true, 'other_editable' => true),
			array('self_readable' => true, 'self_editable' => true, 'other_readable' => true, 'other_editable' => false)
		);
		// * アバター＝自分は、読み・書き可。他人は、読み取り可／書き込み不可。
		$data[3] = $this->__data(UserAttribute::HANDLENAME_FIELD,
			array('self_readable' => true, 'self_editable' => true, 'other_readable' => true, 'other_editable' => true),
			array('self_readable' => true, 'self_editable' => true, 'other_readable' => true, 'other_editable' => true),
			array('self_readable' => true, 'self_editable' => true, 'other_readable' => true, 'other_editable' => false)
		);
		// * 上記以外＝自分は、読み・書き可。他人は、読み・書き不可。
		$data[4] = $this->__data('test2',
			array('self_readable' => true, 'self_editable' => true, 'other_readable' => true, 'other_editable' => true),
			array('self_readable' => true, 'self_editable' => true, 'other_readable' => true, 'other_editable' => true),
			array('self_readable' => true, 'self_editable' => true, 'other_readable' => false, 'other_editable' => false)
		);

		return $data;
	}

/**
 * saveDefaultUserAttributeRoles()のテスト
 *
 * @param array $data 登録データ
 * @param array $expected 期待値データ
 * @dataProvider dataProvider
 * @return void
 */
	public function testSaveDefaultUserAttributeRoles($data, $expected) {
		//テスト実施
		$result = $this->TestModel->saveDefaultUserAttributeRoles($data);

		//チェック
		$this->assertTrue($result);

		$actual = $this->__actual($data['UserAttributeSetting']['user_attribute_key']);

		$this->assertEquals($expected, $actual);
	}

/**
 * ExceptionErrorのテスト
 *
 * @return void
 */
	public function testSaveOnExceptionError() {
		$this->_mockForReturnFalse('TestModel', 'UserRoles.UserAttributesRole', 'save');
		$this->setExpectedException('InternalErrorException');

		//テスト実施
		$data = $this->__data('test2');
		$this->TestModel->saveDefaultUserAttributeRoles($data['data']);
	}

}
