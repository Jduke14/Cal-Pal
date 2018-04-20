<?php

namespace App\Controller;

use App\Entity\Customer;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CustomerController extends Controller
{
    /**
     * @Route("/addCustomer", name="addCustomer")
     */
    public function addCustomer(Request $request)
    {
        $newCustomer = json_decode($request->getContent());
        /*print_r('<pre>');
        print_r($newEvent);
        print_r('</pre>');*/
		$entityManager = $this->getDoctrine()->getManager();

		$customer = new Customer();
		$customer->setFirstName($newCustomer->firstname);
		$customer->setLastName($newCustomer->lastname);
		$customer->setEmail($newCustomer->email);
		$customer->setPhoneNumber($newCustomer->phonenumber);
		$customer->setCompanyID($newCustomer->companyid);

        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($customer);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        /*return $this->render('customer/index.html.twig', [
            'controller_name' => 'CustomerController',
        ]);*/
    }
}
