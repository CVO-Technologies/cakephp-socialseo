<?php

App::uses('Controller', 'Controller');
App::uses('View', 'View');
App::uses('TwitterCardHelper', 'SocialSeo.View/Helper');

/**
 * Class TwitterCardHelperTest
 *
 * @property TwitterCardHelper $TwitterCard
 */
class TwitterCardHelperTest extends CakeTestCase {

	/**
	 * @var View
	 */
	private $View;

	public function setUp() {
		parent::setUp();

		$Controller = new Controller();
		$this->View = new View($Controller);
		$this->TwitterCard = new TwitterCardHelper($this->View);
	}

	public function testSiteUsername() {
		$this->TwitterCard->setSiteUsername('siteuser');

		$this->assertEqual($this->TwitterCard->getSiteUsername(), 'siteuser');
	}

	public function testEmptySiteUsername() {
		$this->assertNull($this->TwitterCard->getSiteUsername());
	}


	public function testCreatorUsername() {
		$this->TwitterCard->setCreatorUsername('siteuser');

		$this->assertEqual($this->TwitterCard->getCreatorUsername(), 'siteuser');
	}

	public function testEmptyCreatorUsername() {
		$this->assertNull($this->TwitterCard->getCreatorUsername());
	}

	public function testSeoImage() {
		$this->TwitterCard->Seo->setImage('/image.png', 'twitter');

		$this->TwitterCard->beforeLayout('amazing/index');

		$this->assertEqual($this->TwitterCard->getImage(), '/image.png');
	}

	public function testFetch() {
		$this->TwitterCard->Title->setPageTitle('Amazing page title');
		$this->TwitterCard->Seo->setDescription('This page is amazing');
		$this->TwitterCard->setSiteUsername('sitename');
		$this->TwitterCard->setCreatorUsername('authorname');
		$this->TwitterCard->setImage('/image.png');

		$data = $this->TwitterCard->fetch();

		if (env('HTTP_HOST')) {
			$domainProperty = array('meta' => array('property' => 'twitter:domain', 'content' => env('HTTP_HOST')));
		} else {
			$domainProperty = array('meta' => array('property' => 'twitter:domain'));
		}

		$expected = array(
			array('meta' => array('property' => 'twitter:card', 'content' => 'summary')),
			array('meta' => array('property' => 'twitter:site', 'content' => 'sitename')),
			array('meta' => array('property' => 'twitter:creator', 'content' => 'authorname')),
			array('meta' => array('property' => 'twitter:image:src', 'content' => '/image.png')),
			array('meta' => array('property' => 'twitter:title', 'content' => 'Amazing page title')),
			array('meta' => array('property' => 'twitter:description', 'content' => 'This page is amazing')),
			$domainProperty,
		);

		$this->assertTags($data, $expected);
	}

}