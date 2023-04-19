<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'admin_show', methods:['GET'])]
    public function show(): Response
    {
        return $this->render('admin/show.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }
}
