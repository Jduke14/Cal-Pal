<?php

namespace App\Controller;

use App\Entity\Customer;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CustomerController extends Controller
{
    /**
     * @Route("/customer", name="customer")
     */
    public function index()
    {

		$entityManager = $this->getDoctrine()->getManager();

		$customer = new Customer();
		$customer->setFirstName('John');
		$customer->setLastName('Doe');
		$customer->setEmail('johndoe@yahoo.com');
		$customer->setPhoneNumber(1234561234);
		$customer->setCompanyID(1);


        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($customer);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();


        /*return $this->render('customer/index.html.twig', [
            'controller_name' => 'CustomerController',
        ]);*/
    }
}
