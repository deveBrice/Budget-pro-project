<?php

namespace App\Controller;

use App\Entity\Card;

use App\Repository\CardRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Swagger\Annotations as SWG;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

class CardController extends AbstractFOSRestController
{
    private $cardRepository;
    private $emi;

    public function __construct(CardRepository $cardRepository, EntityManagerInterface $emi)   
    {
        $this->cardRepository = $cardRepository;
        $this->emi = $emi;  
    }


    /**    
     * @Rest\Get("/api/card")  
     * @SWG\Response(
     *     response=200,
     *     description="Returns the rewards of an user",
     *  )  
     */
    public function getApiCard()
    {
        $card = $this->cardRepository->findAll();
      return $this->view($card);
    }

    /**  
     * @Rest\Post("/api/card") 
     * @ParamConverter("card", converter="fos_rest.request_body")   
     */
    public function postApiCard(Card $card, ConstraintViolationListInterface $validationErrors, Request $request)
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
        $card = new Card();

        $card->setName($request->get('name'));
        $card->setCreditCardType($request->get('creditCardType'));
        $card->setcreditCardNumber($request->get('creditCardNumber'));
        $card->setCurrencyCode($request->get('currencyCode'));
        $card->setValue($request->get('value'));

       // $em = $this->getDoctrine()->getManager();
        
        $this->emi->persist($card);
        $this->emi->flush();
        return $this->view($card);
    }

  }
}
