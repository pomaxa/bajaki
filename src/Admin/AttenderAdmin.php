<?php

declare(strict_types=1);

namespace App\Admin;

use App\Entity\Attender;
use App\Service\FileUploader;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ModelListType;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Intl\Intl;
use Symfony\Component\Intl\Locale\Locale;

final class AttenderAdmin extends AbstractAdmin
{
    /** @var FileUploader */
    private $fileUploader;

    public function setFileUploader(FileUploader $fileUploader): void
    {
        $this->fileUploader = $fileUploader;
    }


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
            ->add('allowToShare');
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
            ->add('dateOfBirth', BirthdayType::class, ['required' => false])
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
            ->add('company', ModelListType::class)
            ->add('jobTitle')
            ->add('avatarFile', FileType::class, [])
            ->add('allowToShare');
    }

    public function prePersist($image)
    {
        $this->manageFileUpload($image);
    }

    public function preUpdate($image)
    {
        $this->manageFileUpload($image);
    }

    private function manageFileUpload(Attender $attender)
    {
        if ($attender->getAvatarFile() instanceof UploadedFile) {
            $avatarFilename = $this->fileUploader->upload($attender->getAvatarFile());
            $attender->setAvatarFilename($avatarFilename);
        }
    }

    protected function configureShowFields(ShowMapper $showMapper): void
    {
        $showMapper
            ->add('id')
            ->add('firstName')
            ->add('lastName')
            ->add('middleNames')
            ->add('phone')
            ->add('email')
            ->add('gender')
            ->add('countryOfLiving')
            ->add('dateOfBirth')
            ->add('facebookLink')
            ->add('languages')
            ->add('jobTitle')
            ->add('allowToShare')
            ->add('applications')
            ->add('avatarFilename');
    }
}
