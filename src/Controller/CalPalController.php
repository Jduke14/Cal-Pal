<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

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
     * @Route("/apptlist", name="appt_list_cal_pal")
     */
    public function apptlist()
    {
        return $this->render('cal_pal/apptlist.html.twig');
    }
    /**
     * @Route("/prevappt", name="prev_appt_cal_pal")
     */
    public function prevappt()
    {
        return $this->render('cal_pal/prevappt.html.twig');
    }
    /**
     * @Route("/about", name="about_cal_pal")
     */
    public function about()
    {
        return $this->render('cal_pal/about.html.twig');
    }
}