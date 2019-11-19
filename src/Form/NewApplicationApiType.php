<?php

namespace App\Form;

use App\Entity\Application;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NewApplicationApiType extends NewApplicationType
{

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Application::class,
            'csrf_protection' => false,
        ]);
    }
}
