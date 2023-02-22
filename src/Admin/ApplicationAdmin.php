<?php

declare(strict_types=1);

namespace App\Admin;

use App\Entity\Application;
use App\Form\ApplicationCommentType;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridInterface;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\CollectionType;
use Sonata\AdminBundle\Form\Type\ModelListType;
use Sonata\AdminBundle\Route\RouteCollectionInterface;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

final class ApplicationAdmin extends AbstractAdmin
{
    public $supportsPreviewMode = true;

    protected function configureDefaultSortValues(array &$sortValues): void
    {
        $sortValues[DatagridInterface::SORT_ORDER] = 'DESC';
        $sortValues[DatagridInterface::SORT_BY] = 'id';
    }

    protected function configureRoutes(RouteCollectionInterface $collection): void
    {
        $collection
            ->add('approve', $this->getRouterIdParameter() . '/approve')
            ->add('reject', $this->getRouterIdParameter() . '/reject')
            ->add('mark_as_paid', $this->getRouterIdParameter() . '/mark_as_paid');
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper): void
    {
        $datagridMapper
            ->add('id')
            ->add('happening')
            ->add('attender.countryOfLiving')
            ->add('applicationStatus')
            ->add('attender.fieldOfWork')
            ->add('attender.company')
            ->add('isPayed')
            ->add('dayOfArrival')
            ->add('createdAt')
            ->add('updatedAt')
            ->add('approvedAt');
    }

    protected function configureListFields(ListMapper $listMapper): void
    {
        $listMapper
            ->add('id')
            ->add('happening')
            ->add('attender.countryOfLiving')
            ->add('attender')
            ->add('applicationStatus')
            ->add('attender.fieldOfWork')
            ->add('attender.company')
            ->add('isPayed')
            ->add('dayOfArrival')
            ->add('createdAt')
            ->add('updatedAt')
            ->add('approvedAt')
            ->add('_action', 'actions', [
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
                ],
            ]);
    }

    protected function configureFormFields(FormMapper $formMapper): void
    {
        $formMapper
            ->add('happening', ModelListType::class)
            ->add('attender', ModelListType::class)
            ->add('dietaryRequirements')
            ->add('accommodation')
            ->add('accommodationComments')
            ->add('transportation')
            ->end()
            ->with('Additional Comments')
            ->add('comments', CollectionType::class, [
                'by_reference' => false,
                'allow_add' => true,
                'required' => false,
                'entry_type' => ApplicationCommentType::class
            ], [
                'label' => 'Application related comments',
                'edit' => 'inline',
                'inline' => 'table',
            ])
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
    }

    protected function configureShowFields(ShowMapper $showMapper): void
    {
        $showMapper
            ->add('id')
            ->add('attender')
            ->add('attender.phone')
            ->add('attender.email')
            ->add('attender.fieldOfWork')
            ->add('attender.company')
            ->add('dietaryRequirements')
            ->add('accommodation')
            ->add('accommodationComments')
            ->add('applicationStatus')
            ->add('isPayed')
            ->add('dayOfArrival')
            ->add('createdAt')
            ->add('updatedAt')
            ->add('approvedAt')
            ->add('comments');
    }

    protected function configureExportFields(): array
    {
        return [
            'id',
            'attender',
            'attender.dateOfBirth',
            'attender.getMainPhone',
            'attender.getMainEmail',
            'attender.fieldOfWork',
            'attender.company',
            'dietaryRequirements',
            'accommodation',
            'accommodationComments',
            'applicationStatus',
            'isPayed',
            'createdAt',
            'updatedAt',
            'approvedAt',
            'comments',
        ];
    }
}
