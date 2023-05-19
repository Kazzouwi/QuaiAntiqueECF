<?php 

namespace App\Controller;

use App\Entity\Table;
use App\Repository\OpeningHoursRepository;
use App\Repository\ReservationRepository;
use App\Repository\TableRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Length;

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
        $places = $request->query->get('places');

        $tables = $tableRepository->searchByPlaces($places);
        
        $date = $request->query->get('date');

        $reservations = $reservationRepository->searchByDate($date, $places);

        $dateTime = strtotime($date);

        $day = date("l", $dateTime);

        $openingHours = $openingHoursRepository->searchByDay($day);

        if ( $openingHours->getMorningOpeningHour() == false and $openingHours->getEveningOpeningHour() == false) {
            return $this->render('closed.html.twig');
        }

        if ($tables == false) {
            return $this->render('full.html.twig', [
                'places' => $places
            ]);
        }

        

        $mOH = $openingHours->getMorningOpeningHour();
        $mCH = $openingHours->getMorningClosingHour();
        $eOH = $openingHours->getEveningOpeningHour();
        $eCH = $openingHours->getEveningClosingHour();
        
        $mOHTimestamp = $mOH->getTimestamp();
        $mCHTimestamp = $mCH->getTimestamp();
        $eOHTimestamp = $eOH->getTimestamp();
        $eCHTimestamp = $eCH->getTimestamp();

        $interval = 900;
        
        $numberOfIntervalMorning = (( $mCHTimestamp - $mOHTimestamp ) / $interval) - 3;
        $numberOfIntervalEvening = (( $eCHTimestamp - $eOHTimestamp ) / $interval) - 3;

        $listOfInterval = [];

        for($i = 0 ; $i < $numberOfIntervalMorning ; $i++) {
            $listOfInterval = [...$listOfInterval, $mOHTimestamp + ($i*$interval)];
        }

        for($i = 0 ; $i < $numberOfIntervalEvening ; $i++) {
            $listOfInterval = [...$listOfInterval, $eOHTimestamp + ($i*$interval)];
        }

        $resetList = $listOfInterval;

        $newArray = [];
        foreach ($tables as $table) {
            foreach($reservations as $reservation){
                if ( $reservation->getReservationTable()->getId() == $table->getId()) {
                    $rHour = $reservation->getHour();
                    $rHourTimeStamp = $rHour->getTimestamp();

                    $position = array_search($rHourTimeStamp, $listOfInterval);


                        if ( $position !== false ) {
                            $startingIndex = max(0, $position - 3);
                            $endingIndex = min(count($listOfInterval) - 1, $position + 3);

                            array_splice($listOfInterval, $startingIndex, $endingIndex - $startingIndex + 1);
                            unset($listOfInterval[$position]);

                        }
                } else {
                    $listOfInterval = $resetList;
                }                
            }
        }
        sort($listOfInterval);

        $numberOfFreeTime = count($listOfInterval);
        return $this->render('testSearch.html.twig', [
            'tables' => $tables,
            'reservations' => $reservations,
            'list_of_interval' => $listOfInterval,
            'number_of_free_time' => $numberOfFreeTime
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

    #[Route('/show/test/{id}', name: 'show_test')]
    public function showTest(Table $table)
    {
        return $this->render('showTest.html.twig', [
            'table' => $table,
        ]);  
    }
}
