<?php

namespace App\Form;

use App\Entity\Attender;
use App\Entity\FieldOfWork;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class AttenderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName')
            ->add('lastName')
            ->add('gender', ChoiceType::class,
                ['choices'  => [
                    'Unknown' => null,
                    'Male' => 1,
                    'Female' => 2,
                ],]
                )
            ->add('avatar', FileType::class, [
                'label' => 'Profile photo (optional)',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '10M',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/pjpeg',
                            'image/png',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid photo or skip this step for now.',
                    ])
                ]
            ])
            ->add('countryOfLiving')
            ->add('dateOfBirth', BirthdayType::class)
            ->add('facebookLink')
            ->add('languages', ChoiceType::class, ['multiple' =>true,
            'attr' => ['class'=>'selectpicker', 'multiple'],
            'choices' => [
                'English' => 'English',
                'Latvian' => 'Latvian',
                'Russian' => 'Russian',
            ]])
            ->add('allowToShare')
            ->add('jobTitle')
            ->add('email', EmailType::class)
            ->add('phone', TextType::class)
            ->add('fieldOfWork', EntityType::class, ['class' => FieldOfWork::class])
            ->add('knowFrom')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Attender::class,
        ]);
    }
}
