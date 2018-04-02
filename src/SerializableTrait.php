<?php

namespace Imponeer\Properties;


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