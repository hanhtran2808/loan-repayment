<?php

use App\Constants\ErrorCodeConstant;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class LoanTest extends TestCase
{
    protected $access_token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiI3NDc4MGRlMS01YTE2LTQ2N2MtOTA4ZS0zN2UyMjllMDliM2UiLCJqdGkiOiIyNjRhZjg2ZTdlOTNhYWIzOTY5MDg5YjUyZTc0NGFmN2U5ODQ2MmRkZTNmMjliMjgxY2U5NWY1Y2FjNmYwZjQ4YmJiODk2MDY0M2I3YjcyNCIsImlhdCI6MTYzNDQ2OTUyNC43MzkzMjcsIm5iZiI6MTYzNDQ2OTUyNC43MzkzMzIsImV4cCI6MTY2NjAwNTUyNC43MjYzNTYsInN1YiI6IjM1MzQ0MWVhLTFmMjktNDM5Ny05M2VlLTEwMjFmNDRlNDlkMiIsInNjb3BlcyI6W119.CxY-v0Dz240z_VpaG1ryPTG_e4rceXtGUDpho-fqGR79bIxoLy0x5_Q_JtvNKh7LqF3ipM-uFLL7hnCQzOMAyoPUx0z78WzjYUvy3F8wvVb1E7buY-fMyJrYl8cbTZ9yC1EnPxKvtcm0_gBaPEaqKULqqtvaIaMhVeen5gzqran5kUj9RuW7o7rbqpBGWnBwRoxc_kt-w84Vq6ScoUdcK649ZQQ0l5Cs33vCNMmwP5pkmaEuNcXptMctfOv6X_lM2zpxqo60EhDsPa4N82NVcJcTqF_EMAK2a8LpaoUzgG5_h-H2GZ2rpKx-V1hnFHQiUBbbjIhrBpAGG8NGUWHWbVQV5FLPkRkoLvX2IrZaqxHsQ1N9UqaiU9avJy_H-Iv8pSBxbk-E6UlUATBCuuiqhj_WUA8lCi-b8r-D7qz8GEs5_tcBUVquoZu9XzdXk0MU-z4gZjDHQ_88q_esqdzzjALhAp4O2AhMLppt5c7WdoifMsKE8II3sUduTjVbPUgyj0ShmoGnrfNDtOFVxrcPrE_5ljk0OxCEIYNqN7Vo_0gvO1FH3ZCU19k8AWF_XHGaOfJtKiIr6CSWLIxF4sa4guLAykbzKwO7-i0G9hcmIw7Il7p2Bz-RPylDBmzi7QmdiV2nLTiVFNZKEjxbmB8WFAqs5WCFg_vmg7wuaLPSMD4";
    /**
     * test case: require authorize
     */
    public function testAuthorizeRequire()
    {
        $requestBody = [
        ];

        $this->json('POST', 'loan/create', $requestBody, ['Accept' => 'application/json'])
            ->seeJsonEquals([
                'error' => [
                    'code' => ErrorCodeConstant::EC_AUTH_TOKEN_REQUIRE
                ],
            ]);
    }

    /**
     * test case: require authorize
     */
    public function testAuthorizeInValid()
    {
        $requestBody = [
        ];

        $this->json('POST', 'loan/create', $requestBody, [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer Bearer',
        ])
            ->seeJsonEquals([
                'error' => [
                    'code' => ErrorCodeConstant::EC_AUTH_TOKEN_INVALID
                ],
            ]);
    }

    /**
     * test case: authorize has expired
     */
    public function testAuthorizeHasExpire()
    {
        $requestBody = [
        ];

        $this->json('POST', 'loan/create', $requestBody, [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->access_token,
        ])
            ->seeJsonEquals([
                'error' => [
                    'code' => ErrorCodeConstant::EC_AUTH_TOKEN_EXPIRE
                ],
            ]);
    }
}
