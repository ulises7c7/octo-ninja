<?php

namespace DonCar\PreciosServiceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('DonCarPreciosServiceBundle:Default:index.html.twig', array('name' => $name));
    }
}
