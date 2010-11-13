<?php
abstract class baxe_Layout_RegionAbstract {

	/**
	 * Return the content region id (eg: content, menu, header, etc)
	 *
	 * @return string
	 */
	abstract public function getId();

	/**
     * Render the region
     *
     * @return string
	 */
	abstract public function render();

}
