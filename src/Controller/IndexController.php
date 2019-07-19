<?php

namespace App\Controller;

use App\Entity\Happening;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index()
    {
        $limit = 10;
        return $this->render('index/index.html.twig', [
            'controller_name' => 'IndexController',
            'events' => $this->getDoctrine()
                    ->getRepository(Happening::class)
                    ->getUpcomming($limit),
        ]);
    }
}
