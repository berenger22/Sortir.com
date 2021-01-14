<?php

namespace App\Controller;

use App\Entity\Etat;
use App\Entity\Sortie;
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
     *  @Route("/editSortie/{id}", name="modifSortie", methods="GET|POST", requirements={"id"="\d+"})
     */
    public function createEditSortie(Request $request, Sortie $sortie = null , EntityManagerInterface $em): Response
    {
        if(!$sortie){
            $sortie = new Sortie();
        }
        
        $form = $this->createForm(SortieType::class, $sortie);
        $form->handleRequest($request);

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
                    "isModification" => $sortie->getId() !== null]);
    }
}
