<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Swagger\Annotations as SWG;
use Nelmio\ApiDocBundle\Annotation\Model;
use FOS\RestBundle\View\View;

class UserController extends AbstractFOSRestController
{

    private $userRepository;
    private $emi;

    public function __construct(UserRepository $userRepository, EntityManagerInterface $emi)   
    {
        $this->userRepository = $userRepository;
        $this->emi = $emi;  
    }
    
    /**    
     * @Rest\Get("/api/users/{email}")    
     */
    public function getApiUser(string $email)
    {
      $user = $this->userRepository->findOneBy(['email' => $email]);
      return $this->view($user);
    }

       /**    
     * @Rest\Get("/api/users")    
     */
    public function getApiUsers()
    {
      $users = $this->userRepository->findAll();
      return $this->view($users);
    }

  /**    
     * @Rest\Post("/api/users") 
     * @ParamConverter("user", converter="fos_rest.request_body")   
     */
    public function postApiUser(User $user, ConstraintViolationListInterface $validationErrors, Request $request)
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
        $user = new User();

        $user->setEmail($request->get('email'));
        $user->setApiKey($request->get('apiKey'));
        $user->setCreatedAt(new \DateTime ('now'));
        $user->setPassword($request->get('password'));

       // $em = $this->getDoctrine()->getManager();
        
        $this->emi->persist($user);
        $this->emi->flush();
        return $this->view($user);
    }

  }

    /**
     * @Rest\Put("/api/users/{email}")
     *  @SWG\Response(
     *       response=200,
     *       @Model(type=User::class),
     *       description="edit a user",   
     * )
     * 
     * @SWG\Parameter(
     *      name="",
     *      in="query",
     *      type="string" 
     * )   
     */
    public function updateApiUser(User $user, string $email, Request $request): View
    {
      $user = $this->userRepository->findOneBy(['email' => $email]);
      if($user){
        $user->setEmail($request->get('email'));
        $user->setApiKey($request->get('apiKey'));
        $user->setCreatedAt(new \DateTime('now'));
        $user->setPassword($request->get('password')); 
        $this->emi->persist($user);
        $this->emi->flush(); 
      }
      
        return View::create($user, Response::HTTP_OK);
    }

    /**    
     * @Rest\Delete("/api/users/{email}")    
     */
    public function deleteApiUser(User $user, string $email): View
    {
     // $user = new User();
      $user = $this->userRepository->findOneBy(['email' => $email]);
     
      if($user) {
        //throw $this->createNotFoundException('No email found for email '.$email);
        $this->emi->remove($user);
       // $this->emi->persist($user);
        $this->emi->flush();
    } 
      
     
      return $this->view($user);
    }
}
