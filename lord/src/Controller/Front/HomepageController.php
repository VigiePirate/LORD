<?php

namespace App\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomepageController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        return $this->render('Front/index.html.twig');
    }

    /**
     * @Route("/test", name="test")
     */
    public function test()
    {
        return new Response(json_encode('toot'));
    }
}