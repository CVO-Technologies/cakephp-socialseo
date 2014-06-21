<?php

App::uses('Controller', 'Controller');
App::uses('View', 'View');
App::uses('SeoHelper', 'SocialSeo.View/Helper');

/**
 * Class SeoHelperTest
 *
 * @property SeoHelper Seo
 */
class SeoHelperTest extends CakeTestCase {

	/**
	 * @var View
	 */
	private $View;

	public function setUp() {
		parent::setUp();

		$Controller = new Controller();
		$this->View = new View($Controller);
		$this->Seo = new SeoHelper($this->View);
	}

	public function testDescription() {
		$description = 'This page is amazing!';
		$this->Seo->setDescription($description);

		$this->assertEqual($this->Seo->getDescription(), $description);
	}

	public function testAddKeywords() {
		$keywords = array('awesome', 'pages');
		$this->Seo->setKeywords($keywords);

		$keywords[] = 'web page';
		$this->Seo->addKeyword('web page');

		$this->assertEqual($this->Seo->getKeywords(), $keywords);
	}

	public function testSetDefaultImage() {
		$this->Seo->setImage('/image.png');

		$this->assertEqual($this->Seo->getImage(), '/image.png');
	}

	public function testDefaultImageUnknownGet() {
		$this->Seo->setImage('/image.png');

		$this->assertEqual($this->Seo->getImage(), '/image.png');
		$this->assertEqual($this->Seo->getImage('twitter'), '/image.png');
	}

	public function testSetImageTypeWithDefault() {
		$this->Seo->setImage('/image.png');
		$this->Seo->setImage('/image-twitter.png', 'twitter');

		$this->assertEqual($this->Seo->getImage(), '/image.png');
		$this->assertEqual($this->Seo->getImage('twitter'), '/image-twitter.png');
	}

	public function testSetImageTypeWithoutDefault() {
		$this->Seo->setImage('/image-twitter.png', 'twitter');

		$this->assertFalse($this->Seo->getImage());
		$this->assertEqual($this->Seo->getImage('twitter'), '/image-twitter.png');
	}

	public function testNoImageSet() {
		$this->assertFalse($this->Seo->getImage());
	}

	public function testPageType() {
		$this->Seo->setPageType('profile');

		$this->assertEqual($this->Seo->getPageType(), 'profile');
	}

	public function testDefinedDescriptionForLayoutVariable() {
		$this->View->set('description_for_layout', 'This page is amazing');

		$this->Seo->beforeLayout('awesome/index');

		$this->assertEqual($this->Seo->getDescription(), 'This page is amazing');
	}

	public function testDefinedKeywordsForLayoutVariable() {
		$this->View->set('keywords_for_layout', array('awesome', 'age'));

		$this->Seo->beforeLayout('awesome/index');

		$this->assertEqual($this->Seo->getKeywords(), array('awesome', 'age'));
	}

	public function testFetch() {
		$keywords = array('awesome', 'web pages');
		$this->Seo->setKeywords($keywords);

		$this->Seo->setDescription('This page is amazing');

		$expected = array(
			array('meta' => array(
				'name'     => 'description',
				'itemprop' => 'description',
				'content'  => 'This page is amazing'
			)),
			array('link' => array('name' => 'canonical', 'content' => '/')),
			array('meta' => array('name' => 'keywords', 'content' => implode(', ', $keywords))),
		);

		$this->assertTags($this->Seo->fetch(), $expected, true);
	}

}