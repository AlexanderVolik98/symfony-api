<?php

namespace App\Service;

use App\Entity\User;
use App\Exception\UserAlreadyExistException;
use App\Model\IdResponse;
use App\Model\SignUpRequest;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Security\Http\Authentication\AuthenticationSuccessHandler;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class SignUpService
{
    private UserRepository $userRepository;
    private UserPasswordHasherInterface $hasher;
    private EntityManagerInterface $em;
    private AuthenticationSuccessHandler $successHandler;

    public function __construct(UserPasswordHasherInterface $hasher, UserRepository $userRepository, EntityManagerInterface $em, AuthenticationSuccessHandler $successHandler)
    {
        $this->userRepository = $userRepository;
        $this->hasher = $hasher;
        $this->em = $em;
        $this->successHandler = $successHandler;
    }

    public function signUp(SignUpRequest $signUpRequest): Response
    {
        if ($this->userRepository->existByEmail($signUpRequest->getEmail())) {
            throw new UserAlreadyExistException();
        }

        $user = (new User())
            ->setFirstName($signUpRequest->getFirstName())
            ->setLastName($signUpRequest->getLastName())
            ->setEmail($signUpRequest->getEmail());

        $user->setPassword($this->hasher->hashPassword($user, $signUpRequest->getPassword()));

        $this->em->persist($user);
        $this->em->flush();

        return $this->successHandler->handleAuthenticationSuccess($user);
    }
}
