<?php

namespace App\Controller;
use App\Entity\User;
use App\Entity\Cave;
use App\Form\CellarCreateType;
use App\Repository\BouteillesRepository;
use App\Repository\CaveRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class MyCellarController extends AbstractController
{
    #[Route('/MyCellar', name: 'my_cellar')]
    public function addCellar(Request $request, EntityManagerInterface $entityManager, CaveRepository $caveRepository, BouteillesRepository $bouteillesRepository): Response
    {
                $cave = $caveRepository->findOneBy([
            'user' => $this->getUser()
        ]);
        $bouteilles = $bouteillesRepository->findByUserCaves($this->getUser());

        $cellar = new Cave();
        $formCreate = $this->createForm(CellarCreateType::class, $cellar);
        $formCreate->handleRequest($request);
            if ($formCreate->isSubmitted() && $formCreate->isValid()) {
            $user= $this->getUser();
            // on le lie à l'image avant le persist()
            $cellar->setUser($user);
            $entityManager->persist($cellar);
            $entityManager->flush();
            
            $this->addFlash('success', 'Image enregistrée !');
            return $this->redirectToRoute('cave');}
        
        return $this->render('wine_cave/view_cave.html.twig', [
            'addCellar'=> $formCreate->createView(),
            'cave'      => $cave,         // a single Cave|null
            'bouteilles'=>$bouteilles,
        ]);
    }
}
