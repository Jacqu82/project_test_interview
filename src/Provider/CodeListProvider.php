<?php

declare(strict_types=1);

namespace App\Provider;

/**
 * @author Jacek Wesołowski <jacqu25@yahoo.com>
 */
class CodeListProvider
{
    private $randomStringProvider;

    public function __construct(RandomStringProvider $randomStringProvider)
    {
        $this->randomStringProvider = $randomStringProvider;
    }

    public function generateRandomCodeList(int $length, int $quantity, bool $type): array
    {
        $list = [];
        if (true === $type) {
            for ($i = 1; $i <= $quantity; $i++) {
                $list[] = $this->randomStringProvider->randomDigitString($length);
            }
        } else {
            for ($i = 1; $i <= $quantity; $i++) {
                $list[] = $this->randomStringProvider->randomLetterAndDigitString($length);
            }
        }

        return $list;
    }
}
