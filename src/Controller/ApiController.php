<?php

namespace App\Controller;

use App\Entity\Application;
use App\Entity\Attender;
use App\Entity\Happening;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
    public function index(Request $request )
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
            if(!$app->getAttender() instanceof Attender) {
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
}
