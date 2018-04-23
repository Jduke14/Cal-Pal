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

        $r = new \stdClass();
        $r->status = 'Success';
        return new Response(json_encode($r), 201, array('Content-Type'=>'application/json'));
    }
    /**
     * @Route("/editProvider/{id}", name="provider_edit")
     */
    public function updateAction($id) {
        $entityManager = $this->getDoctrine()->getManager();
        $provider = $entityManager->getRepository(Provider::class)->find($id);
        if (!$provider) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }
        $provider->setLastName('Thibodeaux');
        $entityManager->flush();
        //Goes to showAction() to display the provider that was modified, will not be necessary
        return $this->redirectToRoute('provider_show', [
            'id' => $provider->getId()
        ]);
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

    /**
     * @Route("/searchProviders", name="search_providers")
     */
    public function searchProviders(Request $request) {
        $companyID = 1;
        $pattern = $request->get('term');
        $repository = $this->getDoctrine()->getRepository(Provider::class);
        $providers = $repository->searchProviders($pattern, $companyID);
        $matchProviders = array();
        foreach($providers as $p) {
            $temp = new \stdClass();
            $temp->id = $p['id'];
            $temp->label = $p['first_name'].' '.$p['last_name'];
            $matchProviders[] = $temp;
        }
        return new Response(json_encode($matchProviders), 200, array('Content-Type' => 'application/json'));
    }

    /**
     * @Route("/deleteProvider/{id}", name="delete_provider")
     */
    public function deleteProvider($id) {
        $entityManager = $this->getDoctrine()->getManager();
        $provider = $entityManager->getRepository(Provider::class)->find($id);
        $entityManager->remove($provider);
        $entityManager->flush();
        return new Response('Provider Deleted: ');
    }

}
