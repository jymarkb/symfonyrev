<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


final class MainController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig');
    //     return $this->json([
    //         'message' => 'Welcome to your new controller!',
    //         'path' => 'src/Controller/MainController.php',
    //     ]);
    }

    #[Route('/hello/{name?}', name: 'hello')]
    public function helloUser(Request $request): Response
    {
        $name = $request->get('name') ;
        // return new Response('<h1> Hello ' .  $name .'!</h1>' );
        return $this->render('home/hello.html.twig',
        [
            'name' => $name
        ]);
    }
}
