<?php

namespace App\Controller;

use App\Entity\Service;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ServiceController extends Controller
{
    /**
     * @Route("/service", name="service")
     */
    public function index()
    {
    	$entityManager = $this->getDoctrine()->getManager();

    	$service = new Service();
    	$service->setType('Massage');
    	$service->setDuration(60);
    	$service->setCompanyID(1);


        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($service);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        /*return $this->render('service/index.html.twig', [
            'controller_name' => 'ServiceController',
        ]);*/
    }
}
