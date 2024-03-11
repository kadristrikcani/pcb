<?php

namespace App\Form;

class ContactType extends CashOfferType
{
    public function getBlockPrefix(): string
    {
        return 'contact_form';
    }
}
