<?php

declare(strict_types=1);

if (!class_exists('icms_core_Textsanitizer')) {
    class icms_core_Textsanitizer
    {
        public static function getInstance(): self
        {
            return new self();
        }

        public function displayTarea(
            string $text,
            int $html,
            int $smiley,
            int $xcode,
            int $image,
            int $br
        ): string {
            return $text;
        }
    }
}
