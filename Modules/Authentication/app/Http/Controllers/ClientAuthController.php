<?php
declare(strict_types=1);
namespace Authentication\Http\Controllers;
use Core\Http\Controllers\BaseController;
use Authentication\Actions\{LoginAction, LogoutAction, MeAction, RefreshTokenAction, ChangePasswordAction};
use Authentication\DTOs\{LoginDTO, ChangePasswordDTO};
use Authentication\Http\Requests\{LoginRequest, ChangePasswordRequest};
use Authentication\Strategies\ClientGuardStrategy;

final class ClientAuthController extends BaseController {
    public function __construct(
        private readonly ClientGuardStrategy $strategy,
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
        $resource = $action->handle($this->strategy);
        return $this->successResponse($resource, 'User retrieved successfully');
    }

    public function changePassword(ChangePasswordRequest $request, ChangePasswordAction $action)
    {
        $dto = ChangePasswordDTO::fromArray($request->validated());
        $action->handle($dto, $this->strategy);
        return $this->successResponse(null, trans('authentication::general\account_status.password_changed_success'));
    }
}