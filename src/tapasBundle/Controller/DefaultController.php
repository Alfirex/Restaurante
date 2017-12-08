<?php

namespace tapasBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('tapasBundle:Default:index.html.twig');
    }
}
