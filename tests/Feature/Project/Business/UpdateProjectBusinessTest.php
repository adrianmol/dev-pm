<?php

namespace Tests\Feature\Project\Business;

use DevPM\Application\Project\Business\ProjectFacade;
use DevPM\Application\Project\Communication\Controller\Api\ProjectApiController;
use DevPM\Application\Project\Communication\Controller\Request\ProjectUpdateRequest;
use DevPM\Application\Project\Persistence\Shared\Transfer\ProjectTransfer;
use DevPM\Application\User\Business\UserFacade;
use DevPM\Application\User\Persistence\Shared\Transfer\UserTransfer;
use DevPM\Domain\Enums\RoleEnum;
use Illuminate\Http\JsonResponse;
use Mockery;
use Tests\TestCase;

class UpdateProjectBusinessTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    public function testNonAdminUsersCannotUpdateProject()
    {
        // Mock the user data (non-admin)
        $userFacadeMock = Mockery::mock(UserFacade::class);
        $userFacadeMock->shouldReceive('getLoginUserData')->andReturn(
            (new UserTransfer())->setRole(RoleEnum::STAFF->value)
        );

        // Mock ProjectFacade (no need to call update for non-admin)
        $projectFacadeMock = Mockery::mock(ProjectFacade::class);

        // Mock ProjectUpdateRequest
        $requestMock = Mockery::mock(ProjectUpdateRequest::class);

        // Instantiate the controller
        $controller = new ProjectApiController($userFacadeMock, $projectFacadeMock);

        // Call the method
        $response = $controller->updateAction('project-id', $requestMock);

        // Assert Forbidden response (non-admin)
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(403, $response->getStatusCode());
    }

    public function testAdminUsersCanUpdateProject()
    {
        // Mock user data (admin)
        $userFacadeMock = Mockery::mock(UserFacade::class);
        $userFacadeMock->shouldReceive('getLoginUserData')->andReturn(
            (new UserTransfer())->setRole(RoleEnum::ADMIN->value)
        );

        // Mock ProjectUpdateRequest and ProjectTransfer
        $requestMock = Mockery::mock(ProjectUpdateRequest::class);
        $projectTransfer = (new ProjectTransfer())->setName('Updated Project')->setCompanyId('1');
        $requestMock->shouldReceive('getTransferData')->andReturn($projectTransfer);

        // Mock ProjectFacade to simulate successful project update
        $projectFacadeMock = Mockery::mock(ProjectFacade::class);
        $projectFacadeMock->shouldReceive('update')->with('projectId', $projectTransfer)->andReturn($projectTransfer);

        // Instantiate controller with mocked dependencies
        $controller = new ProjectApiController($userFacadeMock, $projectFacadeMock);

        // Call the method
        $response = $controller->updateAction('projectId', $requestMock);

        // Assert JSON response (successful update)
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->getStatusCode()); // Default 200 OK status
        $responseData = $response->getData(true);
        $this->assertArrayHasKey('project', $responseData);
        $this->assertEquals($projectTransfer->getName(), $responseData['project']['name']);
        $this->assertEquals($projectTransfer->getCompanyId(), $responseData['project']['companyId']);
    }
}
