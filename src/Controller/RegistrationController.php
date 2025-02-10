<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

final class RegistrationController extends AbstractController
{
    private EntityManagerInterface $em;
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(EntityManagerInterface $em, UserPasswordHasherInterface $passwordHasher){
        $this->em = $em;
        $this->passwordHasher = $passwordHasher;
    }

    #[Route('/register', name: 'register')]
    public function Register(Request $request, ): Response
    {
        $form = $this->createFormBuilder()
            ->add('email')
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'required' => true,
                'first_options' => ['label' => 'Password'],
                'second_options' => ['label' => 'Confirm Password']
            ])
            ->add('Register', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-success float-end'
                ]
            ])
            ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $data = $form->getData();
   
            $user = new User();
            $user->setEmail($data['email']);
            $hashedPassword = $this->passwordHasher->hashPassword($user, $data['password']);
            $user->setPassword($hashedPassword);

            $this->em->persist($user);
            $this->em->flush();
            
            return $this->redirect($this->generateUrl('login'));
        }

        return $this->render('security/register.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
