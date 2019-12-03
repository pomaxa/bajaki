<?php

namespace App\Form;

use App\Entity\Attender;
use App\Entity\AttenderCompany;
use App\Entity\FieldOfWork;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
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
            ->add('email', EmailType::class)
            ->add('phone', TextType::class, ['label' => 'Cell phone'])
            ->add('gender', ChoiceType::class,
                ['choices'  => [
                    'Unknown' => null,
                    'Male' => 1,
                    'Female' => 2,
                ],]
                )
            ->add('allowToShare', null, ['label' => 'Allow to share your data for our networking purposes'])
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
            ->add('facebookLink', null, ['label' => 'Facebook profile'])
            ->add('languages', ChoiceType::class, ['multiple' =>true,
            'attr' => ['class'=>'selectpicker', 'multiple'],
            'choices' => [
                'English' => 'English',
                'Estonian' => 'Estonian',
                'Latvian' => 'Latvian',
                'Lithuanian' => 'Lithuanian',
                'Russian' => 'Russian',
                'Spanish' => 'Spanish',
            ]])

            ->add('jobTitle')
            ->add('company', TextType::class, ['label'=> 'Company name'])


            ->add('fieldOfWork', EntityType::class, ['class' => FieldOfWork::class])
            ->add('knowFrom', null, ['label' => 'How did you hear about Baltic Jewish Network'])
        ;

        $builder->get('company')
            ->addModelTransformer(new CallbackTransformer(
                function (AttenderCompany $company=null) {

                    // transform the string back to an array
                    return $company ? $company->getCompanyName() : '';
                },
                function ($tagsAsArray) {
                    $company = new AttenderCompany();
                    $company->setCompanyName($tagsAsArray);
                    // transform the array to a string
                    return $company;
                }
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Attender::class,
        ]);
    }
}
