<?php

App::uses('Controller', 'Controller');
App::uses('View', 'View');
App::uses('OpenGraphHelper', 'SocialSeo.View/Helper');

/**
 * Class OpenGraphHelperTest
 *
 * @property OpenGraphHelper $OpenGraph
 */
class OpenGraphHelperTest extends CakeTestCase {

	/**
	 * @var View
	 */
	private $View;

	public function setUp() {
		parent::setUp();

		$Controller = new Controller();
		$this->View = new View($Controller);
		$this->OpenGraph = new OpenGraphHelper($this->View);
	}

	public function testUnknownType() {
		$this->OpenGraph->Seo->setPageType('nonexisting');

		$this->assertFalse($this->OpenGraph->getType());
	}

	public function testProfileType() {
		$this->OpenGraph->Seo->setPageType('profile');

		$this->assertEqual($this->OpenGraph->getType(), 'profile');
	}

	public function testArticleType() {
		$this->OpenGraph->Seo->setPageType('post');

		$this->assertEqual($this->OpenGraph->getType(), 'article');
	}

	public function testSeoImage() {
		$this->OpenGraph->Seo->setImage('/image.png', 'open_graph');

		$this->OpenGraph->beforeLayout('amazing/index');

		$this->assertEqual($this->OpenGraph->getImage(), '/image.png');
	}

	public function testFetch() {
		$this->OpenGraph->Title->setPageTitle('Amazing page title');
		$this->OpenGraph->Title->setSiteTitle('Website');
		$this->OpenGraph->Seo->setDescription('This page is amazing');
		$this->OpenGraph->setImage('/image.png');

		$data = $this->OpenGraph->fetch();

		$expected = array(
			array('meta' => array('property' => 'og:title', 'content' => 'Amazing page title')),
			array('meta' => array('property' => 'og:site_name', 'content' => 'Website')),
			array('meta' => array('property' => 'og:type', 'content' => 'website')),
			array('meta' => array('property' => 'og:description', 'content' => 'This page is amazing')),
			array('meta' => array('property' => 'og:image', 'content' => '/image.png')),
			array('meta' => array('property' => 'og:url', 'content' => '/')),
		);

		$this->assertTags($data, $expected);
	}

}