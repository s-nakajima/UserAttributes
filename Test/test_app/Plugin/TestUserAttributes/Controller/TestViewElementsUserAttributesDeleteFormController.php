<?php
/**
 * View/Elements/UserAttributes/delete_formテスト用Controller
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('AppController', 'Controller');

/**
 * View/Elements/UserAttributes/delete_formテスト用Controller
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\UserAttributes\Test\test_app\Plugin\UserAttributes\Controller
 */
class TestViewElementsUserAttributesDeleteFormController extends AppController {

/**
 * beforeRender
 *
 * @return void
 */
	public function beforeRender() {
		parent::beforeFilter();
		$this->Auth->allow('delete_form');
	}

/**
 * delete_form
 *
 * @return void
 */
	public function delete_form() {
		$this->autoRender = true;

		App::uses('UserAttributeSettingFixture', 'UserAttributes.Test/Fixture');

		$this->request->data = array(
			'UserAttributeSetting' => (new UserAttributeSettingFixture())->records[0],
		);
	}

}