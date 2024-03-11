<?php

namespace App\Form;

class AddressContactFormType extends AddressFormType
{

    public function getBlockPrefix(): string
    {
        return 'address_contact_form';
    }

}