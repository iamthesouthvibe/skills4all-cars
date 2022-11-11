<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Car;
use App\Form\SearchNameType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request; // Nous avons besoin d'accéder à la requête pour obtenir le numéro de page
use Knp\Component\Pager\PaginatorInterface; 
class CarController extends AbstractController
{
    #[Route('/car', name: 'app_car')]
    public function index(EntityManagerInterface $em, PaginatorInterface $paginator, Request $request): Response
    {

        /** ELEMENTS */
        $donnees = $em->getRepository(Car::class)->findBy(array(), array('id' => 'DESC'));

        $form = $this->createForm(SearchNameType::class);

        /** TRAITEMETNS */
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $name = ($form->getData()->getName() !== NULL) ? $form->getData()->getName() : '';
            $categorie = ($form->getData()->getCarCategory() !== null) ? $form->getData()->getCarCategory()->getName() : '';
           
            if ($name !== '' || $categorie !== '') {
                $donnees = $em->getRepository(Car::class)->findByWord($name, $categorie);
            } else {
                $donnees = $em->getRepository(Car::class)->findBy(array(), array('id' => 'DESC'));
            }
            
        }  

        //pagination
        $cars = $paginator->paginate(
            $donnees, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            20 /*limit per page*/
        );


        /**  vue */
        return $this->render('car/index.html.twig', [
            'cars' => $cars,
            'form' => $form->createView()
        ]);
    }


}
