<?php

namespace App\Controller\Admin;

use App\Entity\LordRattery;
use App\Form\LordRatteryType;
use App\Repository\LordRatteryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/rateries")
 */
class LordRatteryController extends AbstractController
{
    /**
     * @Route("/", name="lord_rattery_index", methods={"GET"})
     */
    public function index(LordRatteryRepository $lordRatteryRepository): Response
    {
        return $this->render('admin/lord_rattery/index.html.twig', [
            'lord_ratteries' => $lordRatteryRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="lord_rattery_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $lordRattery = new LordRattery();
        $form = $this->createForm(LordRatteryType::class, $lordRattery);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($lordRattery);
            $entityManager->flush();

            return $this->redirectToRoute('lord_rattery_index');
        }

        return $this->render('admin/lord_rattery/new.html.twig', [
            'lord_rattery' => $lordRattery,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{ratteryId}", name="lord_rattery_show", methods={"GET"})
     */
    public function show(LordRattery $lordRattery): Response
    {
        return $this->render('admin/lord_rattery/show.html.twig', [
            'lord_rattery' => $lordRattery,
        ]);
    }

    /**
     * @Route("/{ratteryId}/edit", name="lord_rattery_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, LordRattery $lordRattery): Response
    {
        $form = $this->createForm(LordRatteryType::class, $lordRattery);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('lord_rattery_index', [
                'ratteryId' => $lordRattery->getRatteryId(),
            ]);
        }

        return $this->render('admin/lord_rattery/edit.html.twig', [
            'lord_rattery' => $lordRattery,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{ratteryId}", name="lord_rattery_delete", methods={"DELETE"})
     */
    public function delete(Request $request, LordRattery $lordRattery): Response
    {
        if ($this->isCsrfTokenValid('delete'.$lordRattery->getRatteryId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($lordRattery);
            $entityManager->flush();
        }

        return $this->redirectToRoute('lord_rattery_index');
    }
}
