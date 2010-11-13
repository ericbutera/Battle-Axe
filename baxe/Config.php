<?php
class baxe_Config /*implements ArrayAccess*/ {

    const DEVELOPMENT = 'development';
    const PRODUCTION  = 'production';
    const STAGING     = 'staging';

	/**
	 * @var string
	 */
	private $configFile;

	/**
	 * Configuration array.  Please only READ from this.
	 *
	 * @var array
	 */
	public $config = array(
	   'layout.class'  => 'baxe_Layout',
	   'log.adapter'   => 'File'
	);


	/**
	 * @param string $filename configuration file
	 * @param string $mode     app mode: development, production, staging
	 */
	public function __construct($filename, $mode=self::PRODUCTION) {
		$this->configFile = $filename;
		if (!file_exists($this->configFile)) {
			throw new InvalidArgumentException("Invalid config file {$this->configFile}.");
		}

		$ini = parse_ini_file($this->configFile, true);

		$this->config = array_merge($this->config, $ini['global']);
		$this->config = array_merge($this->config, $ini[$mode]);
	}


/*    public function offsetExists($offset) {
    	return isset($this->config[$offset]);
    }
    public function offsetGet($offset) {
    	return $this->config[$offset];
    }
    public function offsetSet($offset, $value) {

    }
    public function offsetUnset($offset) {}
*/

}
