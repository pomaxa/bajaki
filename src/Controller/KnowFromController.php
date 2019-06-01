<?php

namespace App\Controller;

use App\Entity\KnowFrom;
use App\Form\KnowFromType;
use App\Repository\KnowFromRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/know/from")
 */
class KnowFromController extends AbstractController
{
    /**
     * @Route("/", name="know_from_index", methods={"GET"})
     */
    public function index(KnowFromRepository $knowFromRepository): Response
    {
        return $this->render('know_from/index.html.twig', [
            'know_froms' => $knowFromRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="know_from_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $knowFrom = new KnowFrom();
        $form = $this->createForm(KnowFromType::class, $knowFrom);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($knowFrom);
            $entityManager->flush();

            return $this->redirectToRoute('know_from_index');
        }

        return $this->render('know_from/new.html.twig', [
            'know_from' => $knowFrom,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="know_from_show", methods={"GET"})
     */
    public function show(KnowFrom $knowFrom): Response
    {
        return $this->render('know_from/show.html.twig', [
            'know_from' => $knowFrom,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="know_from_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, KnowFrom $knowFrom): Response
    {
        $form = $this->createForm(KnowFromType::class, $knowFrom);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('know_from_index', [
                'id' => $knowFrom->getId(),
            ]);
        }

        return $this->render('know_from/edit.html.twig', [
            'know_from' => $knowFrom,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="know_from_delete", methods={"DELETE"})
     */
    public function delete(Request $request, KnowFrom $knowFrom): Response
    {
        if ($this->isCsrfTokenValid('delete'.$knowFrom->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($knowFrom);
            $entityManager->flush();
        }

        return $this->redirectToRoute('know_from_index');
    }
}
