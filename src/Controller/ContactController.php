<?php

namespace App\Controller;

use Swift_Mailer;
use Twig\Environment;
use App\Entity\Contact;
use App\Form\ContactType;
use App\Notification\ContactNotification;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactController extends AbstractController
{

     /**
     *
     *
     * @var \Swift_Mailer
     */
    private $mailer;

    /**
     *
     * @var Environment
     */
    private $renderer;

    public function __construct(\Swift_Mailer $mailer, Environment $renderer)
    {
        $this->mailer = $mailer;
        $this->renderer = $renderer;
    }
    /**
     * @Route("/contact", name="contact")
     */
    public function contact(Request $request, Swift_Mailer $mailer)
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {

            $message = (new \Swift_Message('Contact'))
            ->setFrom($contact->getEmail())
            ->setTo('pierredechezlwr@gmail.com')
            ->setReplyTo($contact->getEmail())
            ->setBody($this->renderer->render('email/sendmessage.html.twig', [
                'contact' => $contact
            ]), 'text/html');
        $this->mailer->send($message);

            //$notification->notify($contact);
            $this->addFlash('success', 'Votre message a bien été envoyé');
            return $this->redirectToRoute('contact');
        }

        return $this->render('contact/contact.html.twig', [
            //'controller_name' => 'ContactController',
            'form' => $form->createView()
        ]);
    }

   /*  public function notify(Contact $contact, ){
     
    } */
}
