<?php

namespace App\Form;

use App\Entity\Attender;

use App\Entity\EmailAddress;
use App\Entity\FieldOfWork;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\LanguageType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

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
            ->add('countryOfLiving')
            ->add('dateOfBirth', BirthdayType::class)
            ->add('facebookLink')
            ->add('languages', ChoiceType::class, ['multiple' =>true, 'choices' => [
                'English' => 'English',
                'Latvian' => 'Latvian',
                'Russian' => 'Russian',
            ]])
            ->add('allowToShare')
            ->add('jobTitle')
            ->add('email', EmailType::class)
            ->add('phone', EntityType::class, ['class' => EmailAddress::class])
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
