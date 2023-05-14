<?php 

namespace App\Controller;


use App\Entity\Meal;
use App\Repository\MealRepository;
use App\Repository\OpeningHoursRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function home(MealRepository $mealRepository, Request $request, OpeningHoursRepository $openingHoursRepository)
    {
        $meals = $mealRepository->findBy(['isFavorite' => 'true'], ['id' => 'ASC'], 4);
        $openingHours = $openingHoursRepository->findAll();

        return $this->render('home.html.twig', [
            'meals' => $meals,
            'opening_hours' => $openingHours
        ]);
    }
}