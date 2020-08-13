<?php

declare(strict_types=1);

namespace App\Provider;

/**
 * @author Jacek Wesołowski <jacqu25@yahoo.com>
 */
class CodeProvider
{
    public function generateRandomCodeList(int $length, int $quantity, int $type): array
    {
        $list = [];
        if (1 === $type) {
            for ($i = 1; $i <= $quantity; $i++) {
                $list[] = $this->randomDigitString($length);
            }
        } else {
            for ($i = 1; $i <= $quantity; $i++) {
                $list[] = $this->randomLetterAndDigitString($length);
            }
        }

        return $list;
    }

    private function randomLetterAndDigitString(int $length): string
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';

        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, strlen($characters) - 1)];
        }

        return $randomString;
    }

    private function randomDigitString(int $length): string
    {
        $characters = '0123456789';
        $randomString = '';

        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, strlen($characters) - 1)];
        }

        return $randomString;
    }
}
