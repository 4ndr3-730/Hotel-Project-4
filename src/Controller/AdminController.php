<?php

namespace App\Controller;

use App\Repository\ChambreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    #[Route('/admin/tableau-de-bord', name: 'show_dashboard', methods: ['GET'])]
    public function showDashboard(ChambreRepository $ChambreRepository): Response 
    {
        $chambres = $ChambreRepository->findBy(['DeletedAt'=>null]);

        return $this->render('admin/show_dashboard.html.twig', [
            'chambres'=>$chambres,
        ]);
    }
}