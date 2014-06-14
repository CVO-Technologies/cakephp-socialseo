<?php

App::uses('AppHelper', 'View/Helper');

/**
 * Class SchemaOrgHelper
 *
 * @property HtmlHelper Html
 * @property SeoHelper Seo
 * @property TitleHelper Title
 */
class SchemaOrgHelper extends Apphelper {

	public $helpers = array(
		'SocialSeo.Title', 'SocialSeo.Seo', 'Html'
	);

	private $pageTypeMap = array(
		'page'    => 'WebPage',
		'profile' => 'ProfilePage'
	);

	public function getType($type = null) {
		if (!$type) {
			$type = $this->Seo->getPageType();
		}
		if (isset($this->pageTypeMap[$type])) {
			return $this->pageTypeMap[$type];
		}

		return $this->getType('page');
	}

	public function getPageItemType() {
		return 'http://schema.org/' . $this->getType();
	}

}