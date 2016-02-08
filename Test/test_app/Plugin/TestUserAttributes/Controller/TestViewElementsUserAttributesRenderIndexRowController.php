<?php
/**
 * View/Elements/UserAttributes/render_index_rowテスト用Controller
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('AppController', 'Controller');
App::uses('UserAttributeLayoutFixture', 'UserAttributes.Test/Fixture');

/**
 * View/Elements/UserAttributes/render_index_rowテスト用Controller
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\UserAttributes\Test\test_app\Plugin\UserAttributes\Controller
 */
class TestViewElementsUserAttributesRenderIndexRowController extends AppController {

/**
 * use model
 *
 * @var array
 */
	public $uses = array(
		'UserAttributes.UserAttributeLayout',
	);

/**
 * use helpers
 *
 * @var array
 */
	public $helpers = array(
		'UserAttributes.UserAttribute',
		'UserAttributes.UserAttributeLayout',
	);

/**
 * beforeRender
 *
 * @return void
 */
	public function beforeRender() {
		parent::beforeFilter();
		$this->Auth->allow('render_index_row');
	}

/**
 * render_index_row
 *
 * @return void
 */
	public function render_index_row() {
		$this->autoRender = true;

		$records = (new UserAttributeLayoutFixture())->records;
		foreach ($records as $i => $record) {
			$viewVars['userAttributeLayouts'][$i]['UserAttributeLayout'] = $record;
		}

		$this->set('data', array(
			'layout' => array('UserAttributeLayout' => (new UserAttributeLayoutFixture())->records[0]),
		));
	}

}
