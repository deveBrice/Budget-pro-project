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
use FOS\RestBundle\View\View;
use Swagger\Annotations as SWG;

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
     * @Rest\Post("/api/subscription") 
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

        $subscription->setName($request->get('name'));
        $subscription->setSlogan($request->get('slogan'));
        $subscription->setUrl($request->get('url'));
        
        $this->emi->persist($subscription);
        $this->emi->flush();
        return $this->view($subscription);
    }

  }

   /**
     * @Rest\Put("/api/subscription/{name}")
     *  @SWG\Response(
     *       response=200,
     *       description="edit a subscription",   
     * )
     * 
     * @SWG\Parameter(
     *      name="",
     *      in="query",
     *      type="string" 
     * )   
     */
    public function updateApiUser(Subscription $subscription, string $name, Request $request): View
    {
      $subscription = $this->subscriptionRepository->findOneBy(['name' => $name]);
      if($subscription){
        $subscription->setName($request->get('name'));
        $subscription->setSlogan($request->get('slogan'));
        $subscription->setUrl($request->get('url'));
        $this->emi->persist($subscription);
        $this->emi->flush(); 
      }
      
        return View::create($subscription, Response::HTTP_OK);
    }

    /**    
     * @Rest\Delete("/api/subscription/{name}")    
     */
    public function deleteApiUser(Subscription $subscription, string $name): View
    {
     $subscription = $this->subscriptionRepository->findOneBy(['name' => $name]);
     
      if($subscription) {
        $this->emi->remove($subscription);
        $this->emi->flush();
    }  
      return $this->view($subscription);
    }

}

?>