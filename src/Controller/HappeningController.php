<?php

namespace App\Controller;

use App\Entity\Application;
use App\Entity\Attender;
use App\Entity\Happening;
use App\Form\NewApplicationType;
use App\Service\FileUploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class HappeningController extends AbstractController
{
    /**
     * @Route("/happening/{id}", name="happening")
     */
    public function index(Request $request, $id, FileUploader $fileUploader, \Swift_Mailer $mailer)
    {
        $happening = $this->getDoctrine()->getRepository(Happening::class)->find($id);
        if(!$happening instanceof Happening) {
            return new RedirectResponse('/');
        }
        $application = new Application;
        $application->setHappening($happening);


        //get current user:

        $application->setAttender(new Attender());
        $form = $this->createForm(NewApplicationType::class, $application);
        $form->add('save', SubmitType::class, [
            'label' => 'Apply',
            'attr' => ['class' => 'btn-success'],
        ]);


        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$application` variable has also been updated

            $application = $form->getData();

            /** @var UploadedFile $avatarFile */
            $avatarFile = $form['attender']['avatar']->getData();
            if ($avatarFile) {
                $avatarFilename = $fileUploader->upload($avatarFile);
                $application->getAttender()->setAvatarFilename($avatarFilename);
            }

            $this->getDoctrine()->getManager()->persist($application);
            $this->getDoctrine()->getManager()->flush();

            $this->sendConfirmationEmail($mailer, $application->getAttender());
            // ... perform some action, such as s aving the task to the database
            // for example, if Task is a Doctrine entity, save it!
            // $entityManager = $this->getDoctrine()->getManager();
            // $entityManager->persist($task);
            // $entityManager->flush();

            return $this->redirectToRoute('happening_success');
        }


        $attenders = [];
        foreach ( $happening->getApplications() as $app) {
            $attender = $app->getAttender();
            if(!$attender instanceof Attender) {
                continue;
            }

            if(!$attender->getAllowToShare()) {
                continue;
            }
            if($app->getApplicationStatus() !== Application::STATUS_APPROVED) {
                continue;
            }

            $attenders[$attender->getId()] = $attender;
        }


        return $this->render('happening/index.html.twig', [
            'attendForm' => $form->createView(),
            'attenders' => $attenders,
            'event' => $this->getDoctrine()->getRepository(Happening::class)
                ->find($id)
        ]);
    }

    protected function sendConfirmationEmail(\Swift_Mailer $mailer, Attender $attender)
    {
        $message = (new \Swift_Message('[BJN] Application status update'))
            ->setFrom('info@balticjewishnetwork.eu')
            ->setTo($attender->getFirstEmail())
            ->setBody(
                $this->renderView(
                    'email/registration.html.twig',
                    ['attender' => $attender]
                )
            )
        ;
        $mailer->send($message);
    }

    /**
     * @Route("/lp/thankyou", name="happening_success")
     */
    public function thankyou(Request $request)
    {
        $data = ['attenders'];
        $eventId = $request->get('id');
        if($eventId) {
            /** @var Happening $event */
            $event = $this->getDoctrine()->getRepository(Happening::class);
            foreach ( $event->getApplications() as $application) {
                $data['attenders'][$application->getAttender()->getId()] = $application->getAttender();
            }


        }


        return $this->render('happening/thankyou.html.twig', $data);
    }

    public function apply($id)
    {


        /** @var Happening $event */
        $event = $this->getDoctrine()->getRepository(Happening::class)
            ->find($id);

        $attenders = [];
        foreach ( $event->getApplications() as $application) {
            $attenders[$application->getAttender()->getId()] = $application->getAttender();
        }
        return $this->render('happening/index.html.twig', [
            'event' => $event,
            'attenders' => $attenders,
        ]);
    }

    public function cancel($id)
    {

    }
}
