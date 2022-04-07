<?php

namespace Tests\Utils;

trait ResponseAssertion
{
    public function assertHtmlResponse($response)
    {
        $response->assertSee('html');
    }
}
