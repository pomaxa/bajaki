<?php

namespace App\Controller;

use App\Entity\Application;
use App\Entity\Attender;
use App\Entity\Happening;
use App\Form\NewApplicationType;
use App\Repository\ApplicationRepository;
use App\Repository\HappeningRepository;
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
    public function index(Request $request, $id, FileUploader $fileUploader, \Swift_Mailer $mailer, HappeningRepository $happeningRepository, ApplicationRepository $applicationRepository)
    {
        $happening = $happeningRepository->find($id);
        if (!$happening instanceof Happening) {
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

            $applicationRepository->save($application);

            $this->sendConfirmationEmail($mailer, $application->getAttender());

            return $this->redirectToRoute('happening_success');
        }


        $attenders = [];
        foreach ($happening->getApplications() as $app) {
            $attender = $app->getAttender();
            if (!$attender instanceof Attender) {
                continue;
            }

            if (!$attender->getAllowToShare()) {
                continue;
            }
            if ($app->getApplicationStatus() !== Application::STATUS_APPROVED) {
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
        try {
            $message = (new \Swift_Message('[BJN] Application status update'))
                ->setFrom('info@balticjewishnetwork.eu')
                ->setTo($attender->getFirstEmail())
                ->setBody(
                    $this->renderView(
                        'email/registration.html.twig',
                        ['attender' => $attender]
                    )
                );
            $mailer->send($message);
        } catch (\Throwable $throwable) {
            //this->log
        }
    }

    /**
     * @Route("/lp/thankyou", name="happening_success")
     */
    public function thankyou(Request $request, HappeningRepository $happeningRepository)
    {
        $data = ['attenders'];
        $eventId = $request->get('id');
        $event = $happeningRepository->find($eventId);
        if ($event) {
            foreach ($event->getApplications() as $application) {
                $attender = $application->getAttender();
                if ($attender === null) {
                    continue;
                }
                $data['attenders'][$attender->getId()] = $attender;
            }
        }

        return $this->render('happening/thankyou.html.twig', $data);
    }

    public function apply($id, HappeningRepository $happeningRepository)
    {
        /** @var Happening $event */
        $event = $happeningRepository->find($id);

        $attenders = [];
        foreach ($event->getApplications() as $application) {
            $attender = $application->getAttender();
            if ($attender instanceof Attender) {
                continue;
            }
            $attenders[$attender->getId()] = $attender;
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
