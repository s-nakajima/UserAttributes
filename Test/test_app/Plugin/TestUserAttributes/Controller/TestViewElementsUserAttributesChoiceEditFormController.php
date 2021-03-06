<?php
/**
 * View/Elements/UserAttributes/choice_edit_formテスト用Controller
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('AppController', 'Controller');
App::uses('UserAttributeChoice4testFixture', 'UserAttributes.Test/Fixture');

/**
 * View/Elements/UserAttributes/choice_edit_formテスト用Controller
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\UserAttributes\Test\test_app\Plugin\UserAttributes\Controller
 */
class TestViewElementsUserAttributesChoiceEditFormController extends AppController {

/**
 * use component
 *
 * @var array
 */
	public $components = array(
		'M17n.SwitchLanguage',
		'DataTypes.DataTypeForm',
	);

/**
 * choice_edit_form
 *
 * @return void
 */
	public function choice_edit_form() {
		$this->autoRender = true;

		$choiceRecords = (new UserAttributeChoice4testFixture())->records;
		$userAttributeChoices = Hash::extract($choiceRecords, '{n}[user_attribute_id=8]');
		$userAttributeChoices = array_merge($userAttributeChoices, Hash::extract($choiceRecords, '{n}[user_attribute_id=28]'));
		$userAttributeChoices = Hash::combine($userAttributeChoices, '{n}.id', '{n}', '{n}.user_attribute_id');

		$this->request->data = array(
			'UserAttributeChoice' => $userAttributeChoices,
		);
	}

/**
 * choice_edit_form
 *
 * @return void
 */
	public function choice_edit_form_null() {
		$this->autoRender = true;
		$this->view = 'choice_edit_form';

		$this->request->data = array(
			'UserAttributeChoice' => null,
		);
	}

/**
 * choice_edit_form
 *
 * @return void
 */
	public function choice_edit_form_without_id() {
		$this->autoRender = true;
		$this->view = 'choice_edit_form';

		$this->choice_edit_form();
		$this->request->data['UserAttributeChoice']['8']['2']['id'] = 0;
	}

}
