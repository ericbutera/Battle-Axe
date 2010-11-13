<?php
class baxe_Layout_ContentRegion extends baxe_Layout_RegionAbstract {

	public function __construct($content='') {
		$this->content = $content;
	}

	public function getId() {
		return 'content';
	}

	public function render() {
		return $this->content;
	}

}