<?php
/**
 * Created by IntelliJ IDEA.
 * User: mekdr
 * Date: 1/21/2017
 * Time: 5:51 PM
 */

namespace IPFLibraries\Properties;


trait SerializableTrait {
	/**
	 * Serialize instance to string
	 *
	 * @return string
	 */
	public function serialize() {
		$data = [
			'vars' => $this->getValues(null, 'n')
		];
		return serialize($data);
	}

	/**
	 * Used when using with unserialize function call
	 *
	 * @param mixed $serialized
	 */
	public function unserialize($serialized) {
		$data = unserialize($serialized);
		if (method_exists($this, '__construct')) {
			$this->__construct();
		}
		foreach ($data['vars'] as $key => $value) {
			$this->_vars[$key][self::VARCFG_VALUE] = $value;
		}
	}
}