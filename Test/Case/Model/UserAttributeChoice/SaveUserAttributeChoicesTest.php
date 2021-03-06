<?php
/**
 * UserAttributeChoice::saveUserAttributeChoices()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsModelTestCase', 'NetCommons.TestSuite');
App::uses('UserAttribute4testFixture', 'UserAttributes.Test/Fixture');
App::uses('UserAttributeSetting4testFixture', 'UserAttributes.Test/Fixture');
App::uses('UserAttributeChoice4testFixture', 'UserAttributes.Test/Fixture');
App::uses('DataType', 'DataTypes.Model');

/**
 * UserAttributeChoice::saveUserAttributeChoices()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\UserAttributes\Test\Case\Model\UserAttributeChoice
 */
class UserAttributeChoiceSaveUserAttributeChoicesTest extends NetCommonsModelTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.user_attributes.user_attribute4test',
		'plugin.user_attributes.user_attribute_choice4test',
		'plugin.user_attributes.user_attribute_layout',
		'plugin.user_attributes.user_attribute_setting4test',
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
	protected $_modelName = 'UserAttributeChoice';

/**
 * Method name
 *
 * @var string
 */
	protected $_methodName = 'saveUserAttributeChoices';

/**
 * テストデータ
 *
 * @param string $action 処理アクション
 * @param string $type 入力タイプ
 * @return array テストデータ
 */
	private function __data($action, $type = 'radio') {
		$records = (new UserAttributeSetting4testFixture())->records;
		$data['UserAttributeSetting'] = Hash::get(Hash::extract($records, '{n}[id=8]'), '0');
		$data['UserAttributeSetting']['data_type_key'] = $type;

		$records = (new UserAttribute4testFixture())->records;
		$data['UserAttribute'][0]['UserAttribute'] = Hash::get(Hash::extract($records, '{n}[id=8]'), '0');
		$data['UserAttribute'][1]['UserAttribute'] = Hash::get(Hash::extract($records, '{n}[id=28]'), '0');

		$records = (new UserAttributeChoice4testFixture())->records;
		$userAttributeChoices = Hash::extract($records, '{n}[user_attribute_id=8]');
		foreach ($userAttributeChoices as $i => $userAttributeChoice) {
			$data['UserAttributeChoice'][$i][$userAttributeChoice['language_id']] = $userAttributeChoice;
		}
		$userAttributeChoices = Hash::extract($records, '{n}[user_attribute_id=28]');
		foreach ($userAttributeChoices as $i => $userAttributeChoice) {
			$data['UserAttributeChoice'][$i][$userAttributeChoice['language_id']] = $userAttributeChoice;
		}

		if ($action === 'edit') {
			$data['UserAttributeChoice'] = Hash::insert($data['UserAttributeChoice'], '0.{n}.name', 'Edit choice name');
		} elseif ($action === 'add') {
			$data['UserAttributeChoice'][count($data['UserAttributeChoice'])] = array(
				'2' => array(
					'id' => null, 'language_id' => '2', 'user_attribute_id' => '8', 'key' => '',
					'name' => '追加選択肢', 'code' => '', 'weight' => '4'
				),
				'1' => array(
					'id' => null, 'language_id' => '1', 'user_attribute_id' => '28', 'key' => '',
					'name' => 'Add choice', 'code' => '', 'weight' => '4'
				),
			);
		} elseif ($action === 'delete') {
			unset($data['UserAttributeChoice'][1]);

			$result = array();
			$weight = 0;
			foreach ($data['UserAttributeChoice'] as $choice) {
				$weight++;
				$choice = Hash::insert($choice, '{n}.weight', $weight);
				$result[] = $choice;
			}
			$data['UserAttributeChoice'] = $result;
		}

		return $data;
	}

/**
 * 期待値用データ取得
 *
 * @param string $action 処理アクション
 * @return void
 */
	private function __actual($action) {
		$model = $this->_modelName;

		$actual = array();
		$actual['UserAttributeChoice'] = $this->$model->find('all', array(
			'recursive' => -1,
			'conditions' => array('user_attribute_id' => array('8', '28')),
			'order' => array('id' => 'asc'),
		));
		$actual = Hash::remove($actual, '{s}.{n}.{s}.modified');
		$actual = Hash::remove($actual, '{s}.{n}.{s}.modified_user');

		if ($action === 'edit') {
			$actual['UserAttributeChoice'] = Hash::insert($actual['UserAttributeChoice'], '0.UserAttributeChoice.name', 'Edit choice name');
			$actual['UserAttributeChoice'] = Hash::insert($actual['UserAttributeChoice'], '3.UserAttributeChoice.name', 'Edit choice name');

		} elseif ($action === 'add') {
			$actual['UserAttributeChoice'][] = array('UserAttributeChoice' =>
				array(
					'id' => '11', 'language_id' => '2', 'user_attribute_id' => '8',
					'key' => OriginalKeyBehavior::generateKey($this->$model->alias, $this->$model->useDbConfig),
					'name' => '追加選択肢',
					'code' => OriginalKeyBehavior::generateKey($this->$model->alias, $this->$model->useDbConfig),
					'weight' => '4',
				)
			);
			$actual['UserAttributeChoice'][] = array('UserAttributeChoice' =>
				array(
					'id' => '12', 'language_id' => '1', 'user_attribute_id' => '28',
					'key' => OriginalKeyBehavior::generateKey($this->$model->alias, $this->$model->useDbConfig),
					'name' => 'Add choice',
					'code' => OriginalKeyBehavior::generateKey($this->$model->alias, $this->$model->useDbConfig),
					'weight' => '4',
				)
			);
		} elseif ($action === 'delete') {
			$actual['UserAttributeChoice'] = Hash::insert($actual['UserAttributeChoice'], '2.UserAttributeChoice.weight', '2');
			$actual['UserAttributeChoice'] = Hash::insert($actual['UserAttributeChoice'], '5.UserAttributeChoice.weight', '2');
			$actual['UserAttributeChoice'] = Hash::remove($actual['UserAttributeChoice'], '4');
			$actual['UserAttributeChoice'] = Hash::remove($actual['UserAttributeChoice'], '1');

			$result = array();
			$weight = 0;
			foreach ($actual['UserAttributeChoice'] as $choice) {
				$weight++;
				$result[] = $choice;
			}
			$actual['UserAttributeChoice'] = $result;
		}
		$actual = Hash::remove($actual, '{s}.{n}.{s}.modified');
		$actual = Hash::remove($actual, '{s}.{n}.{s}.modified_user');
		$actual = Hash::remove($actual, '{s}.{n}.{s}.created');
		$actual = Hash::remove($actual, '{s}.{n}.{s}.created_user');

		return $actual;
	}

/**
 * チェック用データ取得
 *
 * @return void
 */
	private function __expected() {
		$model = $this->_modelName;

		$expected = array();
		$expected['UserAttributeChoice'] = $this->$model->find('all', array(
			'recursive' => -1,
			'conditions' => array('user_attribute_id' => array('8', '28')),
			'order' => array('id' => 'asc'),
		));
		$expected = Hash::remove($expected, '{s}.{n}.{s}.modified');
		$expected = Hash::remove($expected, '{s}.{n}.{s}.modified_user');
		$expected = Hash::remove($expected, '{s}.{n}.{s}.created');
		$expected = Hash::remove($expected, '{s}.{n}.{s}.created_user');

		return $expected;
	}

/**
 * Saveのテスト(更新)
 *
 * @return void
 */
	public function testEdit() {
		$model = $this->_modelName;
		$method = $this->_methodName;

		//テストデータ
		$data = $this->__data('edit');

		//期待値のデータ取得
		$actual = $this->__actual('edit');

		//テスト実行
		$result = $this->$model->$method($data);
		$this->assertTrue($result);

		//チェック
		$expected = $this->__expected();
		$this->assertEquals($actual, $expected);
	}

/**
 * Saveのテスト(追加)
 *
 * @return void
 */
	public function testAdd() {
		//データ生成
		$data = $this->__data('add');

		//期待値のデータ取得
		$actual = $this->__actual('add');

		//テスト実施
		$model = $this->_modelName;
		$methodName = $this->_methodName;
		$result = $this->$model->$methodName($data);
		$this->assertTrue($result);

		//チェック
		$expected = $this->__expected();
		$this->assertCount(8, $expected['UserAttributeChoice']);
		$this->assertEquals($actual, $expected);
	}

/**
 * Saveのテスト(削除)
 *
 * @return void
 */
	public function testDelete() {
		//データ生成
		$data = $this->__data('delete');

		//期待値のデータ取得
		$actual = $this->__actual('delete');

		//テスト実施
		$model = $this->_modelName;
		$methodName = $this->_methodName;
		$result = $this->$model->$methodName($data);
		$this->assertTrue($result);

		//チェック
		$expected = $this->__expected();
		$this->assertCount(4, $expected['UserAttributeChoice']);
		$this->assertEquals($actual, $expected);
	}

/**
 * SaveのExceptionError用DataProvider
 *
 * ### 戻り値
 *  - data 登録データ
 *  - mockModel Mockのモデル
 *  - mockMethod Mockのメソッド
 *
 * @return array テストデータ
 */
	public function dataProviderSaveOnExceptionError() {
		return array(
			array($this->__data('edit'), 'UserAttributes.UserAttributeChoice', 'save'),
			array($this->__data('edit'), 'UserAttributes.UserAttributeChoice', 'deleteAll'),
		);
	}

/**
 * SaveのExceptionErrorテスト
 *
 * @param array $data 登録データ
 * @param string $mockModel Mockのモデル
 * @param string $mockMethod Mockのメソッド
 * @dataProvider dataProviderSaveOnExceptionError
 * @return void
 */
	public function testSaveOnExceptionError($data, $mockModel, $mockMethod) {
		$model = $this->_modelName;
		$method = $this->_methodName;

		$this->_mockForReturnFalse($model, $mockModel, $mockMethod);

		$this->setExpectedException('InternalErrorException');
		$this->$model->$method($data);
	}

/**
 * SaveのExceptionError用DataProvider
 *
 * ### 戻り値
 *  - dataType データタイプ
 *
 * @return array テストデータ
 */
	public function dataProviderSkipType() {
		return array(
			array(DataType::DATA_TYPE_TEXT, 0),
			array(DataType::DATA_TYPE_RADIO, 6),
			array(DataType::DATA_TYPE_CHECKBOX, 6),
			array(DataType::DATA_TYPE_SELECT, 6),
		);
	}

/**
 * データタイプのスキップテスト
 *
 * @param string $dataType データタイプ
 * @param int $count 回数
 * @dataProvider dataProviderSkipType
 * @return void
 */
	public function testSkipDataType($dataType, $count) {
		$model = $this->_modelName;
		$method = $this->_methodName;

		//Mockの生成
		$this->_mockForReturn($model, 'UserAttributes.UserAttributeChoice', 'save', true, $count);

		//テストデータ
		$data = $this->__data('default', $dataType);

		//テスト実行
		$result = $this->$model->$method($data);
		$this->assertTrue($result);
	}

}
