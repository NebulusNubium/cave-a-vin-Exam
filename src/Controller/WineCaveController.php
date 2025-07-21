<?php
// src/Controller/WineCaveController.php

namespace App\Controller;

use App\Form\WineType;
use App\Entity\Bouteilles;
use App\Form\WineFilterType;
use App\Repository\CaveRepository;
use App\Repository\BouteillesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class WineCaveController extends AbstractController
{
    #[Route('/wines', name: 'app_wine_cave')]
    public function index(BouteillesRepository $repository, Request $request, PaginatorInterface $paginator
    ): Response {
        //paginator
        $qb = $repository->createQueryBuilder('a')
                   ->orderBy('a.publishedAt', 'DESC');
        $pagination = $paginator->paginate($qb, $request->query->getInt('page', 1), 10);
        $form = $this->createForm(WineFilterType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $bouteilles = $repository->filterWines($form->getData());
        } else {
            $bouteilles = $repository->findAll();
        }

        return $this->render('wine_cave/index.html.twig', [
            'form'  => $form->createView(),
            'caves' => $bouteilles,
            'pagination'=> $pagination,
        ]);
    }

    #[Route(
        path: '/wine/{id}',
        name: 'app_wine_change',
        defaults: ['id' => null],
        requirements: ['id' => '\d+']
    )]
    public function change(
        Request $request,
        EntityManagerInterface $entityManager,
        ?Bouteilles $bouteille
    ): Response {
        // If no {id} parameter, we’re creating a new bottle
        if (null === $bouteille) {
            $bouteille = new Bouteilles();
        }

        $form = $this->createForm(WineType::class, $bouteille);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($bouteille);
            $entityManager->flush();

            return $this->redirectToRoute('home');
        }

        return $this->render('wine_cave/addupdate.html.twig', [
            'wineForm'       => $form->createView(),
            'isModification' => null !== $bouteille->getId(),
        ]);
    }

    #[Route('/wine/remove/{id}', name: 'delete_wine', methods: ['POST'])]
    public function remove(
        Bouteilles $bouteille,
        Request $request,
        EntityManagerInterface $entityManager
    ): Response {
        if ($this->isCsrfTokenValid('SUP'.$bouteille->getId(), $request->request->get('_token'))) {
            $entityManager->remove($bouteille);
            $entityManager->flush();
            $this->addFlash('success', 'La suppression a été effectuée');
        }

        return $this->redirectToRoute('home');
    }

    #[Route('/caves', name: 'user_caves')]
    public function listCaves(CaveRepository $caveRepository): Response
    {
        $caves = $caveRepository->findAll();

        return $this->render('wine_cave/user_caves.html.twig', [
            'caves' => $caves,
        ]);
    }

    #[Route('/cave/{id}', name: 'view_cave')]
    public function viewCave(
        int $id,
        CaveRepository $caveRepository
    ): Response {
        $cave = $caveRepository->find($id);
        if (!$cave) {
            throw $this->createNotFoundException('Cave non trouvée.');
        }

        return $this->render('wine_cave/view_cave.html.twig', [
            'cave' => $cave,
        ]);
    }
}
