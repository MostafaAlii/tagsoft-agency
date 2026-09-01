<?php
declare(strict_types=1);
namespace Authentication\Http\Controllers;
use Authentication\Actions\{ForgotPasswordAction, ResetPasswordAction};
use Authentication\DTOs\{ForgotPasswordDTO, ResetPasswordDTO};
use Authentication\Http\Requests\{ForgotPasswordRequest, ResetPasswordRequest};
use Core\Http\Controllers\BaseController;
final class PasswordController extends BaseController {
    public function forgot(string $guard, ForgotPasswordRequest $request, ForgotPasswordAction $action) {
        $dto = ForgotPasswordDTO::fromArray($request->validated());
        $action->handle($dto, $guard);
        return $this->successResponse(null, trans('authentication::general\account_status.reset_link_sent'));
    }

    public function reset(string $guard, ResetPasswordRequest $request, ResetPasswordAction $action) {
        $dto = ResetPasswordDTO::fromArray($request->validated());
        $action->handle($dto, $guard);
        return $this->successResponse(null, trans('authentication::general\account_status.password_reset_success'));
    }
}