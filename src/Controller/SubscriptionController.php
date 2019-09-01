<?php

namespace App\Controller;

use App\Entity\Subscription;
use App\Repository\SubscriptionRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;


class SubscriptionController extends AbstractFOSRestController
{

    private $subscriptionRepository;
    private $emi;

    public function __construct(SubscriptionRepository $subscriptionRepository, EntityManagerInterface $emi)   
    {
        $this->subscriptionRepository = $subscriptionRepository;
        $this->emi = $emi;  
    }


    /**    
     * @Rest\Get("/api/subscription/{name}")    
     */
    public function getApiSubscription(string $name)
    {
        $subscription = $this->SubscriptionRepository-findOneBy(['name' => $name]);
      return $this->view($subscription);
    }

    /**    
     * @Rest\Get("/api/subscription")    
     */
    public function getApiSubscriptions()
    {
        $subscription = $this->SubscriptionRepository->findAll();
      return $this->view($subscription);
    }

    /**    
     * @Rest\Post("/api/subscribe") 
     * @ParamConverter("subscription", converter="fos_rest.request_body")   
     */
    public function postApiSubscription(Subscription $subscription, ConstraintViolationListInterface $validationErrors, Request $request)
    {
      $errors = array();
      if ($validationErrors->count() > 0) 
      {
        /** 
         * @var ConstraintViolation $constraintViolation 
         */
        foreach ($validationErrors as $constraintViolation)
        {
          // Returns the violation message. (Ex. This value should not be blank.)
          $message = $constraintViolation->getMessage();
          // Returns the property path from the root element to the violation. (Ex. lastname)
          $propertyPath = $constraintViolation->getPropertyPath();
          $errors[] = ['message' => $message, 'propertyPath' => $propertyPath];
        }   
      }
      if (!empty($errors)) 
      {
        // Throw a 400 Bad Request with all errors messages (Not readable, you can do better)
        throw new BadRequestHttpException(\json_encode($errors));
    } else {
        $subscription = new Subscription();

        $subscription->setEmail($request->get('email'));
        $subscription->setApiKey($request->get('apiKey'));
        $subscription->setCreatedAt(new \DateTime ('now'));
        $subscription->setPassword($request->get('password'));

       // $em = $this->getDoctrine()->getManager();
        
        $this->emi->persist($subscription);
        $this->emi->flush();
        return $this->view($subscription);
    }

  }

}

?>