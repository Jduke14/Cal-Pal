<?php

namespace App\Controller;

use App\Entity\Service;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
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

        /*return $this->render('service/index.html.twig', [
            'controller_name' => 'ServiceController',
        ]);*/
    }
}
