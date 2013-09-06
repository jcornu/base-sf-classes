<?php

namespace Administration\BaseBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BaseController extends Controller
{
    public function indexAction()
    {
        return $this->render('BaseBundle:Base:index.html.twig', array());
    }
}
