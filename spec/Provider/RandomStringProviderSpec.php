<?php

declare(strict_types=1);

namespace spec\App\Provider;

use App\Provider\RandomStringProvider;
use PhpSpec\Exception\Example\FailureException;
use PhpSpec\ObjectBehavior;

/**
 * @author Jacek Wesołowski <jacqu25@yahoo.com>
 */
class RandomStringProviderSpec extends ObjectBehavior
{
    public function getMatchers(): array
    {
        return [
            'haveLength' => static function ($subject, $argument) {
                if (strlen($subject) !== $argument) {
                    throw new FailureException(
                        sprintf(
                            'Expected value should is "%s", but got "%s"',
                            $argument,
                            strlen($subject)
                        )
                    );
                }

                return true;
            }
        ];
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(RandomStringProvider::class);
    }

    public function it_should_return_string_value(): void
    {
        $this->randomLetterAndDigitString(15)->shouldBeString();
    }

    public function it_should_return_non_numeric_value(): void
    {
        $this->randomLetterAndDigitString(15)->shouldNotBeNumeric();
    }

    public function it_should_return_numeric_value(): void
    {
        $this->randomDigitString(15)->shouldBeNumeric();
    }

    public function it_should_return_empty_string(): void
    {
        $this->randomLetterAndDigitString(0)->shouldReturn('');
    }

    public function it_should_return_proper_length(): void
    {
        $this->randomDigitString(15)->shouldHaveLength(15);
    }
}
