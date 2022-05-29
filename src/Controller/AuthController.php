<?php

namespace App\Controller;

use App\Model\ErrorResponse;
use App\Model\IdResponse;
use App\Model\SignUpRequest;
use App\Service\SignUpService;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AuthController extends AbstractController
{
    private SignUpService $signUpService;

    public function __construct(SignUpService $signUpService)
    {
        $this->signUpService = $signUpService;
    }

    /**
     * @Route("/api/v1/auth/signUp", name="signUp", methods={"POST"})
     * @OA\Response(
     *     ref="/api/v1/auth/signUp",
     *     response=200,
     *     description="Sign up user",
     *     @Model(type=IdResponse::class)
     * )
     * @OA\Response(
     *     ref="/api/v1/auth/signUp",
     *     response=409,
     *     description="User already exists",
     *     @Model(type=ErrorResponse::class)
     * )
     * @OA\Response(
     *     ref="/api/v1/auth/signUp",
     *     response=400,
     *     description="Validation error",
     *     @Model(type=ErrorResponse::class)
     * )
     * @OA\RequestBody(@Model(type=SignUpRequest::class))
     */
    public function signUp(SignUpRequest $signUpRequest): Response
    {
        return $this->signUpService->signUp($signUpRequest);
    }
}
