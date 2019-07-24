<?php


namespace Matu\Ding\Service;

use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Matu\Ding\Models\DingDepartment;
use GuzzleHttp\Exception\RequestException;
use Matu\Ding\Models\DingDepartmentUser;

class DingDepartmentService
{
    protected $token;

    protected $client;

    /**
     * DingGroup constructor.
     * @param AccessTokenService $accessToken
     * @throws \Exception
     */
    public function __construct(AccessTokenService $accessToken)
    {
        $this->token  = $accessToken->getToken();
        $this->client = $accessToken->createClient();
    }

    /**
     * 获取部门列表
     *
     * @return string
     * @throws \Exception
     */
    public function getDepartment()
    {
        DB::beginTransaction();
        try {

            $response = $this->client->get(config('mt-ding.host') . '/department/list', [
                'query' => [
                    'access_token' => $this->token
                ]
            ]);
            $code     = $response->getStatusCode();
            if (!$code) {
                throw new \Exception('网络请求失败');
            }
            $body = json_decode($response->getBody()->getContents());

            // 判断请求结果
            if ($body->errcode !== 0) {
                throw new \Exception($body->errmsg);
            } else {

                $department = $body->department;

                foreach ($department as $key => $value) {
                    DingDepartment::query()->updateOrCreate([
                        'department_id' => $value->id
                    ], [
                        'department_pid'  => $value->departmentPid ?? 0,
                        'department_name' => $value->name,
                        'auto_add_user'   => $value->autoAddUser
                    ]);
                }
            }
            DB::commit();
        } catch (RequestException $e) {
            throw new \Exception('网络请求失败');
        } catch (QueryException $e) {
            DB::rollBack();

            throw new \Exception('数据库更新错误');
        }
    }


    /**
     * 获取部门用户
     *
     * @param int $departmentId
     * @throws \Exception
     */
    public function getDepartmentUser(int $departmentId)
    {
        try {
            $response = $this->client->get(config('mt-ding.host') . '/user/simplelist', [
                'query' => [
                    'access_token'  => $this->token,
                    'department_id' => $departmentId,
                ]
            ]);

            $body = json_decode($response->getBody()->getContents());

            $userLists = $body->userlist;
            foreach ($userLists as $key => $value) {
                DingDepartmentUser::query()->updateOrCreate([
                    'userid' => $value->userid
                ], [
                    'department_id' => $departmentId,
                    'name'          => $value->name,
                    'userid'        => $value->userid
                ]);
            }
        } catch (RequestException $e) {
            throw new \Exception('网络请求失败');
        }
    }
}
