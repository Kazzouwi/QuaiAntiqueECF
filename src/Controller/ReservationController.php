<?php 

namespace App\Controller;


use App\Entity\Reservation;
use App\Repository\OpeningHoursRepository;
use App\Repository\ReservationRepository;
use App\Repository\TableRepository;
use DateTime;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class ReservationController extends AbstractController
{
    #[Route('/reservation', name: 'reservation')]
    public function createReservation(OpeningHoursRepository $openingHoursRepository, TableRepository $tableRepository, Request $request)
    {
        $openingHours = $openingHoursRepository->findAll();

        $places = $request->query->get('places');

        $tables = $tableRepository->searchByPlaces($places);

        return $this->render('reservation/reservation.html.twig', [
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

        $dateFormat = new DateTime();

        $dateFormat->setTimestamp($dateTime);

        $day = date("l", $dateTime);

        $openingHours = $openingHoursRepository->searchByDay($day);

        if ( $openingHours->getMorningOpeningHour() == false and $openingHours->getEveningOpeningHour() == false) {
            return $this->render('reservation/reservationClosed.html.twig');
        }

        if ($tables == false) {
            return $this->render('reservation/reservationFull.html.twig', [
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

        $duplicates = [];

        foreach ($tables as $table) {
            $tableReservation = $table->getTableReservation();
            if (count($tableReservation) == 0) {
                $listOfInterval = $resetList;
                break;
            } else {
                foreach($reservations as $reservation){
                    if ( $reservation->getReservationTable()->getId() == $table->getId()) {
                        $rHour = $reservation->getHour();
                        $rHourTimeStamp = $rHour->getTimestamp();

                        $position = array_search($rHourTimeStamp, $listOfInterval);


                        if ( $position !== false ) {
                            $startingIndex = max(0, $position - 3);
                            $endingIndex = min(count($listOfInterval) - 1, $position + 3);

                            $newArray = array_merge($newArray, array_splice($listOfInterval, $startingIndex, $endingIndex - $startingIndex + 1));

                            $uniqueArray = array_unique($newArray);
                            $duplicates = array_diff_assoc($newArray, $uniqueArray);

                            $listOfInterval = $resetList;
                        }
                    }              
                }
                $listOfInterval = array_diff($listOfInterval, $duplicates);

                sort($listOfInterval);
            }
        }

        if ($listOfInterval == []) {
            return $this->render('reservation/reservationFull.html.twig', [
                'places' => $places
            ]);
        }


        

        $numberOfFreeTime = count($listOfInterval);
        return $this->render('reservation/reservationSearch.html.twig', [
            'tables' => $tables,
            'reservations' => $reservations,
            'list_of_interval' => $listOfInterval,
            'number_of_free_time' => $numberOfFreeTime,
            'date' => $date,
            'numberOfPeople' => $places
        ]);
    }

    #[Route('reservation/new', name: 'reservation_new')]
    public function newReservation(EntityManagerInterface $entityManager, Request $request, TableRepository $tableRepository, ReservationRepository $reservationRepository)
    {
        
        $data = json_decode($request->getContent(), true);

        $places = $data['numberOfPeople'];

        $tables = $tableRepository->searchByPlaces($places);

        
        $date = $data['date'];

        $reservations = $reservationRepository->searchByDate($date, $places);

        $dateTimeInterface = DateTimeImmutable::createFromFormat('Y-m-d', $date);

        $hour = $data['hour'];

        $hourTimeInterface = DateTimeImmutable::createFromFormat('H:i', $hour);

        $hourTimeStamp = strtotime($data['hour']);


        $interval = 900;

        $tableId = null;


        foreach ($tables as $table) {
            $tableReservation = $table->getTableReservation();
            if (count($tableReservation) == 0) {    
                $tableId = $table->getId();
            } else {
                foreach ($reservations as $reservation) {
                    $reservationTimeStamp = $reservation->getHour()->getTimestamp();
                    if ( $reservation->getReservationTable()->getId() == $table->getId()){
                        $reservationTimeStamp = $reservationTimeStamp + ($interval*3);
                        if (  $hourTimeStamp >= $reservationTimeStamp && $hourTimeStamp <= $reservationTimeStamp ) {
                            $tableId = $table->getId();
                        }
                    }
                }
            }
        }

        if ($tableId == null) {
            $randomKey = array_rand($tables);
            $randomTable = $tables[$randomKey];

            $tableId = $randomTable->getId();
        }

        $table = $tableRepository->find($tableId);


        $reservation = new Reservation();
        $reservation
            ->setDate($dateTimeInterface)
            ->setHour($hourTimeInterface)
            ->setNumberOfPeople($data['numberOfPeople'])
            ->setReservationTable($table);

        $entityManager->persist($reservation);
        $entityManager->flush();

        return $this->render('reservation/reservationSuccess.html.twig');

    }


}
