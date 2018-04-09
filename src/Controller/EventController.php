<?php

namespace App\Controller;

use App\Entity\Event;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class EventController extends Controller
{
    /**
     * @Route("/event", name="event")
     */
    public function index()
    {
        $entityManager = $this->getDoctrine()->getManager();

        $event = new Event();
        $event->setStartDate(new \DateTime('2018-03-23 12:00:00'));
        $event->setEndDate(new \DateTime('2018-03-23 14:00:00'));
        $event->setCustomerID(1);
        $event->setProviderID(1);
        $event->setServiceID(1);
		$event->setCompanyID(1);
		$event->setComments('It was great!');

        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($event);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return new Response('Saved new product with id '.$event->getId());

        /*return $this->render('event/index.html.twig', [
            'controller_name' => 'EventController',
        ]);*/

    }

    /**
     * @Route("/getCalendarEvents", name="calendarEvents")
     */
    public function getCalendarEvents(Request $request) { 

    $events = array();
    $e = new \stdClass(); 
    $e->title = 'Event 1';
    $e->start = '2018-03-25 12:00:00';
    $events[] = $e;

    $e = new \stdClass(); 
    $e->title = 'Event 2';
    $e->start = '2018-02-15 12:00:00';
    $events[] = $e;

    return new Response(json_encode($events), 200, array('Content-Type' => 'application/json')); 
	}

}
