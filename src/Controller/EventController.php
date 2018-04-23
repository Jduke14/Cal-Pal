<?php

namespace App\Controller;

use App\Entity\Event;
use Doctrine\ORM\Query\ResultSetMapping;
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

        $repository = $this->getDoctrine()->getRepository(Event::class);
        $latestEvent = $repository->getEventById($event->getId());
        $e = new \stdClass();
        $e->id = $event->getId();
        $e->title = $latestEvent['first_name'] . ' ' . $latestEvent['last_name'];
        $e->start = $latestEvent['start_date'];
        $e->end = $latestEvent['end_date'];
        $e->comments = $latestEvent['comments'];

        $r = new \stdClass();
        $r->status = 'success';
        $r->data = $e;
        return new Response(json_encode($r), 200, array('Content-Type'=>'application/json'));
    }
    /**
     * @Route("/displayevent/{id}", name="event_display")
     */
    public function showAction($id) {
        $event = $this->getDoctrine()
            ->getRepository(Event::class)
            ->find($id);

        if(!$event) {
            throw $this->createNotFoundException(
                'No provider found for this id '.$id
            );
        }

        $e = new \stdClass();
        $e->id = $event->getId();
        $e->title = 'New event';
        $e->start = $event->getStartDate();
        $e->end = $event->getEndDate();
        $e->comments = $event->getComments();

        $r = new \stdClass();
        $r->status = 'success';
        $r->data = $e;
        return new Response(json_encode($r), 200, array('Content-Type'=>'application/json'));
    }

    /**
     * @Route("/getCalendarEvents", name="calendarEvents")
     */
    public function getCalendarEvents(Request $request) { 
        $repository = $this->getDoctrine()->getRepository(Event::class);
        $events = $repository->findAllEventsByDate();
        $calEvents = array();
        foreach($events as $tempE) {
            $e = new \stdClass(); 
            $e->title = $tempE['first_name'] . ' ' . $tempE['last_name'];
            $e->start = $tempE['start_date'];
            $e->end = $tempE['end_date'];
            $e->provider = $tempE['p_first_name'] . ' '. $tempE['p_last_name'];
            $e->service = $tempE['type'];
            $e->comments = $tempE['comments'];
            $e->customerid = $tempE['customer_id'];
            $e->providerid = $tempE['provider_id'];
            $e->serviceid = $tempE['service_id'];
            $calEvents[] = $e;
        }

        return new Response(json_encode($calEvents), 200, array('Content-Type' => 'application/json')); 
	}
    /**
     * @Route("/deleteEvent/{id}", name="remove_event")
     */
    public function deleteEvent($id) {
        $entityManager = $this->getDoctrine()->getManager();
        $event = $entityManager->getRepository(Event::class)->find($id);
        $eventComments = $event->getComments();
        $entityManager->remove($event);
        $entityManager->flush();
        return new Response('Event Deleted: '.$eventComments);
    }

}
