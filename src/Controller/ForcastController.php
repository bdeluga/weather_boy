<?php

namespace App\Controller;

use App\Entity\Forcast;
use App\Form\ForcastType;
use App\Repository\ForcastRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/forcast')]
class ForcastController extends AbstractController
{
    #[Route('/', name: 'app_forcast_index', methods: ['GET'])]
    public function index(ForcastRepository $forcastRepository): Response
    {
        return $this->render('forcast/index.html.twig', [
            'forcasts' => $forcastRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_forcast_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $forcast = new Forcast();
        $form = $this->createForm(ForcastType::class, $forcast,[

            'validation_groups' =>'create'
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($forcast);
            $entityManager->flush();

            return $this->redirectToRoute('app_forcast_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('forcast/new.html.twig', [
            'forcast' => $forcast,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_forcast_show', methods: ['GET'])]
    public function show(Forcast $forcast): Response
    {
        return $this->render('forcast/show.html.twig', [
            'forcast' => $forcast,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_forcast_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Forcast $forcast, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ForcastType::class, $forcast,[

            'validation_groups' =>'edit'
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_forcast_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('forcast/edit.html.twig', [
            'forcast' => $forcast,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_forcast_delete', methods: ['POST'])]
    public function delete(Request $request, Forcast $forcast, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$forcast->getId(), $request->request->get('_token'))) {
            $entityManager->remove($forcast);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_forcast_index', [], Response::HTTP_SEE_OTHER);
    }
}
