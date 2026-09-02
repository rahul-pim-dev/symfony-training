<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class TraineeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('id', Type\HiddenType::class)
            ->add('name', Type\TextType::class, [
                'label' => 'Trainee Name',
                'required' => false,
                'constraints' => [
                    new NotBlank(message: 'Trainee name is required.'),
                    new Length(
                        min: 3,
                        max: 50,
                        minMessage: 'Trainee name must be at least {{ limit }} characters.'
                    ),
                ],
            ])
            ->add('email', Type\EmailType::class, [
                'label' => 'Email Address',
                'required' => false,
                'constraints' => [
                    new NotBlank(message: 'Email is required.')
                ]
            ])
            ->add('create', Type\SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
