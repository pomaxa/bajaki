<?php

declare(strict_types=1);

namespace App\Admin;

use App\Entity\Application;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

final class ApplicationAdmin extends AbstractAdmin
{

    protected function configureDatagridFilters(DatagridMapper $datagridMapper): void
    {
        $datagridMapper
            ->add('id')
            ->add('dietaryRequirements')
            ->add('accommodation')
            ->add('accommodationComments')
            ->add('applicationStatus')
            ->add('transportation')
            ->add('isPayed')
            ->add('createdAt')
            ->add('updatedAt')
            ->add('approvedAt')
            ;
    }

    protected function configureListFields(ListMapper $listMapper): void
    {
        $listMapper
            ->add('id')
            ->add('dietaryRequirements')
            ->add('accommodation')
            ->add('accommodationComments')
            ->add('applicationStatus')
            ->add('transportation')
            ->add('isPayed')
            ->add('createdAt')
            ->add('updatedAt')
            ->add('approvedAt')
            ->add('_action', null, [
                'actions' => [
                    'show' => [],
                    'edit' => [],
                    'delete' => [],
                ],
            ]);
    }

    protected function configureFormFields(FormMapper $formMapper): void
    {
        $formMapper
//            ->add('id')
            ->add('dietaryRequirements')
            ->add('accommodation')
            ->add('accommodationComments')
            ->add('applicationStatus',
                ChoiceType::class,
                ['choices' => [
                    Application::STATUS_NEW => Application::STATUS_NEW,
                    Application::STATUS_APPROVED => Application::STATUS_APPROVED,
                    Application::STATUS_REJECTED => Application::STATUS_REJECTED,
                ]]

            )
            ->add('transportation')
            ->add('isPayed')
//            ->add('createdAt')
//            ->add('updatedAt')
//            ->add('approvedAt')
            ;
    }

    protected function configureShowFields(ShowMapper $showMapper): void
    {
        $showMapper
            ->add('id')
            ->add('dietaryRequirements')
            ->add('accommodation')
            ->add('accommodationComments')
            ->add('applicationStatus')
            ->add('transportation')
            ->add('isPayed')
            ->add('createdAt')
            ->add('updatedAt')
            ->add('approvedAt')
            ;
    }
}
