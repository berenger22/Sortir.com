<?php

namespace App\Controller;

use App\Entity\Participant;
use App\Form\ParticipantType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ParticipantController extends AbstractController
{
    /**
     * @Route("/monProfil/{id}", name="modifProfil", requirements={"id"="\d+"})
     */
    public function editParticipant(Request $request, Participant $participant, EntityManagerInterface $em, UserPasswordEncoderInterface $encoder): Response
    {
        $form = $this->createForm(ParticipantType::class, $participant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $passwordCrypte = $encoder->encodePassword($participant, $participant->getPassword());
            $participant->setPassword($passwordCrypte);
            $em->persist($participant);
            $em->flush();
            $this->addFlash('success', "La modification a bien été effectué");
            return $this->redirectToRoute('home');
        }

        return $this->render('participant/editProfil.html.twig', [
                    'form' => $form->createView()]);
    }

    /**
     * @Route("/profil/{id}", name="afficherProfil", requirements={"id"="\d+"})
     */
    public function afficherProfil(Participant $participant)
    {
        return $this->render("participant/profil.html.twig",[
            'participant' => $participant
        ]);
    }
}
