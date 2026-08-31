<?php
declare(strict_types=1);
namespace Authentication\Http\Controllers;
use Core\Http\Controllers\BaseController;
use Authentication\Actions\{LoginAction, LogoutAction, MeAction, RefreshTokenAction};
use Authentication\Dtos\LoginDTO;
use Authentication\Http\Requests\LoginRequest;
use Authentication\Strategies\EmployeeGuardStrategy;
final class EmployeeAuthController extends BaseController {
    public function __construct(
        private readonly EmployeeGuardStrategy $strategy,
    ) {}

    public function login(LoginRequest $request, LoginAction $action) {
        $dto = LoginDTO::fromArray($request->validated());
        $result = $action->handle($dto, $this->strategy);
        return $this->successResponse($result, 'Logged in successfully');
    }

    public function logout(LogoutAction $action) {
        $action->handle($this->strategy);
        return $this->successResponse(null, 'Logged out successfully');
    }

    public function refresh(RefreshTokenAction $action) {
        $result = $action->handle($this->strategy);
        return $this->successResponse($result, 'Token refreshed successfully');
    }

    public function me(MeAction $action) {
        $user = $action->handle($this->strategy);
        return $this->successResponse($user, 'User retrieved successfully');
    }
}