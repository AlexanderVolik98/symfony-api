<?php

namespace App\Tests\ArgumentResolver;

use App\ArgumentResolver\SubscribeRequestValueResolver;
use App\Exception\RequestBodyConvertException;
use App\Exception\ValidationException;
use App\Model\SubscriberRequest;
use App\Tests\AbstractTestCase;
use Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class SubscribeRequestValueResolverTest extends AbstractTestCase
{
    private SerializerInterface $serializer;
    private ValidatorInterface $validator;

    protected function setUp(): void
    {
        parent::setUp();

        $this->serializer = $this->createMock(SerializerInterface::class);
        $this->validator = $this->createMock(ValidatorInterface::class);
    }

    public function testSupports(): void
    {
        $meta = new ArgumentMetadata('some', SubscriberRequest::class, false, false, null, false);

        $this->assertTrue($this->createResolver()->supports(new Request(), $meta));
    }

    public function testNotSupports(): void
    {
        $meta = new ArgumentMetadata('some', SubscriberRequest::class, false, false, null, false);

        $this->assertTrue($this->createResolver()->supports(new Request(), $meta));
    }

    public function testResolveThrowsWhenDeserialize(): void
    {
        $this->expectException(RequestBodyConvertException::class);

        $request = new Request([], [], [], [], [], [], 'testing content');

        $meta = new ArgumentMetadata('some', SubscriberRequest::class, false, false, null, false);

        $this->serializer->expects($this->once())
            ->method('deserialize')
            ->with('testing content', SubscriberRequest::class, JsonEncoder::FORMAT)
            ->willThrowException(new Exception());

        $this->createResolver()->resolve($request, $meta)->next();
    }

    public function testResolveThrowsWhenValidationFails(): void
    {
        $this->expectException(ValidationException::class);

        $body = ['test' => true];
        $encodedBody = json_encode($body);

        $request = new Request([], [], [], [], [], [], $encodedBody);

        $meta = new ArgumentMetadata('some', SubscriberRequest::class, false, false, null, false);

        $this->serializer->expects($this->once())
            ->method('deserialize')
            ->with($encodedBody, SubscriberRequest::class, JsonEncoder::FORMAT)
            ->willReturn($body);

        $this->validator->expects($this->once())
            ->method('validate')
            ->with($body)
            ->willReturn(new ConstraintViolationList([
                new ConstraintViolation('error', null, [], null, 'some', null),
            ]));

        $this->createResolver()->resolve($request, $meta)->next();
    }

    public function testResolve(): void
    {
        $body = ['test' => true];
        $encodedBody = json_encode($body);

        $request = new Request([], [], [], [], [], [], $encodedBody);

        $meta = new ArgumentMetadata('some', SubscriberRequest::class, false, false, null, false);

        $this->serializer->expects($this->once())
            ->method('deserialize')
            ->with($encodedBody, SubscriberRequest::class, JsonEncoder::FORMAT)
            ->willReturn($body);

        $this->validator->expects($this->once())
            ->method('validate')
            ->with($body)
            ->willReturn([]);

        $actual = $this->createResolver()->resolve($request, $meta);

        $this->assertEquals($body, $actual->current());
    }

    private function createResolver(): SubscribeRequestValueResolver
    {
        return new SubscribeRequestValueResolver($this->serializer, $this->validator);
    }
}
