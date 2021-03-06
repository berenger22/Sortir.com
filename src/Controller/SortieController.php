<?php

namespace App\Controller;

use App\Entity\Etat;
use App\Entity\Lieu;
use App\Entity\Sortie;
use App\Form\LieuType;
use App\Form\SortieType;
use App\Outil\MailAnnulation;
use App\Repository\LieuRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Constraints\Json;

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
     * @Route("/seDesister/{id}", name="seDesisterSortie", requirements={"id"="\d+"})
     */
    public function seDesisterSortie(Sortie $sortie, EntityManagerInterface $em)
    {
        $participants = $sortie->getParticipants()->getValues();
        $now = (new \DateTime())->getTimestamp();
        foreach ($participants as $participant) {
            if($participant->getId() == $this->getUser()->getId()){
                if($sortie->getDateHeureDebut()->getTimestamp() > $now ){
                    $this->addFlash('success', "Vous vous êtes bien retiré de la sortie !!");
                    if($sortie->getDateLimiteInscription()->getTimestamp() > $now){
                        $sortie->removeParticipant($participant);
                        $em->persist($sortie);
                        $em->flush();
                    }
                }else{
                    $this->addFlash('success', "Vous ne pouvez plus vous désister de la sortie !!");
                }
            }else{
                $this->addFlash('success', "Vous n'avez pas à accès !!");
            }
        }
        return $this->redirectToRoute('home');
    }

    /**
     * @Route("/annuleSortie/{id}", name="annuleSortie", requirements={"id"="\d+"})
     */
    public function annulerSortie(Sortie $sortie, EntityManagerInterface $em, MailAnnulation $mail)
    {
        if($sortie->getEtat() != 'Activitée en cours'){
            $etat = $em->getRepository(Etat::class)->findOneBy(['libelle' => 'Annulée']);
            $sortie->setEtat($etat);
            $participants = $sortie->getParticipants()->getValues();
            foreach ($participants as $participant) {
                $mail->notify($participant, $sortie);
                $sortie->removeParticipant($participant);
            }
            $em->persist($sortie);
            $em->flush();
            $this->addFlash('success', "Vous avez annulée la sortie et un mail a été envoyé à chaque inscrit !");
        }else{
            $this->addFlash('success', "Vous ne pouvez pas annulée une sorite en cours.");
        }
        return $this->redirectToRoute('home');
    }
    
    /**
     * @Route("/infoLieu/{id}", name="infoLieu", requirements={"id"="\d+"}, methods={"GET"})
     */
    public function afficherLieu(int $id, LieuRepository $lieurepo, SerializerInterface $serializer)
    {
        $infoLieu = $lieurepo->findLieubyId($id);
        $json = $serializer->serialize($infoLieu, 'json' ,['groups' => 'infoLieu']);
        $response = new JsonResponse($json, 200, [], true);
        return $response;
    }
}