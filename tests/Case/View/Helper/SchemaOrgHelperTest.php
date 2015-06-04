<?php

App::uses('Controller', 'Controller');
App::uses('View', 'View');
App::uses('SchemaOrgHelper', 'SocialSeo.View/Helper');

/**
 * Class SchemaOrgHelperTest
 *
 * @property SchemaOrgHelper $SchemaOrg
 */
class SchemaOrgHelperTest extends CakeTestCase {

	/**
	 * @var View
	 */
	private $View;

	public function setUp() {
		parent::setUp();

		$Controller = new Controller();
		$this->View = new View($Controller);
		$this->SchemaOrg = new SchemaOrgHelper($this->View);
	}

	public function testWebPageType() {
		$this->SchemaOrg->Seo->setPageType('page');

		$this->assertEqual($this->SchemaOrg->getType(), 'WebPage');
	}

	public function testProfileType() {
		$this->SchemaOrg->Seo->setPageType('profile');

		$this->assertEqual($this->SchemaOrg->getType(), 'ProfilePage');
	}

	public function testProvidedType() {
		$this->assertEqual($this->SchemaOrg->getType('profile'), 'ProfilePage');
	}

	public function testNonExistingProvidedType() {
		$this->assertEqual($this->SchemaOrg->getType('nonexisting'), 'WebPage');
	}

	public function testSchemaOrgUrl() {
		$this->assertEqual($this->SchemaOrg->getPageItemType(), 'http://schema.org/WebPage');

		$this->SchemaOrg->Seo->setPageType('profile');
		$this->assertEqual($this->SchemaOrg->getPageItemType(), 'http://schema.org/ProfilePage');

		$this->SchemaOrg->Seo->setPageType('page');
		$this->assertEqual($this->SchemaOrg->getPageItemType(), 'http://schema.org/WebPage');
	}

}