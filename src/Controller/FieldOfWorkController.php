<?php

namespace App\Controller;

use App\Entity\FieldOfWork;
use App\Form\FieldOfWorkType;
use App\Repository\FieldOfWorkRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/field/of/work")
 */
class FieldOfWorkController extends AbstractController
{
    /**
     * @Route("/", name="field_of_work_index", methods={"GET"})
     */
    public function index(FieldOfWorkRepository $fieldOfWorkRepository): Response
    {
        return $this->render('field_of_work/index.html.twig', [
            'field_of_works' => $fieldOfWorkRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="field_of_work_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $fieldOfWork = new FieldOfWork();
        $form = $this->createForm(FieldOfWorkType::class, $fieldOfWork);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($fieldOfWork);
            $entityManager->flush();

            return $this->redirectToRoute('field_of_work_index');
        }

        return $this->render('field_of_work/new.html.twig', [
            'field_of_work' => $fieldOfWork,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="field_of_work_show", methods={"GET"})
     */
    public function show(FieldOfWork $fieldOfWork): Response
    {
        return $this->render('field_of_work/show.html.twig', [
            'field_of_work' => $fieldOfWork,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="field_of_work_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, FieldOfWork $fieldOfWork): Response
    {
        $form = $this->createForm(FieldOfWorkType::class, $fieldOfWork);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('field_of_work_index', [
                'id' => $fieldOfWork->getId(),
            ]);
        }

        return $this->render('field_of_work/edit.html.twig', [
            'field_of_work' => $fieldOfWork,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="field_of_work_delete", methods={"DELETE"})
     */
    public function delete(Request $request, FieldOfWork $fieldOfWork): Response
    {
        if ($this->isCsrfTokenValid('delete'.$fieldOfWork->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($fieldOfWork);
            $entityManager->flush();
        }

        return $this->redirectToRoute('field_of_work_index');
    }
}
