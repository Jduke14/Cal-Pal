<?php

namespace App\Controller;

use App\Entity\Service;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ServiceController extends Controller
{
    /**
     * @Route("/addService", name="addService")
     */
    public function addService(Request $request)
    {
        $newService = json_decode($request->getContent());

    	$entityManager = $this->getDoctrine()->getManager();

    	$service = new Service();
    	$service->setType($newService->type);
    	$service->setDuration($newService->duration);
    	$service->setCompanyID($newService->companyid);


        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($service);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        $r = new \stdClass();
        $r->status = 'Success';
        return new Response(json_encode($r), 201, array('Content-Type'=>'application/json'));
    }

    /**
     * @Route("/searchServices", name="search_services")
     */
    public function searchServices(Request $request) {
        $companyID = 1;
        $pattern = $request->get('term');
        $repository = $this->getDoctrine()->getRepository(Service::class);
        $services = $repository->searchServices($pattern, $companyID);
        $matchServices = array();
        foreach($services as $s) {
            $temp = new \stdClass();
            $temp->id = $s['id'];
            $temp->label = $s['type'];
            $temp->duration = $s['duration'];
            $matchServices[] = $temp;
        }
        return new Response(json_encode($matchServices), 200, array('Content-Type' => 'application/json'));
    }

    /**
     * @Route("/deleteService/{id}", name="delete_service")
     */
    public function deleteService($id) {
        $entityManager = $this->getDoctrine()->getManager();
        $service = $entityManager->getRepository(Service::class)->find($id);
        $entityManager->remove($service);
        $entityManager->flush();
        return new RedirectResponse('/manage');
    }
}
