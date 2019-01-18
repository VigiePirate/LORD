<?php

namespace App\Controller\Admin;

use App\Repository\LordRatteryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class RateryController extends AbstractController
{
    /**
     * @Route("/rateries/list", name="list_ratery")
     */
    public function list(LordRatteryRepository $rateriesRepository)
    {
        $rateries = $rateriesRepository->findAll();
        return $this->render('admin/ratery/list.html.twig', [
            'controller_name' => 'RateryController',
            'rateries' => $rateries
        ]);
    }
}
