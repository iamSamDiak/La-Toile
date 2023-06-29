<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class ResultsController extends AbstractController
{
    #[Route('/sessions', name: 'app_sessions')]
    public function Sessions(SessionInterface $session): Response
    {
        $count = $session->get('count');
        $id_1 = $session->get('1');
        $id_2 = $session->get('2');
        $id_3 = $session->get('3');
        $isGameOver = $session->get('isGameOver');

        $str = $count . " " . $id_1 . " " . $id_2 . " " . $id_3 . " " . $isGameOver;

        return new Response($str);
    }

    #[Route('/get/{key}')]
    public function getSession(SessionInterface $session, $key): Response
    {
        $getSession = $session->get($key);
        if (is_array($getSession)){
            $getSession = implode(",", $getSession);
        }
        return new Response($getSession);
    }

    #[Route('/send_results', methods: ['POST'])]
    public function sendResults(SessionInterface $session, Request $request): Response
    {
        $data = json_decode($request->getContent(), true);

        //Si bonne réponse
        if ($data["res"] == 1){
            $session->set($data["id"], 1);

            //Si toutes bonnes réponses trouvées
            if ($session->get("1") == 1 && $session->get("2") == 1 && $session->get("3") == 1){
                $session->set("allFound", 1);
                return new Response("Gagné!");
            }

            return new Response("Bonne réponse!");
        }

        //Si mauvais réponse -1 count...
        $count = intval($session->get("count")) - 1;
        $session->set("count", $count);

        //Si 4 erreurs
        if (intval($session->get("count")) == 0){
            $session->set("isGameOver", 1);
            return new Response("Game over!");
        }

        //...et return mauvaise réponse
        return new Response("Mauvaise réponse");
    }

    #[Route('/clear', name: 'app_clear')]
    public function Clear(SessionInterface $session): Response
    {
        $session->clear();
        $session->set('count', 4);
        $session->set('1', 0);
        $session->set('2', 0);
        $session->set('3', 0);
        $session->set('isGameOver', 0);
        $session->set('allFound', 0);
        return new Response("cleared");
    }

    #[Route('/is_game_over', name: 'app_is_game_over')]
    public function isGameOver(SessionInterface $session): Response
    {
        $res = $session->get("isGameOver");
        return new Response($res);
    }

    #[Route('/has_been_found/{id}', name: 'app_has_been_found')]
    public function hasBeenFound(SessionInterface $session, $id): Response
    {
        $res = $session->get($id);
        return new Response($res);
    }

    #[Route('/all_found/', name: 'app_all_found')]
    public function allFound(SessionInterface $session): Response
    {
        $res = $session->get('allFound');
        return new Response($res);
    }




}
