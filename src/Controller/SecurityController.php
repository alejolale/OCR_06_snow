<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route('/connexion', name: 'security.login', methods: ['GET', 'POST'])]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        return $this->render('pages/security/login.html.twig', [
            'last_username' =>  $authenticationUtils->getLastUsername(),
            'error' => $authenticationUtils->getLastAuthenticationError(),
        ]);
    }

    #[Route('/deconnexion', 'security.logout')]
    public function logout()
    {
        // Nothing to do here
    }

    #[Route('/inscription', 'security.registration', methods: ['GET', 'POST'])]
    public function registration(Request $request, EntityManagerInterface $manager, AuthenticationUtils $authenticationUtils): Response
    {
        $user = new User();
        $user->setRoles(['user']);
        $form = $this->createForm(RegistrationType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $user = $form->getData();


            /* call ORM user tables verify if exists */
            $emailsExits = $manager->getRepository(User::class)->findOneBy([
                'email' => $user->getEmail()
            ]);

            try {
                if ($emailsExits)
                {
                    return $this->render('pages/security/registration.html.twig', [ 'form' => $form->createView(), 'error' => 'Email déjà enregistré.']);
                }
                else {
                    $this->addFlash(
                        'success',
                        'Votre compte a bien été créé.'
                    );

                    $manager->persist($user);
                    $manager->flush();
                }
            } catch (\Exception $er) {
                return $this->redirectToRoute('security.registration', [
                    'error' => $authenticationUtils->getLastAuthenticationError()
                ]);
            }

            return $this->redirectToRoute('security.login');
        }
        return $this->render('pages/security/registration.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
