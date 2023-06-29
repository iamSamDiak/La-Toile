<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class TableauController extends AbstractController
{
    #[Route('/tableau/col/{id}', name: 'app_tableau')]
    public function index($id, SessionInterface $session): Response
    {
        return $this->render('tableau/tableau.html.twig', [
            'id' => $id
        ]);
    }
}
