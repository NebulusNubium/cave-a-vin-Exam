<?php

namespace App\Controller;

use App\Entity\Cave;
use App\Entity\Bouteilles;
use App\Repository\CaveRepository;
use App\Repository\BouteillesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/cave')]
class CaveController extends AbstractController
{
    #[Route('/', name: 'cave')]
    public function index(CaveRepository $caveRepository): Response
    {
        // Récupère l'utilisateur connecté
        $user = $this->getUser();
        if (!$user) {
            throw $this->createAccessDeniedException('You have to log in to view this page.');
        }

        // Récupère la cave de l'utilisateur
        $cave = $caveRepository->findOneBy(['user' => $user]);

        return $this->render('cave/index.html.twig', [
            'cave' => $cave,
        ]);
    }

    #[Route('/add/{id}', name: 'add_wine_to_cave')]
    #[IsGranted('ROLE_USER')]
    public function addBouteille(Bouteilles $bouteille, EntityManagerInterface $entityManager, CaveRepository $caveRepository): Response
    {
        // Récupère l'utilisateur connecté et sa cave
        $user = $this->getUser();
        if (!$user) {
            throw $this->createAccessDeniedException('You have to log in to access this page.');
        }

        $cave = $caveRepository->findOneBy(['user' => $user]);
        if (!$cave) {
            throw $this->createNotFoundException('You do not have a cellar.');
        }

        // Ajoute le vin à la cave si ce n'est pas déjà fait
        if (!$cave->getWine()->contains($bouteille)) {
            $cave->addWine($bouteille);
            $entityManager->persist($cave);
            $entityManager->flush();

            $this->addFlash('success', 'Bottle added to your cellar.');
        } else {
            $this->addFlash('info', 'This bottle is already in your cellar.');
        }

        return $this->redirectToRoute('cave');
    }

    #[Route('/remove/{id}', name: 'remove_wine_from_cave')]
    #[IsGranted('ROLE_USER')]
    public function removeWine(Bouteilles $bouteille, EntityManagerInterface $entityManager, CaveRepository $caveRepository): Response
    {
        // Récupère l'utilisateur connecté et sa cave
        $user = $this->getUser();
        if (!$user) {
            throw $this->createAccessDeniedException('You have to log in to access this page.');
        }

        $cave = $caveRepository->findOneBy(['user' => $user]);
        if (!$cave) {
            throw $this->createNotFoundException('You do not have a cellar.');
        }

        // Supprime le vin de la cave si présent
        if ($cave->getBouteilles()->contains($bouteille)) {
            $cave->removeBouteille($bouteille);
            $entityManager->persist($cave);
            $entityManager->flush();

            $this->addFlash('success', 'Your wine has been removed from the cellar.');
        } else {
            $this->addFlash('info', 'This wine is not in your cellar.');
        }

        return $this->redirectToRoute('cave');
    }

    
}
