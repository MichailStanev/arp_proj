<?php

namespace App\Controller;

use App\Entity\Vehicles;
use App\Form\VehiclesFormType;
use App\Form\VehicleFilterType;
use App\Repository\VehiclesRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Doctrine\ORM\Pagination\Paginator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


#[Route('/dashboard')]
class VehicleController extends AbstractController
{
    #[Route('/vehicle', name: 'app_dashboard_vehicle')]
    public function vehicle( VehiclesRepository $vehiclesRepository, Request $request ): Response
    {
        $form = $this->createForm(VehicleFilterType::class);
        $form->handleRequest($request);

        return $this->render('dashboard/vehicle/index.html.twig', [
            'controller_name' => 'DashboardController',
            'form' => $form->createView(),
            'paginator' => (new Paginator($vehiclesRepository->getFilterQuery($form, $request)))->paginate($request->get('page',1))
        ]);
    }

    #[Route('/vehicle/add', name: 'app_dashboard_vehicle_add')]
    public function add( Request $request, EntityManagerInterface $entityManager ): Response
    {
        $vehicle = new Vehicles();
        $form = $this->createForm( VehiclesFormType::class, $vehicle);
        $form->handleRequest( $request);

        if( $form->isSubmitted() && $form->isValid() ){
            $entityManager->persist( $vehicle);
            $entityManager->flush();
            return $this->redirectToRoute( 'app_dashboard_vehicle');
        }

        return $this->render( 'dashboard/vehicle/add.html.twig', [
            'controller_name' => 'DashboardController',
            'form' => $form->createView()

        ]);
    }

    #[Route('/vehicle/edit/{id}', name: 'app_dashboard_vehicle_edit')]
    public function edit( Request $request, EntityManagerInterface $entityManager, int $id ): Response
    {
        $vehicle = $entityManager->getRepository(Vehicles::class)->find($id);
        $form = $this->createForm( VehiclesFormType::class, $vehicle);
        $form->handleRequest( $request);

        if( $form->isSubmitted() && $form->isValid() ){
            $entityManager->flush();
            return $this->redirectToRoute( 'app_dashboard_vehicle');
        }

        return $this->render( 'dashboard/vehicle/edit.html.twig', [
            'controller_name' => 'DashboardController',
            'form' => $form->createView()
        ]);
    }

    #[Route('/vehicle/delete/{id}', name: 'app_dashboard_vehicle_delete')]
    public function delete( int $id, EntityManagerInterface $entityManager ): Response
    {
        $vehicle = $entityManager->getRepository(Vehicles::class)->find($id);
        $entityManager->remove( $vehicle);
        $entityManager->flush();

        return $this->redirectToRoute( 'app_dashboard_vehicle');
    }
}
