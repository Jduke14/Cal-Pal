<?php

namespace App\Controller;

use App\Entity\Provider;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ProviderController extends Controller
{
    /**
     * @Route("/addProvider", name="addProvider")
     */
    public function addProvider(Request $request)
    {
        $newProvider = json_decode($request->getContent());

    	$entityManager = $this->getDoctrine()->getManager();

    	$provider = new Provider();
    	$provider->setFirstName($newProvider->firstname);
    	$provider->setLastName($newProvider->lastname);
    	$provider->setCompanyID($newProvider->companyid);

        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($provider);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        /*return $this->render('provider/index.html.twig', [
            'controller_name' => 'ProviderController',
        ]);*/
    }
    /**
     * @Route("/provider/{id}", name="provider_show")
     */
    public function showAction($id) 
    {
        $provider = $this->getDoctrine()
            ->getRepository(Provider::class)
            ->find($id);

        if(!$provider) {
            throw $this->createNotFoundException(
                'No provider found for this id '.$id
            );
        }

        return new Response('Check out this provider: '.$provider->getFirstName());
    }
}
