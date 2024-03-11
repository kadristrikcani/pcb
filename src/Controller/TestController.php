<?php

namespace App\Controller;

use App\Service\PodioService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController
{

    #[Route('/delete-podio', name: 'app_delete_podio_item')]
    public function deletePodioItem(PodioService $podioService): Response
    {
        $podioService->deletePodioItem('2594355667');
        return new Response('Deleted');
    }

}