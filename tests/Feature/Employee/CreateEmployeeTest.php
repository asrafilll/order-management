<?php

namespace Tests\Feature\Employee;

use App\Models\Employee;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tests\Utils\ResponseAssertion;
use Tests\Utils\UserFactory;

class CreateEmployeeTest extends TestCase
{
    use RefreshDatabase;
    use ResponseAssertion;
    use UserFactory;

    /**
     * @return void
     */
    public function test_should_success_create_employee()
    {
        $input = [
            'name' => 'Employee #1',
        ];

        $response = $this
            ->actingAs(
                $this->createUser()
            )
            ->post(route('employees.store'), $input);

        $response
            ->assertRedirect()
            ->assertSessionHasNoErrors();

        $this->assertDatabaseHas((new Employee())->getTable(), $input);
    }

    /**
     * @return void
     */
    public function test_should_error_create_employee()
    {
        $input = [
            'name' => null,
        ];

        $response = $this
            ->actingAs(
                $this->createUser()
            )
            ->post(route('employees.store'), $input);

        $response
            ->assertRedirect()
            ->assertSessionHasErrors(['name']);
    }
}
