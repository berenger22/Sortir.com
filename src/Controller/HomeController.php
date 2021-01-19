<?php

namespace App\Controller;

use App\Entity\FiltreSortie;
use App\Form\FiltreSortieType;
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
        
        $sorties = $repo->findAllSorties($filtre);
        foreach ($sorties as $sortie) {
            $outil = OutilSerie::gererEtat($sortie, $em);
        }
        dd($sorties);
        return $this->render('home/index.html.twig', [
            'sorties' => $sorties,
            'util' => $util->getLastUsername(),
            'error' => $util->getLastAuthenticationError(),
            'form' => $form->createView()
        ]);
    }
}
