<?php

namespace App\Controller;

use App\Entity\Site;
use App\Entity\SiteHisto;
use App\Entity\StateHisto;
use App\Entity\User;
use App\Form\ChangePasswordType;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user')]
class UserController extends AbstractController
{
    #[Route('/', name: 'user_index', methods: ['GET'])]
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'user_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ManagerRegistry $doctrine, UserPasswordHasherInterface $passwordHasher): Response
    {
        $user = new User();
        $entityManager = $doctrine->getManager();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        $user->setUsername($form->get('firstname')->getData() . '.' . $form->get('surname')->getData());
        $user->CleanUserName();

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword(
                $passwordHasher->hashPassword(
                    $user,
                    'motsetmerveilles@59%UserPwd'
                )
            );
            $siteHisto = new SiteHisto();
            $siteHisto->setUser($user);
            //on récupère la liste des sites (un tableau d'objets de la classe Site) pour l'ajouter à l'objet SiteHisto
            //et on vient persister cet objet SiteHisto ce qui permet de conserver l'historique des modifs
            $sites = $form->get('site')->getData();
            foreach ($sites as $site)
            {
                $siteHisto->addSite($site);
            }
            $siteHisto->setDate(new \DateTime('now'));
            //on créé un objet StateHisto pour stocker le premier état 'actif' dans l'historique de statut
            $state = new StateHisto(new \DateTime('now'),true,'Création');
            $state->setUser($user);
            $entityManager->persist($user);
            $entityManager->persist($state);
            $entityManager->persist($siteHisto);
            $entityManager->flush();

            return $this->redirectToRoute('user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user/new.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/changepassword', name: 'user_change_password', methods: ['GET', 'POST'])]
    public function changePassword(Request $request, ManagerRegistry $doctrine, UserPasswordHasherInterface $passwordHasher): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        /** @var \App\Entity\User $user */
        $user = $this->getUser();
        $form = $this->createForm(ChangePasswordType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if($passwordHasher->isPasswordValid($user, $form->get('plainPasswordCurrent')->getData()))
            {
                $user->setPassword(
                    $passwordHasher->hashPassword(
                        $user,
                        $form->get('plainPasswordNew')->getData()
                    )
                );
                $entityManager = $doctrine->getManager();
                $entityManager->persist($user);
                $entityManager->flush();

                return $this->renderForm('user/changepassword.html.twig', [
                    'user' => $user,
                    'form' => $form,
                    'success' => true,
                ]);
            }
            else
            {
                return $this->renderForm('user/changepassword.html.twig', [
                    'user' => $user,
                    'form' => $form,
                    'success' => false,
                ]);
            }
        }

        return $this->renderForm('user/changepassword.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'user_show', methods: ['GET'])]
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/{id}/edit', name: 'user_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ManagerRegistry $doctrine, User $user): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $doctrine->getManager()->flush();

            return $this->redirectToRoute('user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'user_delete', methods: ['POST'])]
    public function delete(Request $request, ManagerRegistry $doctrine, User $user): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager = $doctrine->getManager();
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('user_index', [], Response::HTTP_SEE_OTHER);
    }
}
