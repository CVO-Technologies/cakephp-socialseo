<?php

App::uses('Controller', 'Controller');
App::uses('View', 'View');
App::uses('TitleHelper', 'SocialSeo.View/Helper');

/**
 * Class TitleHelperTest
 *
 * @property TitleHelper Title
 */
class TitleHelperTest extends CakeTestCase {

	/**
	 * @var View
	 */
	private $View;

	public function setUp() {
		parent::setUp();

		$Controller = new Controller();
		$this->View = new View($Controller);
		$this->Title = new TitleHelper($this->View);
	}

	public function testSiteTitle() {
		$this->Title->setSiteTitle('Website');

		$this->assertSame('Website', $this->Title->getSiteTitle());
		$this->assertSame('Website', $this->Title->getTopSegment(0));
		$this->assertTags($this->Title->title(), array(
			array('title' =>  array()),
			'Website',
			'/title'
		));
	}

	public function testSiteWithPageTitle() {
		$this->Title->setSiteTitle('website');
		$this->Title->setPageTitle('posts');

		$this->assertSame('website', $this->Title->getTopSegment(1));
		$this->assertSame('posts', $this->Title->getTopSegment(0));
	}

	public function testAddSegment() {
		$this->Title->addSegment('News');
		$this->Title->setPageTitle('News post');
		$this->Title->setSiteTitle('Website');

		$this->assertSame('News post', $this->Title->getTopSegment(0));
		$this->assertSame('News post', $this->Title->getPageTitle());
		$this->assertSame('News', $this->Title->getTopSegment(1));
		$this->assertSame('Website', $this->Title->getSiteTitle());
	}

	public function testAddCrumbs() {
		$this->Title->addSegment('News');
		$this->Title->setPageTitle('News post');
		$this->Title->setSiteTitle('Website');

		$this->Title->addCrumbs(array(
			'#first',
			'#second'
		));

		$expected = array(
			array('a' => array('href' => '#first')),
			'News',
			'/a',
			'&raquo;',
			array('a' => array('href' => '#second')),
			'News post',
			'/a',
		);
		$this->assertTags($this->Title->Html->getCrumbs(), $expected);
	}

	public function testSeparator() {
		$separator = '-';

		$this->Title->setPageTitle('News post');
		$this->Title->addSegment('News');
		$this->Title->setSiteTitle('Website');
		$this->Title->setSeparator($separator);

		$this->assertContains(implode($separator, array('News', 'News post', 'Website')), $this->Title->title());
	}

	public function testNullPageTitle() {
		$this->Title->setSiteTitle('Website');

		$this->assertNull($this->Title->getPageTitle());
		$this->assertTags($this->Title->title(), array(
			array('title' =>  array()),
			'Website',
			'/title'
		));
	}

}