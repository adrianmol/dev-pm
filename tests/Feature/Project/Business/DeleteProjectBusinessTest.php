<?php

namespace Tests\Feature\Project\Business;

use DevPM\Application\Project\Business\ProjectFacade;
use DevPM\Application\Project\Communication\Controller\Api\ProjectApiController;
use DevPM\Application\User\Business\UserFacade;
use DevPM\Application\User\Persistence\Shared\Transfer\UserTransfer;
use DevPM\Domain\Enums\RoleEnum;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Mockery;
use Tests\TestCase;

class DeleteProjectBusinessTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    public function testNonAdminUsersCannotDeleteProject()
    {
        // Mock the user data (non-admin)
        $userFacadeMock = Mockery::mock(UserFacade::class);
        $userFacadeMock->shouldReceive('getLoginUserData')->andReturn(
            (new UserTransfer())->setRole(RoleEnum::STAFF->value)
        );

        // Mock ProjectFacade (no need to call delete for non-admin)
        $projectFacadeMock = Mockery::mock(ProjectFacade::class);

        // Instantiate the controller
        $controller = new ProjectApiController($userFacadeMock, $projectFacadeMock);

        // Call the method
        $response = $controller->deleteAction('projectId');

        // Assert Forbidden response (non-admin)
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(403, $response->getStatusCode());
    }

    public function testAdminUsersCanDeleteProject()
    {
        // Mock the user data (admin)
        $userFacadeMock = Mockery::mock(UserFacade::class);
        $userFacadeMock->shouldReceive('getLoginUserData')->andReturn(
            (new UserTransfer())->setRole(RoleEnum::ADMIN->value)
        );

        // Mock ProjectFacade to simulate successful deletion
        $projectFacadeMock = Mockery::mock(ProjectFacade::class);
        $projectFacadeMock->shouldReceive('deleteById')->with('projectId')->andReturn(true);

        // Instantiate the controller with mocked dependencies
        $controller = new ProjectApiController($userFacadeMock, $projectFacadeMock);

        // Call the method
        $response = $controller->deleteAction('projectId');

        // Assert No Content response (successful deletion)
        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(204, $response->getStatusCode()); // 204 No Content
    }
}
