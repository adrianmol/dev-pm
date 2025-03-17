<?php

namespace Tests\Feature\Project\Business;

use DevPM\Application\Project\Business\ProjectFacade;
use DevPM\Application\Project\Communication\Controller\Api\ProjectApiController;
use DevPM\Application\Project\Communication\Controller\Request\ProjectCreateRequest;
use DevPM\Application\Project\Persistence\Shared\Transfer\ProjectTransfer;
use DevPM\Application\User\Business\UserFacade;
use DevPM\Application\User\Persistence\Shared\Transfer\UserTransfer;
use DevPM\Domain\Enums\RoleEnum;
use Illuminate\Http\JsonResponse;
use Mockery;
use Tests\TestCase;

class CreateProjectBusinessTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    public function testNonAdminUsersCannotCreateProject()
    {
        // Mock the user data (non-admin)
        $userFacadeMock = Mockery::mock(UserFacade::class);
        $userFacadeMock->shouldReceive('getLoginUserData')->andReturn(
            (new UserTransfer())->setRole(RoleEnum::STAFF->value)
        );

        // Mock ProjectFacade (we don't need to call create for non-admin)
        $projectFacadeMock = Mockery::mock(ProjectFacade::class);

        // Mock ProjectCreateRequest
        $requestMock = Mockery::mock(ProjectCreateRequest::class);

        // Instantiate the controller
        $controller = new ProjectApiController($userFacadeMock, $projectFacadeMock);

        // Call the method
        $response = $controller->createAction($requestMock);

        // Assert Forbidden response (non-admin)
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(403, $response->getStatusCode());
    }

    public function testAdminUsersCanCreateProject()
    {
        // Mock user data (admin)
        $userFacadeMock = Mockery::mock(UserFacade::class);
        $userFacadeMock->shouldReceive('getLoginUserData')->andReturn(
            (new UserTransfer())->setRole(RoleEnum::ADMIN->value)
        );

        // Mock ProjectCreateRequest and ProjectTransfer
        $requestMock = Mockery::mock(ProjectCreateRequest::class);
        $projectTransfer = (new ProjectTransfer())->setName('Test Project')->setCompanyId(1);
        $requestMock->shouldReceive('getTransferData')->andReturn($projectTransfer);

        // Mock ProjectFacade to simulate successful project creation
        $projectFacadeMock = Mockery::mock(ProjectFacade::class);
        $projectFacadeMock->shouldReceive('create')->with($projectTransfer)->andReturn($projectTransfer);

        // Instantiate controller with mocked dependencies
        $controller = new ProjectApiController($userFacadeMock, $projectFacadeMock);

        // Call the method
        $response = $controller->createAction($requestMock);

        // Assert JSON response (successful creation)
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(201, $response->getStatusCode());
        $responseData = $response->getData(true);
        $this->assertArrayHasKey('project', $responseData);
        $this->assertEquals($projectTransfer->getName(), $responseData['project']['name']);
        $this->assertEquals($projectTransfer->getCompanyId(), $responseData['project']['companyId']);
    }
}
