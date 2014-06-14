<?php

App::uses('AppHelper', 'View/Helper');

/**
 * Class TwitterCardHelper
 *
 * @property HtmlHelper Html
 * @property TitleHelper Title
 * @property Seohelper Seo
 */
class TwitterCardHelper extends Apphelper {

	public $helpers = array(
		'SocialSeo.Title', 'SocialSeo.Seo', 'Html'
	);

	/**
	 * @var string The site's Twitter username with the @
	 */
	private $siteUsername = null;

	private $creatorUsername = null;

	private $viewBlock = 'twitter_card';

	/**
	 * @return string
	 */
	public function getSiteUsername() {
		return $this->siteUsername;
	}

	/**
	 * @param string $siteUsername
	 */
	public function setSiteUsername($siteUsername) {
		$this->siteUsername = $siteUsername;
	}

	/**
	 * @return string
	 */
	public function getCreatorUsername() {
		return $this->creatorUsername;
	}

	/**
	 * @param string $creatorUsername
	 */
	public function setCreatorUsername($creatorUsername) {
		$this->creatorUsername = $creatorUsername;
	}

	public function fetch() {
		if ($this->getSiteUsername()) {
			$this->Html->meta(
				array('property' => 'twitter:site', 'content' => $this->getSiteUsername()),
				null,
				array('inline' => false, 'block' => $this->viewBlock)
			);
		}
		if ($this->getCreatorUsername()) {
			$this->Html->meta(
				array('property' => 'twitter:creator', 'content' => $this->getCreatorUsername()),
				null,
				array('inline' => false, 'block' => $this->viewBlock)
			);
		}

		$this->Html->meta(
			array('property' => 'twitter:title', 'content' => $this->Title->getPageTitle()),
			null,
			array('inline' => false, 'block' => $this->viewBlock)
		);

		if ($this->Seo->getDescription()) {
			$this->Html->meta(
				array('property' => 'twitter:description', 'content' => $this->Seo->getDescription()),
				null,
				array('inline' => false, 'block' => $this->viewBlock)
			);
		}

		$this->Html->meta(
			array('property' => 'twitter:domain', 'content' => env('HTTP_HOST')),
			null,
			array('inline' => false, 'block' => $this->viewBlock)
		);

		return $this->_View->fetch($this->viewBlock);
	}

}