<?php

namespace Tests\Feature\Company\Business;

use DevPM\Application\Company\Business\CompanyFacade;
use DevPM\Application\Company\Communication\Controller\Api\CompanyApiController;
use DevPM\Application\Company\Communication\Controller\Request\CompanyRegisterRequest;
use DevPM\Application\Company\Persistence\Shared\Transfer\CompanyTransfer;
use DevPM\Application\User\Business\UserFacade;
use DevPM\Application\User\Persistence\Shared\Transfer\UserTransfer;
use DevPM\Domain\Enums\RoleEnum;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\ResponseFactory;
use Mockery;
use Tests\TestCase;

class CreateCompanyBusinessTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();


        app()->instance(ResponseFactory::class, app(ResponseFactory::class));
    }

    public function testNonAdminUsersCannotCreateCompany()
    {
        // Mock the user data (non-admin)
        $responseFactoryMock = Mockery::mock(ResponseFactory::class);
        $userFacadeMock = Mockery::mock(UserFacade::class);
        $userFacadeMock->shouldReceive('getLoginUserData')->andReturn((new UserTransfer())->setRole(RoleEnum::STAFF->value));

        // Mock the request
        $requestMock = Mockery::mock(CompanyRegisterRequest::class);

        // Instantiate the controller
        $controller = new CompanyApiController($userFacadeMock, Mockery::mock(CompanyFacade::class));

        // Call method
        $response = $controller->createAction($requestMock);

        // Assert Forbidden response
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(403, $response->getStatusCode());
        app()->instance(ResponseFactory::class, $responseFactoryMock);
    }

    public function testAdminUsersCanCreateCompany()
    {
        // Mock the user data (admin)
        $responseFactoryMock = Mockery::mock(ResponseFactory::class);
        app()->instance(ResponseFactory::class, $responseFactoryMock);

        $userFacadeMock = Mockery::mock(UserFacade::class);
        $userFacadeMock->shouldReceive('getLoginUserData')->andReturn((new UserTransfer())->setRole(RoleEnum::ADMIN->value));

        // Mock the request and company transfer
        $requestMock = Mockery::mock(CompanyRegisterRequest::class);
        $companyTransfer = (new CompanyTransfer())->setName('Test Company')->setDescription('Test Description');
        $requestMock->shouldReceive('getTransferData')->andReturn($companyTransfer);

        // Mock the CompanyFacade
        $companyFacadeMock = Mockery::mock(CompanyFacade::class);
        $companyFacadeMock->shouldReceive('create')->with($companyTransfer)->andReturn($companyTransfer);

        // Instantiate controller with mocked dependencies
        $controller = new CompanyApiController($userFacadeMock, $companyFacadeMock);

        // Call method
        $response = $controller->createAction($requestMock);

        // Assert JSON response
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(201, $response->getStatusCode());
        $responseData = $response->getData(true);
        $this->assertArrayHasKey('company', $responseData);
        $this->assertEquals($companyTransfer->getName(), $responseData['company']['name']);

        app()->instance(ResponseFactory::class, $responseFactoryMock);
    }
}
