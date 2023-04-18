<?php

namespace App\Controller;

use App\Repository\ChambreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    #[Route('/', name: 'show_home', methods: ['GET'])]
    public function showHome(ChambreRepository $repository): Response
    {
        return $this->render('default/show_home.html.twig', []);
    }
}