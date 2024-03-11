<?php

namespace App\Form;

use App\Service\Collection;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CashOfferType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('ownerStatus', ChoiceType::class, [
                'required' => true,
                'choices' => array_flip(Collection::OWNER_STATUS),
                'placeholder' => 'Are you the Owner?',
            ])
            ->add('sellingReason', ChoiceType::class, [
                'required' => false,
                'choices' => array_flip(Collection::SELLING_REASON),
                'placeholder' => 'Reason for selling?',
            ])
            ->add('listed', ChoiceType::class, [
                'required' => true,
                'choices' => array_flip(Collection::LISTED),
                'placeholder' => 'Is your property listed on the market? ',
            ]);

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'csrf_protection' => true
        ]);
    }
}
