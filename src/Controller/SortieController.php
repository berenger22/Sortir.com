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
     * @Route("/createSortie", name="creerSortie")
     *  @Route("/editSortie/{id}", name="modifSortie", requirements={"id"="\d+"})
     */
    public function createEditSortie(Request $request, Sortie $sortie = null , EntityManagerInterface $em): Response
    {
        if(!$sortie){
            $sortie = new Sortie();
            
        }
        
        $sortie->setCampus($this->getUser()->getCampus());
        $form = $this->createForm(SortieType::class, $sortie);
        $form->handleRequest($request);

        /*Ajout d'un lieu*/
        $lieu = new Lieu();
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
    public function afficherSortie(Sortie $sortie)
    {
        return $this->render("sortie/viewSortie.html.twig",[
            'sortie' => $sortie
        ]);
    }

    /**
     * @Route("/inscription/{id}", name="inscriptionSortie", requirements={"id"="\d+"})
     */
    public function inscriptionSortie(Sortie $sortie, EntityManagerInterface $em)
    {
        $nbreInscrit = count($sortie->getParticipants());
        if($sortie->getEtat() == 'Ouverte' || $sortie->getNbInscriptionsMax() != $nbreInscrit){
            $sortie->addParticipant($this->getUser());
            $em->persist($sortie);
            $em->flush();
            $this->addFlash('success', "Vous êtes inscrit à la sortie !");
        }
        return $this->redirectToRoute('home');
    }

    /**
     * @Route("/annuleSortie/{id}", name="annuleSortie", requirements={"id"="\d+"})
     */
    public function annulerSortie(Sortie $sortie, EntityManagerInterface $em)
    {
        if($sortie->getEtat() != 'Activitée en cours'){
            $etat = $em->getRepository(Etat::class)->findOneBy(['libelle' => 'Annulée']);
            $sortie->setEtat($etat);
            $sortie->removeParticipant($this->getUser());
            $em->persist($sortie);
            $em->flush();
            $this->addFlash('success', "Vous avez annulée la sortie !");
        }else{
            $this->addFlash('success', "Vous ne pouvez pas annulée une sorite en cours.");
        }
        return $this->redirectToRoute('home');
    }  
}