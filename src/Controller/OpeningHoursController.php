<?php

namespace App\Controller;

use App\Entity\OpeningHours;
use App\Form\OpeningHoursType;
use App\Repository\OpeningHoursRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/opening/hours')]
class OpeningHoursController extends AbstractController
{
    #[Route('/', name: 'app_opening_hours_index', methods: ['GET'])]
    public function index(OpeningHoursRepository $openingHoursRepository): Response
    {
        return $this->render('opening_hours/index.html.twig', [
            'opening_hours' => $openingHoursRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_opening_hours_new', methods: ['GET', 'POST'])]
    public function new(Request $request, OpeningHoursRepository $openingHoursRepository): Response
    {
        $openingHour = new OpeningHours();
        $form = $this->createForm(OpeningHoursType::class, $openingHour);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $openingHoursRepository->save($openingHour, true);

            return $this->redirectToRoute('app_opening_hours_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('opening_hours/new.html.twig', [
            'opening_hour' => $openingHour,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_opening_hours_show', methods: ['GET'])]
    public function show(OpeningHours $openingHour): Response
    {
        return $this->render('opening_hours/show.html.twig', [
            'opening_hour' => $openingHour,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_opening_hours_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, OpeningHours $openingHour, OpeningHoursRepository $openingHoursRepository): Response
    {
        $form = $this->createForm(OpeningHoursType::class, $openingHour);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $openingHoursRepository->save($openingHour, true);

            return $this->redirectToRoute('app_opening_hours_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('opening_hours/edit.html.twig', [
            'opening_hour' => $openingHour,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_opening_hours_delete', methods: ['POST'])]
    public function delete(Request $request, OpeningHours $openingHour, OpeningHoursRepository $openingHoursRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$openingHour->getId(), $request->request->get('_token'))) {
            $openingHoursRepository->remove($openingHour, true);
        }

        return $this->redirectToRoute('app_opening_hours_index', [], Response::HTTP_SEE_OTHER);
    }
}
