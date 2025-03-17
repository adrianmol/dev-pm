<?php

namespace Tests\Feature\Company\Business;

use DevPM\Application\Company\Business\CompanyFacade;
use DevPM\Application\Company\Communication\Controller\Api\CompanyApiController;
use DevPM\Application\Company\Communication\Controller\Request\CompanyUpdateRequest;
use DevPM\Application\Company\Persistence\Shared\Transfer\CompanyTransfer;
use DevPM\Application\User\Business\UserFacade;
use DevPM\Application\User\Persistence\Shared\Transfer\UserTransfer;
use DevPM\Domain\Enums\RoleEnum;
use Illuminate\Http\JsonResponse;
use Mockery;
use Tests\TestCase;

class UpdateCompanyBusinessTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    public function testNonAdminUsersCannotUpdateCompany()
    {
        // Mock user data (non-admin)
        $userFacadeMock = Mockery::mock(UserFacade::class);
        $userFacadeMock->shouldReceive('getLoginUserData')->andReturn(
            (new UserTransfer())->setRole(RoleEnum::STAFF->value)
        );

        // Mock request
        $requestMock = Mockery::mock(CompanyUpdateRequest::class);

        // Instantiate the controller
        $controller = new CompanyApiController($userFacadeMock, Mockery::mock(CompanyFacade::class));

        // Call method
        $response = $controller->updateAction('12345', $requestMock);

        // Assert Forbidden response
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(403, $response->getStatusCode());
    }

    public function testAdminUsersCanUpdateCompany()
    {
        // Mock user data (admin)
        $userFacadeMock = Mockery::mock(UserFacade::class);
        $userFacadeMock->shouldReceive('getLoginUserData')->andReturn(
            (new UserTransfer())->setRole(RoleEnum::ADMIN->value)
        );

        // Mock request and company transfer
        $requestMock = Mockery::mock(CompanyUpdateRequest::class);
        $companyTransfer = (new CompanyTransfer())->setName('Updated Company')->setDescription('Updated Description');
        $requestMock->shouldReceive('getTransferData')->andReturn($companyTransfer);

        // Mock CompanyFacade
        $companyFacadeMock = Mockery::mock(CompanyFacade::class);
        $companyFacadeMock->shouldReceive('update')
            ->with('12345', $companyTransfer)
            ->andReturn($companyTransfer);

        // Instantiate controller with mocked dependencies
        $controller = new CompanyApiController($userFacadeMock, $companyFacadeMock);

        // Call method
        $response = $controller->updateAction('12345', $requestMock);

        // Assert JSON response
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->getStatusCode());
        $responseData = $response->getData(true);
        $this->assertArrayHasKey('company', $responseData);
        $this->assertEquals($companyTransfer->getName(), $responseData['company']['name']);
    }
}
