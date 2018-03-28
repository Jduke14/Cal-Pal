<?php

namespace App\Controller;

use App\Entity\Company;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CompanyController extends Controller
{
    /**
     * @Route("/company", name="company")
     */
    public function index()
    {
    	$entityManager = $this->getDoctrine()->getManager();

    	$company = new Company();

    	$company->setCompanyName('Cal-Pal');
    	$company->setCompanyPhoneNumber(1234567890);
    	$company->setCompanyEmail('calpal@gmail.com');

        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($company);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();


        /*return $this->render('company/index.html.twig', [
            'controller_name' => 'CompanyController',
        ]);*/
    }
}
