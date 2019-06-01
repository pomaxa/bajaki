<?php

declare(strict_types=1);

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Intl\Intl;
use Symfony\Component\Intl\Locale\Locale;

final class AttenderAdmin extends AbstractAdmin
{

    protected function configureDatagridFilters(DatagridMapper $datagridMapper): void
    {
        $datagridMapper
            ->add('id')
            ->add('firstName')
            ->add('lastName')
            ->add('middleNames')
            ->add('gender')
            ->add('countryOfLiving')
            ->add('dateOfBirth')
            ->add('facebookLink')
            ->add('languages')
            ->add('jobTitle')
            ->add('allowToShare')
            ;
    }

    protected function configureListFields(ListMapper $listMapper): void
    {
        $listMapper
            ->add('id')
            ->add('firstName')
            ->add('lastName')
            ->add('middleNames')
            ->add('gender')
            ->add('countryOfLiving')
            ->add('dateOfBirth')
            ->add('facebookLink')
            ->add('languages')
            ->add('jobTitle')
            ->add('allowToShare')
            ->add('_action', null, [
                'actions' => [
                    'show' => [],
                    'edit' => [],
//                    'delete' => [],
                ],
            ]);
    }

    protected function configureFormFields(FormMapper $formMapper): void
    {
        $formMapper
//            ->add('id')
//            ->add('applications')
            ->add('firstName')
            ->add('lastName')
            ->add('middleNames')
            ->add('gender', ChoiceType::class, ['choices' => [

                'dont wanna share' => 0,
                'male' => 1,
                'female' => 2,
            ]])
            ->add('countryOfLiving')
            ->add('dateOfBirth')
            ->add('facebookLink')
            ->add('languages', ChoiceType::class, [
                'multiple' => true,
                'required' => false,
                'choices' => [
                    'Русский' => 'Русский',
                    'English' => 'English',
                    'Estonian' => 'Estonian',
                    'Latvian' => 'Latvian',
                    'Lithuanian' => 'Lithuanian',
                    'Spanish' => 'Spanish',
                    'Italian' => 'Italian',
                    'Ukrainian' => 'Ukrainian'
                ]
            ])
            ->add('jobTitle')
            ->add('allowToShare')
            ;
    }

    protected function configureShowFields(ShowMapper $showMapper): void
    {
        $showMapper
            ->add('id')
            ->add('firstName')
            ->add('lastName')
            ->add('middleNames')
            ->add('gender')
            ->add('countryOfLiving')
            ->add('dateOfBirth')
            ->add('facebookLink')
            ->add('languages')
            ->add('jobTitle')
            ->add('allowToShare')
            ->add('applications')
            ;
    }
}
