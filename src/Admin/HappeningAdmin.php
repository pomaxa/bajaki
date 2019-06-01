<?php

declare(strict_types=1);

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

final class HappeningAdmin extends AbstractAdmin
{

    protected function configureDatagridFilters(DatagridMapper $datagridMapper): void
    {
        $datagridMapper
            ->add('id')
            ->add('title')
            ->add('createdAt')
            ->add('updatedAt')
            ->add('startsAt')
            ->add('endsAt')
            ->add('description')
            ->add('isRegistrationOpen')
            ->add('isPaid')
            ;
    }

    protected function configureListFields(ListMapper $listMapper): void
    {
        $listMapper
            ->add('id')
            ->add('title')
            ->add('createdAt')
            ->add('updatedAt')
            ->add('startsAt')
            ->add('endsAt')
            ->add('description')
            ->add('isRegistrationOpen')
            ->add('isPaid')
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
            ->add('title')
//            ->add('createdAt')
//            ->add('updatedAt')
            ->add('startsAt', DateTimeType::class, [
                'date_label' => 'Starts On','widget' => 'single_text', 'html5' => true
            ])
            ->add('endsAt', DateTimeType::class)
            ->add('description')
            ->add('isRegistrationOpen')
            ->add('isPaid')
            ;
    }

    protected function configureShowFields(ShowMapper $showMapper): void
    {
        $showMapper
            ->add('id')
            ->add('title')
            ->add('createdAt')
            ->add('updatedAt')
            ->add('startsAt')
            ->add('endsAt')
            ->add('description')
            ->add('isRegistrationOpen')
            ->add('isPaid')
            ;
    }
}
