<?php

namespace App\Controller;

use DateTime;
use Swift_Mailer;
use Stripe\Stripe;
use App\Form\PayType;
use App\Entity\Delivery;
use App\Entity\Location;
use App\Form\AdressType;
use App\Form\PaymentType;
use Stripe\PaymentIntent;
use App\Service\MediaService;
use App\Service\Cart\CartService;
use App\Repository\WatchModelRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\WatchEntityRepository;
use App\Repository\DeliveryCompanyRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PaymentController extends AbstractController
{
    
    private $cartService;
    private $watchModelRepository;
    private $watchEntityRepository;
    private $deliveryCompanyRepository;

    public function __construct( CartService $cartService, WatchModelRepository $watchModelRepository,  WatchEntityRepository $watchEntityRepository, DeliveryCompanyRepository $deliveryCompanyRepository)
    {
        $this->deliveryCompanyRepository = $deliveryCompanyRepository;
        $this->watchModelRepository = $watchModelRepository;
        $this->watchEntityRepository = $watchEntityRepository;
        $this->cartService = $cartService;
    }
    
    /**
     * @Route("/payment/", name="payment")
     */
    public function payment( Request $request ,EntityManagerInterface $em, SessionInterface $session,  Swift_Mailer $mailer)
    {
        $amount = ($this->cartService->getTotal())*100;
        $delivery = new Delivery();
        $user = $this->getUser();
        // Set your secret key. Remember to switch to your live secret key in production!
        // See your keys here: https://dashboard.stripe.com/account/apikeys
        \Stripe\Stripe::setApiKey('sk_test_sQ77EBACzu4uZTxdERdVb05B008Cd1Q1X0');

        $intent = \Stripe\PaymentIntent::create([
        'amount' => $amount,
        'currency' => 'eur',
        // Verify your integration in this guide by including this parameter
        'metadata' => ['integration_check' => 'accept_a_payment'],
        ]);
        
        $deliveryId = $request->query->get('delivery');
        $deliveryId = intval($deliveryId);
        $form = $this->createForm(PaymentType::class);
        $form->handleRequest($request);
        
        if( $form->isSubmitted() && $form->isValid() ){

            //Crée une livraison
            //On recupere l'adresse du current User
            $delivery->setAddress($user->getAddress());
            $delivery->setTown($user->getTown());
            $delivery->setZipcode($user->getZipcode());
            $delivery->setCountry($user->getCountry());
            //On recupere le mode de livraison en session
            
            $deliveryCompany = $this->deliveryCompanyRepository->find($deliveryId);
            $delivery->setDeliveryCompany($deliveryCompany);

            $em->persist( $delivery );
            

            //On boucle sur les entité de la montre
            foreach($session->get('panier') as $id => $watch){
                $watchModel = $this->watchModelRepository->find(intval($id));

                //Puis on boucle sur chaque date en session
                foreach($watch as $date){

                    //Puis on crée une location
                    $location = new Location();
                    $startsAt = new DateTime($date['startsAt']);
                    $endsAt = new DateTime($date['endsAt']);
                    $location->setStartsAt($startsAt);
                    $location->setEndsAt($endsAt);

                     //On recupere le total pour chaque montre
                     $days = $startsAt->diff($endsAt);
                    $location->setAmount($days->days * $watchModel->getPrice());

                    //On set le is paid sur false
                    $location->setIsPaid(false);

                    //On assigne un numéro de serie
                    $watchEntity = $this->watchEntityRepository->findByAvailable($id);
                    if($watchEntity == 'not ok'){
                        //dd($id);
                        continue;
                    }
                    $location->setWatchEntity($watchEntity);
                    $watchEntity->setAvailable(false);

                     //On recupere l'utilisateur
                    $location->setUser($user);

                    //On lie la location et la livraison
                    $location->setDelivery($delivery);

                    //On genere un numero de location
                    $location->setLocationNumber(strtoupper($watchEntity->getSerialNumber().uniqid()));

                    //On crée un numéro de facture
                    $location->setBillNumber(strtoupper(substr($user->getLastname(), 0, 3).uniqid()));

                    $em->persist( $location );
                    
                }
            }
            $em->flush();

            //Send email
            $message = (new \Swift_Message('Confirmation de commande'))
                // On attribue l'expéditeur
                ->setFrom('pierredechezlwr@gmail.com')
                // On attribue le destinataire
                ->setTo($user->getEmail())
                // On crée le texte avec la vue
                ->setBody(
                    $this->renderView(
                        'email/commandeConfirm.html.twig',
                        array(
                            'items' =>$this->cartService->getFullCart(),
                            'total' =>$this->cartService->getTotal(),
                        )
                       
                    ),
                    'text/html'
                )
                ;
                $mailer->send($message);

                /* $session->clear('panier'); */
            return $this->redirectToRoute('confirm_command', array('delivery'=>$deliveryId));
        }
      
        return $this->render('payment/index.html.twig', [
            'intent' => $intent,
            'items' => $this->cartService->getFullCart(),
            'form' => $form->createView(),
            'id' => $deliveryId
        
        ]);
        
    }
    }

