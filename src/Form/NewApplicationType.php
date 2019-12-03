<?php

namespace App\Form;

use App\Entity\Application;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NewApplicationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('happening')

            ->add('attender', AttenderType::class)

            ->add('dietaryRequirements', null, ['label' => 'All of the offered food will be served in Kosher style. Please specify for any other dietary requirements'])
            ->add('accommodation', ChoiceType::class,
                [
                    'label' => 'Accomodation. Please select from the following list',
                    'choices' => [
                        'Single' => 'Single',
                        'Shared' => 'Shared',
                        'Couple' => 'Couple',
                    ]
                ])
            ->add('accommodationComments')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Application::class,
        ]);
    }
}
