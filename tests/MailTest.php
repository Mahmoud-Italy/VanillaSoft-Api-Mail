<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class MailTest extends TestCase
{
    
    public function test_api_mail_with_api_token_is_required()
    {
        $api_token = '';
        $response  = $this->json('GET', '/v1/inbox?api_token='.$api_token);
        $this->assertEquals(422, $this->response->status());
    }

    public function test_api_mail_fetch_all_index()
    {
        $api_token = '$2y$10$8lkX6uwEJqHat64SIFmsL.SJClPOf7rJhIxVsmjOSpdgsIPFUSXz.';
        $response  = $this->json('GET', '/v1/inbox?api_token='.$api_token);
        $this->assertEquals(200, $this->response->status());
    }

    public function test_api_mail_post_check_validation_to()
    {
        $api_token = '$2y$10$8lkX6uwEJqHat64SIFmsL.SJClPOf7rJhIxVsmjOSpdgsIPFUSXz.';
        $data = [
            'to' => '',
        ];
        $response  = $this->json('POST', '/v1/inbox?api_token='.$api_token, $data);
        $this->assertEquals(422, $this->response->status());
    }

    public function test_api_mail_post_check_validation_subject()
    {
        $api_token = '$2y$10$8lkX6uwEJqHat64SIFmsL.SJClPOf7rJhIxVsmjOSpdgsIPFUSXz.';
        $data = [
            'subject' => '',
        ];
        $response  = $this->json('POST', '/v1/inbox?api_token='.$api_token, $data);
        $this->assertEquals(422, $this->response->status());
    }

    public function test_api_mail_post_check_validation_body()
    {
        $api_token = '$2y$10$8lkX6uwEJqHat64SIFmsL.SJClPOf7rJhIxVsmjOSpdgsIPFUSXz.';
        $data = [
            'body' => '',
        ];
        $response  = $this->json('POST', '/v1/inbox?api_token='.$api_token, $data);
        $this->assertEquals(422, $this->response->status());
    }

    public function test_api_mail_post()
    {
        $api_token = '$2y$10$8lkX6uwEJqHat64SIFmsL.SJClPOf7rJhIxVsmjOSpdgsIPFUSXz.';
        $data = [
            'to'      => ['mahmoud.italy@outlook.com,mahmoud.italy93@gmail.com'],
            'subject' => 'test Subject from Unit testing...',
            'body'    => 'test body from Unit testing....',
        ];
        $response  = $this->json('POST', '/v1/inbox?api_token='.$api_token, $data);
        $this->assertEquals(200, $this->response->status());
    }

    public function test_api_mail_show_single_row()
    {
        $api_token = '$2y$10$8lkX6uwEJqHat64SIFmsL.SJClPOf7rJhIxVsmjOSpdgsIPFUSXz.';
        $response  = $this->json('GET', '/v1/inbox?api_token='.$api_token);
        $id        = $this->response['items'][0]['encrypt_id'];

        $response  = $this->json('GET', '/v1/inbox/'.$id.'?api_token='.$api_token);
        $this->assertEquals(200, $this->response->status());
    }

    public function test_api_mail_destroy()
    {
        $api_token = '$2y$10$8lkX6uwEJqHat64SIFmsL.SJClPOf7rJhIxVsmjOSpdgsIPFUSXz.';
        $response  = $this->json('GET', '/v1/inbox?api_token='.$api_token);
        $id        = $this->response['items'][0]['encrypt_id'];

        $response  = $this->json('DELETE', '/v1/inbox/'.$id.'?api_token='.$api_token);
        $this->assertEquals(200, $this->response->status());
    }
}
