<?php

namespace App\Form;

use App\Entity\Application;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Happening;

class NewApplicationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('happening', EntityType::class, [
                'class' => Happening::class,
                //                'choice_label' => 'name',
                'disabled' => true,
            ])
            ->add('attender', AttenderType::class)
            ->add(
                'dietaryRequirements',
                null,
                ['label' => 'All of the offered food will be served in Kosher style. Please specify for any other dietary requirements']
            )
            ->add(
                'dayOfArrival',
                ChoiceType::class,
                [
                    'label' => 'Day of arrival',
                    'choices' => [
                        'Thursday, 29.06' => 'Thursday, 29.06',
                        'Friday, 30.06' => 'Friday, 30.06',
                        'Saturday, 01.07' => 'Saturday, 01.07',
                    ],
                ]
            )
            ->add(
                'accommodation',
                ChoiceType::class,
                [
                    'label' => 'Accommodation',
                    'placeholder' => 'Please select from the following list',
                    'choices' => [
                        'Without accommodation' => 'Without accommodation',
                        'Single' => 'Single (waiting list)',
                        'Shared' => 'Shared',
                        'Couple' => 'Couple',
                    ],
                ]
            )
            ->add('accommodationComments')
            ->add(
                'wantToSupport', ChoiceType::class,
                [
                    'label' => 'Would you like to support BJN Weekend and promote your business?',
//                    'placeholder' => 'Please select ',
                    'choices' => [
                        'Yes, I would  be glad. We will get in contact with you with further details!' => 'Yes, I would  be glad. We will get in contact with you with further details!',
                        'Not at the moment' => 'Not at the moment',
                    ],
                ]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
                                   'data_class' => Application::class,
                               ]);
    }
}
