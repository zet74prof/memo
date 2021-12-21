<?php

namespace App\Controller;

use App\Entity\SiteHisto;
use App\Form\SiteHistoType;
use App\Repository\SiteHistoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/sitehisto')]
class SiteHistoController extends AbstractController
{
    #[Route('/', name: 'site_histo_index', methods: ['GET'])]
    public function index(SiteHistoRepository $siteHistoRepository): Response
    {
        return $this->render('site_histo/index.html.twig', [
            'site_histos' => $siteHistoRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'site_histo_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $siteHisto = new SiteHisto();
        $form = $this->createForm(SiteHistoType::class, $siteHisto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($siteHisto);
            $entityManager->flush();

            return $this->redirectToRoute('site_histo_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('site_histo/new.html.twig', [
            'site_histo' => $siteHisto,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'site_histo_show', methods: ['GET'])]
    public function show(SiteHisto $siteHisto): Response
    {
        return $this->render('site_histo/show.html.twig', [
            'site_histo' => $siteHisto,
        ]);
    }

    #[Route('/{id}/edit', name: 'site_histo_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, SiteHisto $siteHisto, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(SiteHistoType::class, $siteHisto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('site_histo_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('site_histo/edit.html.twig', [
            'site_histo' => $siteHisto,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'site_histo_delete', methods: ['POST'])]
    public function delete(Request $request, SiteHisto $siteHisto, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$siteHisto->getId(), $request->request->get('_token'))) {
            $entityManager->remove($siteHisto);
            $entityManager->flush();
        }

        return $this->redirectToRoute('site_histo_index', [], Response::HTTP_SEE_OTHER);
    }
}
