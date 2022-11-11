<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request; // Nous avons besoin d'accéder à la requête pour obtenir le numéro de page
use Knp\Component\Pager\PaginatorInterface; 
use Symfony\Component\String\Slugger\SluggerInterface;
use App\Entity\Car;
use App\Form\CarFormType;

class AdminController extends AbstractController
{

    #[Route('/admin', name: 'app_admin')]
    public function index(EntityManagerInterface $em, PaginatorInterface $paginator, Request $request): Response
    {

        /** ELEMENTS */
        $donnees = $em->getRepository(Car::class)->findBy(array(), array('id' => 'DESC'));

         //pagination
         $cars = $paginator->paginate(
            $donnees, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            20 /*limit per page*/
        );


        /** VUE */
        return $this->render('admin/index.html.twig', [
            'cars' => $cars,
        ]);
    }


    #[Route('/admin/car/add', name: 'app_admin_car_add')]
    public function add_car(Request $request, EntityManagerInterface $em, SluggerInterface $slugger)
    {

        /* ELEMENT */
        $car = new Car();
        $form = $this->createForm(CarFormType::class, $car);
        $form->handleRequest($request);
        //

        /* TRAITEMENT */
        if ($form->isSubmitted() && $form->isValid()) {

            // Create slug
            $name = $form->getData()->getName();
            $slug = $slugger->slug($name);
            $car->setSlug($slug);

            // Sauvgarder nos données 
            $em->persist($car);
            $em->flush();

            $this->addFlash(
                'notice',
                'Car add !'
            );
            return $this->redirectToRoute('app_admin');
        }
        //

        /* VUE */
        return $this->renderForm('admin/add_car.html.twig', [
            'form' => $form,
        ]);
        //
    }


    #[Route('/admin/car/edit/{slug}', name: 'app_admin_car_edit')]
    public function update_car(Request $request, EntityManagerInterface $em, SluggerInterface $slugger, $slug)
    {

        /* ELEMENT */
        $car = $em->getRepository(Car::class)->findOneBy(array('slug' => $slug));

        if (!$car) {
            throw new NotFoundHttpException("Car don't exist");
        }

        $form = $this->createForm(CarFormType::class, $car);

        $form->handleRequest($request);
        //
        
        /* TRAITEMENT */
        if ($form->isSubmitted() && $form->isValid()) {

            $name = $form->getData()->getName();
            // Create slug
            $slug = $slugger->slug($name);
            $car->setSlug($slug);

            // Sauvgarder nos données 
            $em->persist($car);
            $em->flush();

            $this->addFlash(
                'notice',
                'Car update !'
            );
            return $this->redirectToRoute('app_admin');
        }
        //

        /* VUE */
        return $this->renderForm('admin/add_car.html.twig', [
            'form' => $form,
        ]);
        //
    }

    #[Route('/admin/car/delete/{slug}', name: 'app_admin_car_delete')]
    public function delete_evenement(EntityManagerInterface $em, $slug)
    {
        /** ELEMENTS */
        $car = $em->getRepository(Car::class)->findOneBy(array('slug' => $slug));

        if (!$car) {
            throw new NotFoundHttpException("Car don't exist");
        }

        $em->remove($car);
        $em->flush();

        $this->addFlash(
            'notice',
            'Car delete !'
        );
        //

        /* VUE */
        return $this->redirectToRoute('app_admin');
    }
}
