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

        $r = new \stdClass();
        $r->status = 'Success';
        return new Response(json_encode($r), 200, array('Content-Type'=>'application/json'));
    }

    /**
     * @Route("/searchCustomers", name="search_customers")
     */
    public function searchCustomers(Request $request) {
        $companyID = 1;
        $pattern = $request->get('term');
        $repository = $this->getDoctrine()->getRepository(Customer::class);
        $customers = $repository->searchCustomers($pattern, $companyID);
        $matchCustomers = array();
        foreach($customers as $c) {
            $temp = new \stdClass();
            $temp->id = $c['id'];
            $temp->label = $c['first_name'].' '.$c['last_name'];
            $matchCustomers[] = $temp;
        }
        return new Response(json_encode($matchCustomers), 200, array('Content-Type' => 'application/json'));
    }

    /**
     * @Route("/deleteCustomer/{id}", name="delete_customer")
     */
    public function deleteCustomer($id) {
        $entityManager = $this->getDoctrine()->getManager();
        $customer = $entityManager->getRepository(Customer::class)->find($id);
        $entityManager->remove($customer);
        $entityManager->flush();
        return new Response('Customer Deleted: ');
    }
}
