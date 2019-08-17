<?php

namespace App\Controller;

use App\Entity\Application;
use App\Entity\Attender;
use App\Entity\Happening;
use App\Form\AttenderType;
use App\Form\NewApplicationType;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class HappeningController extends AbstractController
{
    /**
     * @Route("/happening/{id}", name="happening")
     */
    public function index(Request $request, $id)
    {
        $happening = $this->getDoctrine()->getRepository(Happening::class)->find($id);
        $application = new Application;
        $application->setHappening($happening);


        //get current user:

        $application->setAttender(new Attender());
        $form = $this->createForm(NewApplicationType::class, $application);
        $form->add('save', SubmitType::class, [
            'attr' => ['class' => 'btn-success'],
        ]);


        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $application = $form->getData();

            $this->getDoctrine()->getManager()->persist($application);
            $this->getDoctrine()->getManager()->flush();
            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
            // $entityManager = $this->getDoctrine()->getManager();
            // $entityManager->persist($task);
            // $entityManager->flush();

            return $this->redirectToRoute('happening_success');
        }


        return $this->render('happening/index.html.twig', [
            'attendForm' => $form->createView(),
            'event' => $this->getDoctrine()->getRepository(Happening::class)
            ->find($id)
        ]);
    }

    /**
     * @Route("/lp/thankyou", name="happening_success")
     */
    public function thankyou()
    {
        return $this->render('happening/thankyou.html.twig');
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
