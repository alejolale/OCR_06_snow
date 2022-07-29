<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserPasswordType;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/utilisateur/edition/{id}', name: 'user.edit', methods: ['GET', 'POST'])]
    public function edit(User $user, Request $request, EntityManagerInterface $manager): Response
    {
        if (!$this->getUser() || $this->getUser() !== $user) {
            return $this->redirectToRoute('security.login');
        }

        $form =  $this->createForm(UserType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            $manager->persist($user);
            $manager->flush();

            $this->addFlash(
                'success',
                'les informations de votre compte ont bien été modifiées'
            );
            return $this->redirectToRoute('user.edit', ['id' => $user->getId()]);
        }

        return $this->render('pages/user/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/utilisateur/edition-password/{id}', name: 'user.edit.password', methods: ['GET', 'POST'])]
    public function editPassword(User $user, Request $request, UserPasswordHasherInterface $hasher, EntityManagerInterface $manager): Response
    {
        if (!$this->getUser() || $this->getUser() !== $user) {
            return $this->redirectToRoute('security.login');
        }

        $form = $this->createForm(UserPasswordType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            if ($hasher->isPasswordValid($user, $form->getData()['password'])){
                $user->setPassword(
                    $form->getData()['newPassword']
                );

                $manager->persist($user);
                $manager->flush();

                $this->addFlash(
                    'success',
                    'le mot de passe à été modifié'
                );
                return $this->redirectToRoute('home');
            } else {
                $this->addFlash(
                    'warning',
                    'le mot de passe renseigné est incorrect'
                );
                return $this->redirectToRoute('user.edit.password', ['id' => $user->getId()]);
            }
        }

        return $this->render('pages/user/editPassword.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
