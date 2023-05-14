<?php 

namespace App\Controller;

use App\Entity\Meal;
use App\Repository\MealRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


class MenuController extends AbstractController 
{
    #[Route('/menu', name: 'menu')]
    public function showMenu(MealRepository $mealRepository)
    {
        $meals = $mealRepository->findAll();

        return $this->render('menu.html.twig', [
            'meals' => $meals
        ]);
    }
}