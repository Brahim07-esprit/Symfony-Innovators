<?php

namespace App\Controller;

use App\Entity\Vehicule;
use App\Form\VehiculeType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\Exception\FileException;




#[Route('/vehicule/contoller')]
class VehiculeContollerController extends AbstractController
{
    #[Route('/', name: 'app_vehicule_contoller_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $vehicules = $entityManager
            ->getRepository(Vehicule::class)
            ->findAll();

        return $this->render('vehicule_contoller/index.html.twig', [
            'vehicules' => $vehicules,
        ]);
    }

    #[Route('/new', name: 'app_vehicule_contoller_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $vehicule = new Vehicule();

        $marqueChoices = [
            'Voiture' => ['Audi', 'BMW', 'Chevrolet', 'Ferrari', 'Ford', 'Hyundai', 'Mercedes', 'Toyota', 'Volkswagen'],
            'Van' => ['Mercedes', 'Ford', 'Chevrolet', 'Dodge', 'Nissan', 'RAM', 'Toyota', 'Volkswagen', 'Fiat', 'GMC'],
            'Camion' => ['Ford', 'Chevrolet', 'RAM', 'GMC', 'Toyota', 'Nissan', 'Jeep', 'Dodge'],
            'Bus' => ['Blue Bird', 'Thomas Built Buses', 'Gillig', 'New Flyer', 'Prevost', 'Mci', 'Van Hool']
        ];

        $flatMarqueChoices = [];
        foreach ($marqueChoices as $type => $marques) {
            foreach ($marques as $marque) {
                $flatMarqueChoices[$marque] = $marque;
            }
        }

        $form = $this->createForm(VehiculeType::class, $vehicule, [
            'marque_choices' => $flatMarqueChoices,
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $imageFile */
            $imageFile = $form->get('imagev')->getData();

            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = $vehicule->getImmatriculation() . '-' . uniqid() . '.' . $imageFile->guessExtension();

                try {
                    $imageFile->move(
                        $this->getParameter('imagev_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                $vehicule->setImagev($newFilename);
            }

            try {
                $entityManager->persist($vehicule);
                $entityManager->flush();

                return $this->redirectToRoute('app_vehicule_contoller_index', [], Response::HTTP_SEE_OTHER);
            } catch (UniqueConstraintViolationException $e) {
                $this->addFlash('error', 'The immatriculation already exists. Please choose a different one.');
            }
        }

        return $this->renderForm('vehicule_contoller/new.html.twig', [
            'vehicule' => $vehicule,
            'form' => $form,
        ]);
    }


    #[Route('/{immatriculation}', name: 'app_vehicule_contoller_show', methods: ['GET'])]
    public function show(Vehicule $vehicule): Response
    {
        return $this->render('vehicule_contoller/show.html.twig', [
            'vehicule' => $vehicule,
        ]);
    }

    #[Route('/{immatriculation}/edit', name: 'app_vehicule_contoller_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Vehicule $vehicule, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(VehiculeType::class, $vehicule);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_vehicule_contoller_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('vehicule_contoller/edit.html.twig', [
            'vehicule' => $vehicule,
            'form' => $form,
        ]);
    }

    #[Route('/{immatriculation}', name: 'app_vehicule_contoller_delete', methods: ['POST'])]
    public function delete(Request $request, Vehicule $vehicule, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $vehicule->getImmatriculation(), $request->request->get('_token'))) {
            $entityManager->remove($vehicule);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_vehicule_contoller_index', [], Response::HTTP_SEE_OTHER);
    }
}
