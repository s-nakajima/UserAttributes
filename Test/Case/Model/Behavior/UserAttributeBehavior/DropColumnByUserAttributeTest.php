<?php
/**
 * UserAttributeBehavior::dropColumnByUserAttribute()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsCakeTestCase', 'NetCommons.TestSuite');

/**
 * UserAttributeBehavior::dropColumnByUserAttribute()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\UserAttributes\Test\Case\Model\Behavior\UserAttributeBehavior
 */
class UserAttributeBehaviorDropColumnByUserAttributeTest extends NetCommonsCakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.user_attributes.user_attribute4test',
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
 * tearDown
 *
 * @return void
 */
	public function tearDown() {
		parent::tearDown();
		$this->fixtureManager->shutDown();
	}

/**
 * dropColumnByUserAttribute()のテスト
 *
 * alter table で暗黙的なコミットが発生するため、rollbackしても戻らない。
 * [https://dev.mysql.com/doc/refman/5.6/ja/implicit-commit.html]
 *
 * @return void
 */
	public function testDropColumnByUserAttribute() {
		//テストデータ
		$data = array(
			'UserAttributeSetting' => array(
				'user_attribute_key' => 'sex',
				'is_multilingualization' => false,
				'data_type_key' => DataType::DATA_TYPE_RADIO
			)
		);
		$userAttributeKey = $data['UserAttributeSetting']['user_attribute_key'];

		//テスト実施
		$this->TestModel->begin();
		$this->TestModel->dropColumnByUserAttribute($data);
		$this->TestModel->rollback();

		$userFields = $this->TestModel->User->schema(true);
		$this->assertArrayNotHasKey($userAttributeKey, $userFields);
		$this->assertArrayNotHasKey(sprintf(UserAttribute::PUBLIC_FIELD_FORMAT, $userAttributeKey), $userFields);
	}

/**
 * dropColumnByUserAttribute()のテスト(is_multilingualization=trueの場合)
 *
 * @return void
 */
	public function testIsMultilingualization() {
		$data = array(
			'UserAttributeSetting' => array(
				'user_attribute_key' => 'name',
				'is_multilingualization' => true,
				'data_type_key' => DataType::DATA_TYPE_TEXT
			)
		);
		$userAttributeKey = $data['UserAttributeSetting']['user_attribute_key'];

		$this->TestModel->begin();
		$this->TestModel->dropColumnByUserAttribute($data);
		$this->TestModel->rollback();

		$usersLangfields = $this->TestModel->UsersLanguage->schema(true);
		$this->assertArrayNotHasKey($userAttributeKey, $usersLangfields);

		$userFields = $this->TestModel->User->schema(true);
		$this->assertArrayNotHasKey(sprintf(UserAttribute::PUBLIC_FIELD_FORMAT, $userAttributeKey), $userFields);
	}

/**
 * dropColumnByUserAttribute()のテスト(data_type_key=emailの場合)
 *
 * @return void
 */
	public function testMailType() {
		$data = array(
			'UserAttributeSetting' => array(
				'user_attribute_key' => 'email',
				'is_multilingualization' => false,
				'data_type_key' => DataType::DATA_TYPE_EMAIL
			)
		);
		$userAttributeKey = $data['UserAttributeSetting']['user_attribute_key'];

		$this->TestModel->begin();
		$this->TestModel->dropColumnByUserAttribute($data);
		$this->TestModel->rollback();

		$userFields = $this->TestModel->User->schema(true);
		$this->assertArrayNotHasKey($userAttributeKey, $userFields);
		$this->assertArrayNotHasKey(sprintf(UserAttribute::PUBLIC_FIELD_FORMAT, $userAttributeKey), $userFields);
		$this->assertArrayNotHasKey(sprintf(UserAttribute::MAIL_RECEPTION_FIELD_FORMAT, $userAttributeKey), $userFields);
	}

/**
 * alter table時に発生するrollbackのチェック
 *
 * @return void
 */
	public function testAlterTableErrorAndRollback() {
		$data = array(
			'UserAttributeSetting' => array(
				'user_attribute_key' => 'sex',
				'is_multilingualization' => false,
				'data_type_key' => DataType::DATA_TYPE_RADIO
			)
		);
		$userAttributeKey = $data['UserAttributeSetting']['user_attribute_key'];

		$cakeMigrationMock = $this->getMock(
			'CakeMigration',
			['before'],
			[['connection' => $this->TestModel->useDbConfig]]
		);
		$cakeMigrationMock
			->expects($this->once())
			->method('before')
			->will($this->throwException(new Exception));
		$this->TestModel->Behaviors->UserAttribute->cakeMigration = $cakeMigrationMock;

		$this->TestModel->begin();
		try {
			$this->TestModel->dropColumnByUserAttribute($data);
		}
		catch (Exception $ex) {
			$this->TestModel->rollback();
			$fields = $this->TestModel->User->schema(true);
			$this->assertArrayHasKey($userAttributeKey, $fields);

			return;
		}

		$this->fail();
	}

}
