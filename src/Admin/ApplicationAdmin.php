<?php

declare(strict_types=1);

namespace App\Admin;

use App\Entity\Application;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\AdminType;
use Sonata\AdminBundle\Form\Type\ModelAutocompleteType;
use Sonata\AdminBundle\Form\Type\ModelListType;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

final class ApplicationAdmin extends AbstractAdmin
{
    public $supportsPreviewMode = true;

    public function getBatchActions()
    {
        $actions = parent::getBatchActions();
        unset($actions['delete']);

        return $actions;
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection
            ->add('approve', $this->getRouterIdParameter().'/approve')
            ->add('reject', $this->getRouterIdParameter().'/reject')
            ->add('mark_as_paid', $this->getRouterIdParameter().'/mark_as_paid')
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper): void
    {
        $datagridMapper
            ->add('id')
            ->add('attender.countryOfLiving')

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
            ->add('attender.countryOfLiving')
            ->add('attender')

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
                    'mark_as_paid' => [
                        'template' => 'CRUD/list__action_mark_as_paid.html.twig',
                    ],

//                    'delete' => [],
                ],
            ]);
    }

    protected function configureFormFields(FormMapper $formMapper): void
    {
        $formMapper
            ->add('happening', ModelListType::class)
            /*
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
            ])*/
            ->add('attender', ModelListType::class)
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
            ->add('attender.phone')
            ->add('attender.email')
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
