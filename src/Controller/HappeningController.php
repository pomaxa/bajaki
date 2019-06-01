<?php

namespace App\Controller;

use App\Entity\Happening;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HappeningController extends AbstractController
{
    /**
     * @Route("/happening/{id}", name="happening")
     */
    public function index($id)
    {
        return $this->render('happening/index.html.twig', [
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
