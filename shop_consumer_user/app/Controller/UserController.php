<?php

declare(strict_types=1);

namespace App\Controller;

use App\Tools\Result;
use App\Constants\ErrorCode;
use App\JsonRpc\UserServiceInterface;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\AutoController;

/**
 * Class UserController
 * @package App\Controller
 */
#[AutoController]
class UserController extends AbstractController
{
    /**
     * @var UserServiceInterface
     */
    #[Inject]
    private $userServiceClient;

    public function createUser()
    {
        $name = (string) $this->request->input('name', '');
        $gender = (int) $this->request->input('gender', 0);
        $result = $this->userServiceClient->createUser($name, $gender);
        if ($result['code'] != ErrorCode::SUCCESS) {
            throw new \RuntimeException($result['message']);
        }
        return Result::success($result['data']);
    }

    /**
     * @return array|void
     */
    public function getUserInfo()
    {
        $id = (int) $this->request->input('id');
        $result = $this->userServiceClient->getUserInfo($id);
        if ($result['code'] != \Bailangzhan\Result\ErrorCode::SUCCESS) {
            throw new \RuntimeException($result['message']);
        }
        return \Bailangzhan\Result\Result::success($result['data']);
    }
}