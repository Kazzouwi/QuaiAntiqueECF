<?php 

namespace App\Controller;

use App\Repository\OpeningHoursRepository;
use App\Repository\ReservationRepository;
use App\Repository\TableRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController
{
    #[Route('/reservation', name: 'reservation')]
    public function createReservation(OpeningHoursRepository $openingHoursRepository, TableRepository $tableRepository, Request $request)
    {
        $openingHours = $openingHoursRepository->findAll();

        $places = $request->query->get('places');

        $tables = $tableRepository->searchByPlaces($places);

        return $this->render('test.html.twig', [
            'opening_hours' => $openingHours,
            'tables' => $tables
        ]);
    }

    #[Route('/reservation/search', name: 'reservation_search')]
    public function searchReservation(OpeningHoursRepository $openingHoursRepository, TableRepository $tableRepository, ReservationRepository $reservationRepository, Request $request)
    {
        $openingHours = $openingHoursRepository->findAll();

        $places = $request->query->get('places');

        $tables = $tableRepository->searchByPlaces($places);

        $reservations = $reservationRepository->findAll();
        

        return $this->render('testSearch.html.twig', [
            'opening_hours' => $openingHours,
            'tables' => $tables,
            'reservations' => $reservations
        ]);
    }

    #[Route('/interval/{id}', name: 'interval')]
    public function timeInterval(OpeningHoursRepository $openingHoursRepository, $id)
    {
        $openingHours = $openingHoursRepository->find($id);

        $mOH = $openingHours->getMorningOpeningHour();
        $mCH = $openingHours->getMorningClosingHour();
        
        $mOHTimestamp = $mOH->getTimestamp();
        $mCHTimestamp = $mCH->getTimestamp();

        $interval = 900;
        
        $numberOfInterval = (( $mCHTimestamp - $mOHTimestamp ) / $interval) - 3;

        $listOfInterval = [];

        for($i = 0 ; $i < $numberOfInterval ; $i++) {
            $listOfInterval = [...$listOfInterval, $mOHTimestamp + ($i*$interval)];
        }
        

        return $this->render('interval.html.twig', [
            'list_of_interval' => $listOfInterval,
            'number_of_interval' => $numberOfInterval
        ]);
    }
}
