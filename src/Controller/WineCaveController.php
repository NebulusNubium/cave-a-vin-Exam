<?php

namespace App\Controller;

use App\Form\WineFilterType;
use App\Entity\Bouteilles;
use App\Repository\BouteillesRepository;
use App\Form\WineType;
use App\Repository\CaveRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class WineCaveController extends AbstractController{
    #[Route('/wine', name: 'app_wine_cave')]
public function index(BouteillesRepository $repository, Request $request): Response
{
    $form = $this->createForm(WineFilterType::class);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $data = $form->getData();
        // dump($data); // Vérifier les valeurs filtrées
        $bouteilles = $repository->filterWines($data);
    } else {
        $bouteilles = $repository->findAll();
    }

    return $this->render('wine_cave/index.html.twig', [
        'form' => $form->createView(),
        'caves' => $bouteilles, 
    ]);
}





    // #[IsGranted('ROLE_ADMIN')]
    #[Route('/wine/{id}', name: 'modify_wine')]
    #[Route('/wine', name: 'add_wine')]
    public function change(Bouteilles $bouteille, Request $request, EntityManagerInterface $entityManager): Response
    {
        // Vérification si l'objet existe via l'injection de dependance
        // Si injection de dependance = On est en Modification
        // Sinon, on est un Creation et on créé l'objet
        if(!$bouteille){
            $bouteille = new Bouteilles;
        }
        

        // Récupération du formulaire et association avec l'objet
        $form = $this->createForm(WineType::class,$bouteille);

        // Récupération des données POST du formulaire
        $form->handleRequest($request);
        // Vérification si le formulaire est soumis et Valide
        if($form->isSubmitted() && $form->isValid()){
            // Persistance des données
            $entityManager->persist($bouteille);
            // Envoi en BDD
            $entityManager->flush();

            // Redirection de l'utilisateur
            return $this->redirectToRoute('home');
        }

        return $this->render('wine_cave/addupdate.html.twig', [
            'wineForm' => $form->createView(), //envoie du formulaire en VUE
            'isModification' => $bouteille->getId() !== null //Envoie d'un variable pour définir si on est en Modif ou Créa
        ]);
    }

    #[Route('/wine/remove/{id}', name: 'delete_wine')]
    public function remove(Bouteilles $bouteille, Request $request, EntityManagerInterface $entityManager)
    {
        
        

        if($this->isCsrfTokenValid('SUP'.$bouteille->getId(),$request->get('_token'))){
            $entityManager->remove($bouteille);
            $entityManager->flush();
            $this->addFlash('success','La suppression à été effectuée');
            return $this->redirectToRoute('home');

        }
    }

    // #[Route('/wine/', name: 'app_filter')]
    // public function filter(WineRepository $repository, Request $request): Response
    // {
    //     $filter = $request->get('filter', 'all');
    // }
    #[Route('/caves', name: 'user_caves')]
    public function listCaves(CaveRepository $caveRepository): Response
    {
        // Récupérer toutes les caves des utilisateurs
        $caves = $caveRepository->findAll();

        return $this->render('wine_cave/user_caves.html.twig', [
            'caves' => $caves,
        ]);
    }

    #[Route('/cave/{id}', name: 'view_cave')]
    public function viewCave(int $id, CaveRepository $caveRepository): Response
    {
        $cave = $caveRepository->find($id);

        if (!$cave) {
            throw $this->createNotFoundException("Cave non trouvée.");
        }

        return $this->render('wine_cave/view_cave.html.twig', [
            'cave' => $cave,
        ]);
    }

    


}
