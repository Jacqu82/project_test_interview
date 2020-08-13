<?php

declare(strict_types=1);

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\GreaterThan;
use Symfony\Component\Validator\Constraints\LessThan;
use Symfony\Component\Validator\Constraints\NotBlank;

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
                    'label' => 'label.quantity',
                    'constraints' => [
                        new NotBlank(),
                        new GreaterThan(['value' => 0]),
                        new LessThan(['value' => 50]),
                    ]
                ]
            )
            ->add(
                'length',
                IntegerType::class,
                [
                    'label' => 'label.length',
                    'constraints' => [
                        new NotBlank(),
                        new GreaterThan(['value' => 0]),
                        new LessThan(['value' => 50]),
                    ]
                ]
            )
            ->add(
                'type',
                ChoiceType::class,
                [
                    'label' => 'label.type',
                    'choices' => [
                        'label.digits_and_letters' => 0,
                        'label.digits' => 1
                    ]
                ]
            )
            ->add(
                'generate',
                SubmitType::class,
                [
                    'label' => 'label.generate',
                ]
            );
    }
}
