<?php

namespace App\Controller;

use App\Entity\Event;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class CalPalController extends Controller
{
    /**
     * @Route("/index", name="index_cal_pal")
     */
    public function index()
    {
        return $this->render('cal_pal/index.html.twig', [
            'controller_name' => 'CalPalController',
        ]);
    }
    /**
     * @Route("/manage", name="manage_cal_pal")
     */
    public function manage()
    {
        return $this->render('cal_pal/manage.html.twig');
    }
    /**
     * @Route("/about", name="about_cal_pal")
     */
    public function about()
    {
        return $this->render('cal_pal/about.html.twig');
    }
    /**
     * @Route("/admin")
     */
    public function admin() 
    {
        return new Response('<html><body>Admin page!</body></html>');
    }
    /**
     * @Route("/eventhtml", name="event_form")
     */
    public function newEvent(Request $request)
    {
        //Creates a new event w/ dummy data
        $event = new Event();
        $event->setStartDate(new \DateTime());
        $event->setEndDate(new \DateTime());
        $event->setComments('Insert comment here!');

        $form = $this->createFormBuilder($event)
            ->add('startDate', DateType::class)
            ->add('endDate', DateType::class)
            ->add('customerID', TextType::class)
            ->add('companyID', TextType::class)
            ->add('providerID', TextType::class)
            ->add('serviceID', TextType::class)
            ->add('comments', TextType::class, array(
                'required' => false))
            ->add('save', SubmitType::class, array('label' => 'Create Event'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $event = $form->getData();

            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($event);
            $entityManager->flush();

            return $this->redirectToRoute('index_cal_pal');
        }


        return $this->render('event/index.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}