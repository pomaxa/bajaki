<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Application;
use App\Repository\ApplicationRepository;
use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final class ApplicationAdminController extends CRUDController
{
    public function approveAction($id, ApplicationRepository $applicationRepository): RedirectResponse
    {
        $object = $this->admin->getSubject();

        if (!$object instanceof Application) {
            throw new NotFoundHttpException(sprintf('unable to find the object with id: %s', $id));
        }
        $object->setApplicationStatus(Application::STATUS_APPROVED);
        $object->setUpdatedAt(new \DateTime())
            ->setApprovedAt(new \DateTime())
            ;

        $applicationRepository->save($object);
        $this->addFlash('sonata_flash_success', 'APPROVED successfully');

        return new RedirectResponse($this->admin->generateUrl('list'));
    }

    public function markAsPaidAction($id, ApplicationRepository $applicationRepository): RedirectResponse
    {
        $object = $this->admin->getSubject();

        if (!$object instanceof Application) {
            throw new NotFoundHttpException(sprintf('unable to find the object with id: %s', $id));
        }
        $object->setIsPayed(!$object->isPayed());
        $object->setUpdatedAt(new \DateTime());

        $applicationRepository->save($object);
        $this->addFlash('sonata_flash_success', 'Payment status updated');

        return new RedirectResponse($this->admin->generateUrl('list'));
    }

    public function rejectAction($id, ApplicationRepository $applicationRepository): RedirectResponse
    {
        /** @var Application $object */
        $object = $this->admin->getSubject();

        if (!$object instanceof Application) {
            throw new NotFoundHttpException(sprintf('unable to find the object with id: %s', $id));
        }
        $object->setApplicationStatus(Application::STATUS_APPROVED);
        $object->setUpdatedAt(new \DateTime());
        $applicationRepository->save($object);
        $this->addFlash('sonata_flash_success', 'REJECTED successfully');

        return new RedirectResponse($this->admin->generateUrl('list'));
    }
}
