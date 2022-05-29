<?php

namespace App\ArgumentResolver;

use App\Exception\RequestBodyConvertException;
use App\Exception\ValidationException;
use App\Model\ModelValidatableInterface;
use Generator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Throwable;

class RequestValueResolver implements ArgumentValueResolverInterface
{
    private SerializerInterface $serializer;
    private ValidatorInterface $validator;

    public function __construct(SerializerInterface $serializer, ValidatorInterface $validator)
    {
        $this->validator = $validator;
        $this->serializer = $serializer;
    }

    public function supports(Request $request, ArgumentMetadata $argument): bool
    {
        if (!class_exists($argument->getType())) {
            return false;
        }

        $interfaces = class_implements($argument->getType());

        return count($interfaces) > 0 && in_array(ModelValidatableInterface::class, $interfaces);
    }

    public function resolve(Request $request, ArgumentMetadata $argument): ?Generator
    {
        try {
            $model = $this->serializer->deserialize(
                $request->getContent(),
                $argument->getType(),
                JsonEncoder::FORMAT,
            );
        } catch (Throwable $throwable) {
            throw new RequestBodyConvertException($throwable);
        }

        $errors = $this->validator->validate($model);

        if (count($errors) > 0) {
            throw new ValidationException($errors);
        }

        yield $model;
    }
}
