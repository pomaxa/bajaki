<?php

namespace App\Controller;

use App\Entity\Application;
use App\Entity\Attender;
use App\Entity\Happening;
use App\Form\NewApplicationApiType;
use App\Service\FileUploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ApiController
 * @Route("/api")
 * @package App\Controller
 */
class ApiController extends AbstractController
{
    /**
     * @Route("/", name="api_upcomming_events")
     */
    public function index(Request $request)
    {

        $limit = $request->get('limit', 10);
        /** @var Happening[] $eventsObj */
        $eventsObj = $this->getDoctrine()
            ->getRepository(Happening::class)
            ->getUpcomming($limit);

        $events = [];
        foreach ($eventsObj as $event) {
            $events[$event->getId()] = $event->exportData();//['aa' => $event->getTitle()];
        }

        return new JsonResponse(
            [
                'metadata' => [
                    'limit' => $limit,
                    'route' => 'api_upcomming_events',
                ],
                'code' => 0,
                'data' => [
                    'events' => $events,
                ],
            ]
        );
    }

    /**
     * @Route("/event/{eventId}", name="api_event_details")
     */
    public function event($eventId)
    {
        /** @var Happening $event */
        $event = $this->getDoctrine()
            ->getRepository(Happening::class)->find($eventId);

        $data = $event->exportData();

        $data['attenders'] = [];
        /** @var Application[] $applications */
        $applications = $this->getDoctrine()->getRepository(Application::class)->findByEvent($event);
        foreach ($applications as $app) {
            if (!$app->getAttender() instanceof Attender) {
                continue;
            }

            $data['attenders'][] = $app->getAttender()->getAllowToShare()
                ? $app->getAttender()->getFirstName() . ' ' . $app->getAttender()->getLastName()
                : 'incognito';
        }

        return new JsonResponse(
            [
                'metadata' => [
                    'route' => 'api_event_details',
                ],
                'code' => 0,
                'data' => $data,
            ]
        );
    }


    /** @Route("/apply/event/{eventId}", name="api_event_submit") */
    public function submit($eventId, Request $request, FileUploader $fileUploader)
    {
        $happening = $this->getDoctrine()->getRepository(Happening::class)->find($eventId);
        if (!$happening instanceof Happening) {
            return new JsonResponse(
                [
                    'metadata' => [
                        'route' => 'api_event_submit',

                    ],
                    'code' => 1,
                    'data' => [
                        'message_code' => 'happening_not_found',
                        'message' => 'Error. There is no such active happening.',
                    ],
                ]
            );
        }
        $application = new Application;
        $application->setHappening($happening);
        $application->setAttender(new Attender());

        $form = $this->createForm(NewApplicationApiType::class, $application);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $application = $form->getData();

            /** @var UploadedFile $avatarFile */
            $avatarFile = $form['attender']['avatar']->getData();
            if ($avatarFile) {
                $avatarFilename = $fileUploader->upload($avatarFile);
                $application->getAttender()->setAvatarFilename($avatarFilename);
            }

            $this->getDoctrine()->getManager()->persist($application);
            $this->getDoctrine()->getManager()->flush();

            return new JsonResponse(
                [
                    'metadata' => [
                        'route' => 'api_event_submit',
                    ],
                    'code' => 0,
                    'data' => [
                        'message' => 'Your application successfully submitted ',
                        'message_code' => 'application_submit_success',
                    ],
                ]
            );
        }

        $errorMessage = '';
        foreach ($form->getErrors() as $error) {
            $errorMessage .= $error->getMessage() . ' ' . PHP_EOL;
        }

        $response = new JsonResponse(
            [
                'metadata' => 'api_event_submit',
                'code' => 2,
                'data' => [
                    'message' => $errorMessage,
                    'message_code' => 'some_error',
                ]
            ]
        );

        return $response;
    }
}
