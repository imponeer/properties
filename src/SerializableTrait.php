<?php

declare(strict_types=1);

namespace Imponeer\Properties;

trait SerializableTrait {
    public function serialize(): string {
        $data = [
            'vars' => $this->getValues(null, 'n')
        ];
        return serialize($data);
    }

    public function unserialize(mixed $serialized): void {
        $data = unserialize($serialized);
        if (method_exists($this, '__construct')) {
            $this->__construct();
        }
        foreach ($data['vars'] as $key => $value) {
            $this->_vars[$key][self::VARCFG_VALUE] = $value;
        }
    }
}