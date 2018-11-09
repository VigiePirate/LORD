<?php

namespace App\Controller\Front;

use App\Form\LordUserType;
use App\Entity\LordUser;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/register", name="user_registration")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $user = new LordUser();
        $form = $this->createForm(LordUserType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            // ... do any other work - like sending them an email, etc
            // maybe set a "flash" success message for the user
            // @TODO: l'utilisateur n'est pas actif, il faut lui envoyer un lien d'activation
            return $this->redirectToRoute('home');
        }

        return $this->render(
            'Front/registration/register.html.twig',
            array('form' => $form->createView())
        );
    }
}