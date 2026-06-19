<?php

use Uneca\DisseminationToolkit\Traits\ChecksumSafetyTrait;

it('adds a checksum safety prefix to a non-empty string', function () {
    $subject = new class
    {
        use ChecksumSafetyTrait;

        public function add(?string $str): ?string
        {
            return $this->addChecksumSafety($str);
        }

        public function remove(string $str): string
        {
            return $this->removeChecksumSafety($str);
        }
    };

    expect($subject->add('hello'))->toBe('*hello')
        ->and($subject->add(null))->toBeNull()
        ->and($subject->remove('*hello'))->toBe('hello')
        ->and($subject->remove('hello'))->toBe('hello');
});
