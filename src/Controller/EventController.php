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
     * @Route("/addEvent", name="addEvent")
     */
    public function addEvent(Request $request)
    {
        $newEvent = json_decode($request->getContent());
        /*print_r('<pre>');
        print_r($newEvent);
        print_r('</pre>');*/
        $entityManager = $this->getDoctrine()->getManager();

        $event = new Event();
        $event->setStartDate(new \DateTime($newEvent->eventstart));
        $event->setEndDate(new \DateTime($newEvent->eventend));
        $event->setCustomerID($newEvent->customerid);
        $event->setProviderID($newEvent->providerid);
        $event->setServiceID($newEvent->serviceid);
		$event->setCompanyID($newEvent->companyid);
		$event->setComments($newEvent->comments);

        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($event);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        $e = new \stdClass();
        $e->id = 1;
        $e->title = 'New event';
        $e->start = $newEvent->eventstart;
        $e->end = $newEvent->eventend;
        $e->comments = $newEvent->comments;

        $r = new \stdClass();
        $r->status = 'ok';
        $r->data = $e;
        return new Response(json_encode($r), 201, array('Content-Type'=>'application/json'));

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
