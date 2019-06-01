<?php

declare(strict_types=1);

namespace App\Admin;

use App\Entity\Application;
use App\Entity\Attender;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\AdminType;
use Sonata\AdminBundle\Form\Type\ModelAutocompleteType;
use Sonata\AdminBundle\Form\Type\ModelListType;
use Sonata\AdminBundle\Form\Type\ModelType;
use Sonata\AdminBundle\Form\Type\ModelTypeList;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

final class ApplicationAdmin extends AbstractAdmin
{
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection
            ->add('approve', $this->getRouterIdParameter().'/approve')
            ->add('reject', $this->getRouterIdParameter().'/reject')
        ;
    }

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
            ->add('approvedAt');
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
                    'approve' => [
                        'template' => 'CRUD/list__action_approve.html.twig',
                    ],
                    'reject' => [
                        'template' => 'CRUD/list__action_reject.html.twig',
                    ],

//                    'delete' => [],
                ],
            ]);
    }

    protected function configureFormFields(FormMapper $formMapper): void
    {
        $formMapper
            ->add('happening', ModelAutocompleteType::class, [
                'property' => 'title',
                'callback' => function ($admin, $property, $value) {
                    $datagrid = $admin->getDatagrid();
                    $queryBuilder = $datagrid->getQuery();
                    $queryBuilder
                        ->andWhere($queryBuilder->getRootAlias() . '.isRegistrationOpen=:barValue')
                        ->setParameter('barValue', true);
                    $datagrid->setValue($property, null, $value);
                },
            ])
            ->add('attender', AdminType::class)
            ->add('dietaryRequirements')
            ->add('accommodation')
            ->add('accommodationComments')
            ->add('transportation')
            ->end()
            ->with('Application Properties')
            ->add('isPayed')
            ->add('applicationStatus',
                ChoiceType::class,
                ['choices' => [
                    Application::STATUS_NEW => Application::STATUS_NEW,
                    Application::STATUS_APPROVED => Application::STATUS_APPROVED,
                    Application::STATUS_REJECTED => Application::STATUS_REJECTED,
                ]]

            )
            ->end();
//            ->add('createdAt')
//            ->add('updatedAt')
//            ->add('approvedAt')
        ;
    }

    protected function configureShowFields(ShowMapper $showMapper): void
    {
        $showMapper
            ->add('id')
            ->add('attender')
            ->add('dietaryRequirements')
            ->add('accommodation')
            ->add('accommodationComments')
            ->add('applicationStatus')
            ->add('transportation')
            ->add('isPayed')
            ->add('createdAt')
            ->add('updatedAt')
            ->add('approvedAt');
    }
}
