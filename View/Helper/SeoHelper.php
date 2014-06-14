<?php

App::uses('AppHelper', 'View/Helper');

/**
 * Class SeoHelper
 *
 * @property mixed Html
 */
class SeoHelper extends AppHelper {

	public $helpers = array(
		'Html'
	);

	/**
	 * @var string
	 */
	private $description;

	/**
	 * @var array
	 */
	private $keywords = array();

	/**
	 * @var array
	 */
	private $images = array();

	private $pageType = 'page';

	private $viewBlock = 'seo';

	public function getCanonicalUrl() {
		return Router::url(null, true);
	}

	/**
	 * @return string
	 */
	public function getDescription() {
		return $this->description;
	}

	/**
	 * @param string $description
	 */
	public function setDescription($description) {
		$this->description = $description;
	}

	/**
	 * @return array
	 */
	public function getKeywords() {
		return $this->keywords;
	}

	/**
	 * @param array $keywords
	 */
	public function setKeywords($keywords) {
		$this->keywords = $keywords;
	}

	/**
	 * @param $keyword string
	 */
	public function addKeyword($keyword) {
		$this->keywords[] = $keyword;
	}

	public function setImage($url, $type = 'default') {
		$this->images[$type] = $url;
	}

	public function getImage($type = 'default') {
		if (isset($this->images[$type])) {
			return $this->images[$type];
		}
		if (isset($this->images['default'])) {
			return $this->images['default'];
		}
		return false;
	}

	/**
	 * @return string
	 */
	public function getPageType() {
		return $this->pageType;
	}

	/**
	 * @param string $pageType
	 */
	public function setPageType($pageType) {
		$this->pageType = $pageType;
	}

	public function beforeLayout($layoutFile) {
		if (isset($this->_View->viewVars['description_for_layout'])) {
			$this->setDescription($this->_View->viewVars['description_for_layout']);
		}
		if (isset($this->_View->viewVars['keywords_for_layout'])) {
			$this->setKeywords($this->_View->viewVars['keywords_for_layout']);
		}
	}

	public function fetch() {
		$this->Html->meta(
			array(
				'name'     => 'description',
				'content'  => $this->getDescription(),
				'itemprop' => 'description'
			),
			null,
			array('block' => $this->viewBlock)
		);

		$this->_View->append($this->viewBlock, $this->Html->tag(
			'link',
			null,
			array(
				'name'    => 'canonical',
				'content' => $this->getCanonicalUrl()
			)
		));

		if (count($this->getKeywords())) {
			$this->Html->meta(
				'keywords',
				implode(', ', $this->getKeywords()),
				array('block' => $this->viewBlock)
			);
		}

		return $this->_View->fetch($this->viewBlock);
	}

}