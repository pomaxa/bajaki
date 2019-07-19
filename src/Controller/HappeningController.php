<?php

namespace App\Controller;

use App\Entity\Application;
use App\Entity\Attender;
use App\Entity\Happening;
use App\Form\AttenderType;
use App\Form\NewApplicationType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HappeningController extends AbstractController
{
    /**
     * @Route("/happening/{id}", name="happening")
     */
    public function index($id)
    {
        $happening = $this->getDoctrine()->getRepository(Happening::class)->find($id);
        $application = new Application;
        $application->setHappening($happening);


        //get current user:

        $application->setAttender(new Attender());
        $form = $this->createForm(NewApplicationType::class, $application);




        return $this->render('happening/index.html.twig', [
            'attendForm' => $form->createView(),
            'event' => $this->getDoctrine()->getRepository(Happening::class)
            ->find($id)
        ]);
    }

    public function apply($id)
    {
        return $this->render('happening/index.html.twig', [
            'event' => $this->getDoctrine()->getRepository(Happening::class)
                ->find($id)
        ]);
    }

    public function cancel($id) {

    }
}
