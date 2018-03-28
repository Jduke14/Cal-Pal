<?php

namespace App\Controller;

use App\Entity\Provider;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ProviderController extends Controller
{
    /**
     * @Route("/provider", name="provider")
     */
    public function index()
    {
    	$entityManager = $this->getDoctrine()->getManager();

    	$provider = new Provider();
    	$provider->setFirstName('Alice');
    	$provider->setLastName('Jones');
    	$provider->setCompanyID(1);

        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($provider);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        /*return $this->render('provider/index.html.twig', [
            'controller_name' => 'ProviderController',
        ]);*/
    }
}
