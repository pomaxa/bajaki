<?php

namespace App\Controller;

use App\Entity\AttenderCompany;
use App\Form\AttenderCompanyType;
use App\Repository\AttenderCompanyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/attender/company")
 */
class AttenderCompanyController extends AbstractController
{
    /**
     * @Route("/", name="attender_company_index", methods={"GET"})
     */
    public function index(AttenderCompanyRepository $attenderCompanyRepository): Response
    {
        return $this->render('attender_company/index.html.twig', [
            'attender_companies' => $attenderCompanyRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="attender_company_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $attenderCompany = new AttenderCompany();
        $form = $this->createForm(AttenderCompanyType::class, $attenderCompany);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($attenderCompany);
            $entityManager->flush();

            return $this->redirectToRoute('attender_company_index');
        }

        return $this->render('attender_company/new.html.twig', [
            'attender_company' => $attenderCompany,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="attender_company_show", methods={"GET"})
     */
    public function show(AttenderCompany $attenderCompany): Response
    {
        return $this->render('attender_company/show.html.twig', [
            'attender_company' => $attenderCompany,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="attender_company_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, AttenderCompany $attenderCompany): Response
    {
        $form = $this->createForm(AttenderCompanyType::class, $attenderCompany);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('attender_company_index', [
                'id' => $attenderCompany->getId(),
            ]);
        }

        return $this->render('attender_company/edit.html.twig', [
            'attender_company' => $attenderCompany,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="attender_company_delete", methods={"DELETE"})
     */
    public function delete(Request $request, AttenderCompany $attenderCompany): Response
    {
        if ($this->isCsrfTokenValid('delete'.$attenderCompany->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($attenderCompany);
            $entityManager->flush();
        }

        return $this->redirectToRoute('attender_company_index');
    }
}
