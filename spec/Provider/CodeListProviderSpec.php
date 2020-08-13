<?php

declare(strict_types=1);

namespace spec\App\Provider;

use App\Provider\CodeListProvider;
use App\Provider\RandomStringProvider;
use PhpSpec\ObjectBehavior;

/**
 * @author Jacek Wesołowski <jacqu25@yahoo.com>
 */
class CodeListProviderSpec extends ObjectBehavior
{
    public function it_is_initializable(): void
    {
        $this->shouldHaveType(CodeListProvider::class);
    }

    public function let(RandomStringProvider $randomStringProvider): void
    {
        $this->beConstructedWith($randomStringProvider);
    }

    public function it_should_return_empty_array_when_quantity_is_zero(): void
    {
        $this->generateRandomCodeList(15, 0, false)->shouldBe([]);
    }

    public function it_should_return_array_with_three_values_when_quantity_is_three(
        RandomStringProvider $randomStringProvider
    ): void {
        $randomStringProvider->randomLetterAndDigitString(15)->shouldBeCalled();
        $randomStringProvider->randomDigitString(15)->shouldNotBeCalled();
        $this->generateRandomCodeList(15, 3, false)->shouldHaveCount(3);
    }

    public function it_should_return_empty_or_not_empty_array(RandomStringProvider $randomStringProvider): void
    {
        $randomStringProvider->randomLetterAndDigitString(15)->shouldBeCalled();
        $randomStringProvider->randomDigitString(15)->shouldNotBeCalled();
        $this->generateRandomCodeList(15, 3, false)->shouldBeArray();
    }

    public function it_should_check_whether_key_exists_in_array(RandomStringProvider $randomStringProvider): void
    {
        $randomStringProvider->randomLetterAndDigitString(15)->shouldBeCalled();
        $randomStringProvider->randomDigitString(15)->shouldNotBeCalled();
        $this->generateRandomCodeList(15, 3, false)->shouldHaveKey(2);
    }

    public function it_should_use_method_with_digits_only(RandomStringProvider $randomStringProvider): void
    {
        $randomStringProvider->randomDigitString(15)->shouldBeCalled();
        $randomStringProvider->randomLetterAndDigitString(15)->shouldNotBeCalled();
        $this->generateRandomCodeList(15, 3, true)->shouldHaveKey(2);
    }
}