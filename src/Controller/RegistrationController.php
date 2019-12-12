<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Context\Context;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegistrationController extends AbstractFOSRestController
{

    /**
     * @var UserRepository]
     */
    private $userRepository;

    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @param UserRepository $userRepository
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(
        UserRepository $userRepository,
        UserPasswordEncoderInterface $passwordEncoder,
        EntityManagerInterface $entityManager
    ) {
        $this->userRepository = $userRepository;
        $this->passwordEncoder = $passwordEncoder;
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/register", name="register")
     * @param Request $request
     */
    public function index(Request $request)
    {
        $email = $request->get('email');
        $password = $request->get('password');

        $user = $this->userRepository->findOneBy(['email' => $email]);

        if ($user) {
            return $this->view(['message' => 'User already exists'], Response::HTTP_CONFLICT);
        }

        $user = new User();
        $user
            ->setEmail($email)
            ->setPassword($this->passwordEncoder->encodePassword($user, $password));

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $this
            ->view($user, Response::HTTP_CREATED)
            ->setContext((new Context)->setGroups(['public']));
    }
}
