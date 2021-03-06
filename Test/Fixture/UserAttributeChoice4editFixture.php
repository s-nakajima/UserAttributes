<?php
/**
 * UserAttributeChoiceFixture
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('UserAttributeChoiceFixture', 'UserAttributes.Test/Fixture');

/**
 * UserAttributeChoiceFixture
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\UserAttributes\Test\Fixture
 * @codeCoverageIgnore
 */
class UserAttributeChoice4editFixture extends UserAttributeChoiceFixture {

/**
 * Model name
 *
 * @var string
 */
	public $name = 'UserAttributeChoice';

/**
 * Full Table Name
 *
 * @var string
 */
	public $table = 'user_attribute_choices';

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		//日本語--選択肢
		array('id' => 1, 'language_id' => '2', 'user_attribute_id' => '3', 'key' => 'radio_1', 'name' => '設定しない', 'code' => 'no_setting', 'weight' => '1', ),
		array('id' => 2, 'language_id' => '2', 'user_attribute_id' => '3', 'key' => 'radio_2', 'name' => '男', 'code' => 'male', 'weight' => '2', ),
		array('id' => 3, 'language_id' => '2', 'user_attribute_id' => '3', 'key' => 'radio_3', 'name' => '女', 'code' => 'female', 'weight' => '3', ),
		//英語--選択肢
		array('id' => 4, 'language_id' => '1', 'user_attribute_id' => '4', 'key' => 'radio_1', 'name' => 'No setting', 'code' => 'no_setting', 'weight' => '1', ),
		array('id' => 5, 'language_id' => '1', 'user_attribute_id' => '4', 'key' => 'radio_2', 'name' => 'Male', 'code' => 'male', 'weight' => '2', ),
		array('id' => 6, 'language_id' => '1', 'user_attribute_id' => '4', 'key' => 'radio_3', 'name' => 'Female', 'code' => 'female', 'weight' => '3', ),
	);

}
