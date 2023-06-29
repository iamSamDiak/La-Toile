<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MasterpieceController extends AbstractController
{
    public function data(){
        $jsonFilePath = $this->getParameter("kernel.project_dir") . "/var/data/data.json";
        $jsonData = file_get_contents($jsonFilePath);
        return json_decode($jsonData, true);
    }

    #[Route('/masterpiece', name: 'app_masterpiece')]
    public function masterpiece(): JsonResponse
    {
        return new JsonResponse($this->data());
    }

    #[Route('/masterpiece/{id}', name: 'app_masterpiece_id')]
    public function masterpiece_id($id): JsonResponse
    {
        $data = $this->data()["masterpiece"];
        $filteredItems = array_filter($data, function($item) use ($id) {
            return $item['id'] == $id;
        });
        $item = reset($filteredItems);

        return new JsonResponse($item);
    }
}
