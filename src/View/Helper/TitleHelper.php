<?php

App::uses('AppHelper', 'View/Helper');

class TitleHelper extends AppHelper {

	public $helpers = array(
		'Html'
	);

	private $_separator = ' :: ';

	private $_segments = array();

	private $_pageTitleSegment = null;
	private $_siteTitleSegment = 0;

	public function setSiteTitle($title) {
		if (is_int($title)) {
			$this->_siteTitleSegment = $title;
		} else {
			$this->_siteTitleSegment = $this->addTopSegment($title);
		}
	}

	public function getSiteTitle() {
		return $this->_segments[$this->_siteTitleSegment];
	}

	public function setPageTitle($title) {
		if (is_int($title)) {
			$this->_pageTitleSegment = $title;
		} else {
			$this->_pageTitleSegment = $this->addSegment($title);
		}
	}

	public function getPageTitle() {
		if ($this->_pageTitleSegment === null) {
			return null;
		}

		return $this->_segments[$this->_pageTitleSegment];
	}

	public function title() {
		return '<title>' . implode($this->_separator, $this->_segments) . '</title>';
	}

	public function setSeparator($separator) {
		$this->_separator = $separator;
	}

	public function addSegment($segment) {
		array_unshift($this->_segments, $segment);

		return 0;
	}

	public function addTopSegment($segment) {
		$this->_segments[] = $segment;

		return count($this->_segments) - 1;
	}

	public function getTopSegment($index = 0) {
		return $this->_segments[$index--];
	}

	public function addCrumbs(array $crumbs) {
		foreach ($crumbs as $index => $link) {
			$this->Html->addCrumb($this->getTopSegment(count($crumbs) - $index - 1), $link);
		}
	}

	public function beforeLayout($layoutFile) {
		if (!$this->getPageTitle()) {
			if ($this->_View->fetch('title')) {
				$this->setPageTitle($this->_View->fetch('title'));
			} else {
				$this->setPageTitle(Inflector::humanize($this->_View->viewPath));
			}
		}
	}

}