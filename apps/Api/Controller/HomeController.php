<?php

namespace Apps\Api\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class HomeController extends AbstractController
{
    public function __invoke() : JsonResponse
    {
        return new JsonResponse([]);
    }
}
