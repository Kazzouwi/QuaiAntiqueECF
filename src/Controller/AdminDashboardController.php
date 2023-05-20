<?php 

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminDashboardController extends AbstractController 
{
    #[Route('/admin/dashboard', name:'admin_dashboard')]
    public function dashboard()
    {
        return $this->render('admin/adminDashboard.html.twig');
    }
}