<?php

namespace Tests\Feature\Employee;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\Utils\ResponseAssertion;
use Tests\Utils\UserFactory;

class RetrieveEmployeesPageTest extends TestCase
{
    use RefreshDatabase;
    use ResponseAssertion;
    use UserFactory;

    /**
     * @return void
     */
    public function test_should_return_html_response()
    {
        $response = $this
            ->actingAs(
                $this->createUser()
            )
            ->get(route('employees.index'));

        $response->assertOk();
        $this->assertHtmlResponse($response);
    }
}
