<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NoFoundController extends AbstractController
{
    #[Route('/404', name: 'app_no_found')]
    public function index(): Response
    {
        return $this->render('404/404.html.twig');
    }
}
