<?php

declare(strict_types=1);

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\GreaterThan;

/**
 * @author Jacek Wesołowski <jacqu25@yahoo.com>
 */
class CodeForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'quantity',
                IntegerType::class,
                [
                    'constraints' => [
                        new GreaterThan(['value' => 0])
                    ]
                ]
            )
            ->add(
                'length',
                IntegerType::class,
                [
                    'constraints' => [
                        new GreaterThan(['value' => 0])
                    ]
                ]
            )
            ->add(
                'type',
                ChoiceType::class,
                [
                    'choices' => [
                        'digits' => 0,
                        'digits_and_letters' => 1
                    ]
                ]
            )
            ->add('submit', SubmitType::class);
    }

    public function getBlockPrefix(): string
    {
        return '';
    }
}
