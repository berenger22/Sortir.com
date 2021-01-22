<?php 
namespace App\Outil;

use App\Entity\Participant;
use App\Entity\Sortie;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;

class MailAnnulation {

    private $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function notify(Participant $participant, Sortie $sortie){
        $message = (new TemplatedEmail())
        ->From($participant->getMail())
        ->to($sortie->getOrganise()->getMail())
        ->subject("Annulation d'une sortie")
        ->htmlTemplate('email/mailAnnulation.html.twig')
        ->context([
            'sortie' => $sortie
        ]);
        $this->mailer->send($message);
    }
}