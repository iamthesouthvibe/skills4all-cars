<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Car;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(EntityManagerInterface $em): Response
    {

        $cars = $em->getRepository(Car::class)->findBy(array(), array('id' => 'DESC'), 8);

        return $this->render('home/index.html.twig', [
            'cars' => $cars,
        ]);
    }
}
