<?php

namespace App\Controller;

use App\Entity\FiltreSortie;
use App\Entity\MessageAnnulation;
use App\Form\FiltreSortieType;
use App\Form\MessageAnnulationType;
use App\Repository\SortieRepository;
use App\Outil\OutilSerie;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     */
    public function index(Request $request, AuthenticationUtils $util, SortieRepository $repo,
             EntityManagerInterface $em): Response
    {
        $filtre = new FiltreSortie();
        $filtre->setCampus($this->getUser()->getCampus());
        $form = $this->createForm(FiltreSortieType::class, $filtre);
        $form->handleRequest($request);
        $filtre->setIdUser($this->getUser()->getId());
        
        //Recherche les sorties selon le filtre et gère les états(etat en attente demande trop de ressource)
        $sorties = $repo->findAllSorties($filtre);
        // foreach ($sorties as $sortie) {
        //     $outil = OutilSerie::gererEtat($sortie, $em);
        // }

        //Gestion message MessageAnnulation
        $message = new MessageAnnulation();
        $formMessage = $this->createForm(MessageAnnulationType::class, $message);
        $formMessage->handleRequest($request);
        if($formMessage->isSubmitted() && $formMessage->isValid()){
            $idSortie = $_POST['idSortie'];
            $message->setSortie($repo->find($idSortie));
            $em->persist($message);
            $em->flush();
            return $this->redirectToRoute('annuleSortie',[
                'id' => $idSortie
            ]);
        }
        return $this->render('home/index.html.twig', [
            'sorties' => $sorties,
            'util' => $util->getLastUsername(),
            'error' => $util->getLastAuthenticationError(),
            'form' => $form->createView(),
            'formMessage' => $formMessage->createView()
        ]);
    }
}
