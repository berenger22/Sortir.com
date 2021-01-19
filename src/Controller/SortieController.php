<?php

namespace App\Controller;

use App\Entity\Etat;
use App\Entity\Lieu;
use App\Entity\Sortie;
use App\Form\LieuType;
use App\Form\SortieType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SortieController extends AbstractController
{
    /**
     * @Route("/createSortie", name="creerSortie", methods={"GET","POST"})
     *  @Route("/editSortie/{id}", name="modifSortie", methods={"GET|POST"}, requirements={"id"="\d+"})
     */
    public function createEditSortie(Request $request, Sortie $sortie = null , EntityManagerInterface $em): Response
    {
        if(!$sortie){
            $sortie = new Sortie();
            $lieu = new Lieu();
        }
        
        $form = $this->createForm(SortieType::class, $sortie);
        $form->handleRequest($request);

        /*Ajout d'un lieu*/
        $formLieu = $this->createForm(LieuType::class, $lieu);
        $formLieu->handleRequest($request);
        if($formLieu->isSubmitted() && $formLieu->isValid()){
            $em->persist($lieu);
            $em->flush();
        }
        

        if ($form->isSubmitted() && $form->isValid()) {
            $modif = $sortie->getId() !== null;
            $sortie->setOrganise($this->getUser());
            if($form->get('publier')->isClicked()){
                $etat = $em->getRepository(Etat::class)->findOneBy(['libelle' => 'Ouverte']);
            }
            if($form->get('enregistrer')->isClicked()){
                $etat = $em->getRepository(Etat::class)->findOneBy(['libelle' => 'Créée']);
            }
            $sortie->setEtat($etat);
            $em->persist($sortie);
            $em->flush();
            $this->addFlash('success', ($modif) ? "La modification a été effectuée" : "Votre sortie a bien été enregistrée");
            return $this->redirectToRoute('home');
        }

        return $this->render('sortie/createEditSortie.html.twig', [
                    'sortie' => $sortie,
                    'form' => $form->createView(),
                    'formLieu' => $formLieu->createView(),
                    "isModification" => $sortie->getId() !== null]);
    }

    /**
     * @Route("/sortie/{id}", name="afficherSortie", requirements={"id"="\d+"})
     */
    public function afficherProfil(Sortie $sortie)
    {
        return $this->render("sortie/viewSortie.html.twig",[
            'sortie' => $sortie
        ]);
    }

    /**
     * @Route("/inscription/{id}",name="inscriptionSortie", requirements={"id"="\d+"})
     */
    public function inscriptionSortie(Request $request, Sortie $sortie, EntityManagerInterface $em)
    {
        if ($this->isCsrfTokenValid('inscription'.$sortie->getId(), $request->request->get('_token'))) {
            $sortie->addParticipant($this->getUser());
            $em->persist($sortie);
            $em->flush();
            $this->addFlash('success', "Vous êtes inscrit à la sortie !");
        }
        return $this->redirectToRoute('home');
    }

    // public function AjouterLieu(Lieu $lieu, Request $request, EntityManagerInterface $em)
    // {
    //     $formLieu = $this->createForm(LieuType::class, $lieu);
    //     $formLieu->handleRequest($request);

    //     if($formLieu->isSubmitted() && $formLieu->isValid()){
    //         $em->persist($lieu);
    //         $em->flush();
    //     }
    // }
}