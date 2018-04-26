<?php

namespace App\Controller;

use App\Entity\Event;
use Doctrine\ORM\Query\ResultSetMapping;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class EventController extends Controller
{
    /**
     * @Route("/saveEvent", name="saveEvent")
     */
    public function saveEvent(Request $request)
    {
        $newEvent = json_decode($request->getContent());
        $entityManager = $this->getDoctrine()->getManager();
        $repository = $this->getDoctrine()->getRepository(Event::class);

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
        
        $latestEvent = $repository->getEventById($event->getId());
        $e = new \stdClass();
        $e->id = $event->getId();
        $e->title = $latestEvent['first_name'] . ' ' . $latestEvent['last_name'];
        $e->start = $latestEvent['start_date'];
        $e->end = $latestEvent['end_date'];
        $e->color = '#'.$latestEvent['color'];
        $e->comments = $latestEvent['comments'];

        $r = new \stdClass();
        $r->status = 'success';
        $r->data = $e;
        return new Response(json_encode($r), 200, array('Content-Type'=>'application/json'));
    }
    public function convertArrayToEvent($tempEvent): ?Event {
        $event = new Event();
        $event->id = $tempEvent['id'];
        $event->setStartDate(new \DateTime($tempEvent['start_date']));
        $event->setEndDate(new \DateTime($tempEvent['end_date']));
        $event->setCustomerID($tempEvent['customer_id']);
        $event->setProviderID($tempEvent['provider_id']);
        $event->setServiceID($tempEvent['service_id']);
        $event->setCompanyID($tempEvent['company_id']);
        $event->setComments($tempEvent['comments']);
        return $event;
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
    public function getCalendarEvents(Request $request, AuthorizationCheckerInterface $authChecker) { 
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $userRole = false;
        if (true === $authChecker->isGranted('ROLE_USER')) {
            $userRole = true;
        }
        $repository = $this->getDoctrine()->getRepository(Event::class);
        $events = $repository->findAllEventsByDate();
        $calEvents = array();
        foreach($events as $tempE) {
            $e = new \stdClass(); 
            $e->id = $tempE['id'];
            if($userRole && $tempE['customer_id'] != 1) {
                $e->title = 'Time booked';
            } else {
                $e->title = $tempE['first_name'] . ' ' . $tempE['last_name'];
            }
            $e->start = $tempE['start_date'];
            $e->end = $tempE['end_date'];
            $e->provider = $tempE['p_first_name'] . ' '. $tempE['p_last_name'];
            $e->service = $tempE['type'];
            $e->comments = $tempE['comments'];
            $e->customerid = $tempE['customer_id'];
            $e->providerid = $tempE['provider_id'];
            $e->serviceid = $tempE['service_id'];
            $e->color = '#'.$tempE['color'];
            $calEvents[] = $e;
        }

        return new Response(json_encode($calEvents), 200, array('Content-Type' => 'application/json')); 
	}

    /**
     * @Route("/deleteEvent", name="remove_event")
     */
    public function deleteEvent(Request $request) {
        $tempEvent = json_decode($request->getContent());
        $entityManager = $this->getDoctrine()->getManager();

        $event = $entityManager->getRepository(Event::class)->find($tempEvent->id);
        $entityManager->remove($event);
        $entityManager->flush();
        $r = new \stdClass();
        $r->status = 'success';
        return new Response(json_encode($r), 200, array('Content-Type'=>'application/json'));
    }

}
