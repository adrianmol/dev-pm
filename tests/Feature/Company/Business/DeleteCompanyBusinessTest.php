<?php

namespace Tests\Feature\Company\Business;

use DevPM\Application\Company\Business\CompanyFacade;
use DevPM\Application\Company\Communication\Controller\Api\CompanyApiController;
use DevPM\Application\User\Business\UserFacade;
use DevPM\Application\User\Persistence\Shared\Transfer\UserTransfer;
use DevPM\Domain\Enums\RoleEnum;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Mockery;
use Tests\TestCase;

class DeleteCompanyBusinessTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    public function testNonAdminUsersCannotDeleteCompany()
    {
        // Mock user data (non-admin)
        $userFacadeMock = Mockery::mock(UserFacade::class);
        $userFacadeMock->shouldReceive('getLoginUserData')->andReturn(
            (new UserTransfer())->setRole(RoleEnum::STAFF->value)
        );

        // Mock CompanyFacade (no need to mock delete, as we shouldn't reach it for non-admin)
        $companyFacadeMock = Mockery::mock(CompanyFacade::class);

        // Instantiate the controller
        $controller = new CompanyApiController($userFacadeMock, $companyFacadeMock);

        // Call the method
        $response = $controller->deleteAction('12345');

        // Assert Forbidden response (non-admin)
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(403, $response->getStatusCode());
    }

    public function testAdminUsersCanDeleteCompany()
    {
        // Mock user data (admin)
        $userFacadeMock = Mockery::mock(UserFacade::class);
        $userFacadeMock->shouldReceive('getLoginUserData')->andReturn(
            (new UserTransfer())->setRole(RoleEnum::ADMIN->value)
        );

        // Mock CompanyFacade to simulate successful company deletion
        $companyFacadeMock = Mockery::mock(CompanyFacade::class);
        $companyFacadeMock->shouldReceive('deleteById')
            ->with('12345')
            ->andReturn(true);  // Simulate a successful deletion

        // Instantiate the controller with mocked dependencies
        $controller = new CompanyApiController($userFacadeMock, $companyFacadeMock);

        // Call the method
        $response = $controller->deleteAction('12345');

        // Assert No Content response (successful deletion)
        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(204, $response->getStatusCode());
    }
}
