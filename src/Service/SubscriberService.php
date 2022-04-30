<?php

namespace App\Service;

use App\Entity\Subscriber;
use App\Exception\SubscriberAlreadyExistException;
use App\Model\SubscriberRequest;
use App\Repository\SubscriberRepository;
use Doctrine\ORM\EntityManagerInterface;
use OpenApi\Attributes\RequestBody;
use function Symfony\Component\DependencyInjection\Loader\Configurator\env;

class SubscriberService
{
    private SubscriberRepository $subscriberRepository;
    private EntityManagerInterface $em;

    public function __construct(SubscriberRepository $subscriberRepository, EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->subscriberRepository = $subscriberRepository;
    }

    public function subscribe(SubscriberRequest $subscriberRequest): void
    {
        if ($this->subscriberRepository->existByEmail($subscriberRequest->getEmail())) {
            throw new SubscriberAlreadyExistException();
        }

        $subscriber = new Subscriber();

        $subscriber->setEmail($subscriberRequest->getEmail());

        $this->em->persist($subscriber);

        $this->em->flush();
    }
}
