<?php

namespace App\Controller;

use App\Form\FilterApprenantType;
use App\Repository\ApprenantRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/apprenant/vue')]
class ApprenantViewsController extends AbstractController
{
    #[Route('/filtres', name: 'apprenant_par_territoire', methods: ['GET', 'POST'])]
    public function byterritoire(Request $request, ApprenantRepository $apprenantRepository): Response
    {
        $form = $this->createForm(FilterApprenantType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $apprenantsList = $apprenantRepository->findByFilter($form->get('territoire')->getData(),
                $form->get('site')->getData(),
                $form->get('dateDeb')->getData(),
                $form->get('dateFin')->getData()
            );
            return $this->renderForm('apprenant_views/index.html.twig', [
                'form' => $form,
                'apprenants' => $apprenantsList,
            ]);
        }

        return $this->renderForm('apprenant_views/index.html.twig', [
            'form' => $form,
            'apprenants' => null,
        ]);
    }
}
