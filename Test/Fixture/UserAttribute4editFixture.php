<?php
/**
 * UserAttributeFixture
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('UserAttributeFixture', 'UserAttributes.Test/Fixture');

/**
 * UserAttributeFixture
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\UserAttributes\Test\Fixture
 * @codeCoverageIgnore
 */
class UserAttribute4editFixture extends UserAttributeFixture {

/**
 * Model name
 *
 * @var string
 */
	public $name = 'UserAttribute';

/**
 * Full Table Name
 *
 * @var string
 */
	public $table = 'user_attributes';

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array (
			'id' => '1',
			'language_id' => '1',
			'key' => 'user_attribute_key',
			'name' => 'English name',
			'description' => 'English description',
		),
		array (
			'id' => '2',
			'language_id' => '2',
			'key' => 'user_attribute_key',
			'name' => 'Japanese name',
			'description' => 'Japanese description',
		),
		array (
			'id' => '3',
			'language_id' => '1',
			'key' => 'radio_attribute_key',
			'name' => 'English radio name',
			'description' => 'English radio description',
		),
		array (
			'id' => '4',
			'language_id' => '2',
			'key' => 'radio_attribute_key',
			'name' => 'Japanese radio name',
			'description' => 'Japanese radio description',
		),
		array (
			'id' => '5',
			'language_id' => '1',
			'key' => 'system_attribute_key',
			'name' => 'English system name',
			'description' => 'English system description',
		),
		array (
			'id' => '6',
			'language_id' => '2',
			'key' => 'system_attribute_key',
			'name' => 'Japanese system name',
			'description' => 'Japanese system description',
		),
	);

}
