<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Regex;

class AddressFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('address', TextType::class, [
                'attr' => ['placeholder' => 'Address'],
            ])
            ->add('name', TextType::class, [
                'attr' => ['placeholder' => 'Name'],
                'required' => true,
            ])
            ->add('phone', TextType::class, [
                'attr' => [
                    'placeholder' => 'Phone number',
                ],
                'required' => true,
                'constraints' => [
                    new Regex([
                        'pattern' => '/^\(\d{3}\) \d{3}-\d{4}$/',
                        'message' => 'Please enter a valid phone number in the format (XXX) XXX-XXXX',
                    ])
                ]
            ]);

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'csrf_protection' => true
        ]);
    }
}