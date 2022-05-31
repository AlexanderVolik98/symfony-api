<?php

namespace App\Controller;

use App\Model\ErrorResponse;
use App\Model\SubscriberRequest;
use App\Service\SubscriberService;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SubcribeController extends AbstractController
{
    private SubscriberService $subscriberService;

    public function __construct(SubscriberService $subscriberService)
    {
        $this->subscriberService = $subscriberService;
    }

    /**
     * @Route("/api/v1/newsletter/subscribe", priority=20, name="subscribe", methods={"POST"})
     * @OA\Response(
     *     ref="/api/v1/newsletter/subscribe",
     *     response=201,
     *     description="подписка на новостную рассылку",
     *     @Model(type=SubscriberRequest::class)
     * )
     * @OA\Response(
     *     ref="/api/v1/book/subscribe",
     *     response=400,
     *     description="validation failed",
     *     @Model(type=ErrorResponse::class)
     * )
     * @OA\RequestBody(@Model(type=SubscriberRequest::class))
     */
    public function action(SubscriberRequest $subscriberRequest): Response
    {
        $this->subscriberService->subscribe($subscriberRequest);

        return $this->json(null);
    }
}
