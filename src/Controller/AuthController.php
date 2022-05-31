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
     *     response=201,
     *     description="Sign up user",
     *     @OA\JsonContent(
     *     @OA\Property(property="token", type="string"),
     *     @OA\Property(property="refresh_token", type="string")
     *      ),
     * )
     * @OA\Response(
     *     response=409,
     *     description="User already exists",
     *     @Model(type=ErrorResponse::class)
     * )
     * @OA\Response(
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
