<?php 

namespace App\Controller;


use App\Entity\Meal;
use App\Repository\MealRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function home(MealRepository $mealRepository, Request $request)
    {
        $meals = $mealRepository->findBy(['isFavorite' => 'true'], ['id' => 'ASC'], 2);

        return $this->render('home.html.twig', [
            'meals' => $meals
        ]);
    }
}