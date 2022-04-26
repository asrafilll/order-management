<?php

namespace Tests\Feature\Employee;

use App\Enums\PermissionEnum;
use App\Models\Employee;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tests\Utils\ResponseAssertion;
use Tests\Utils\UserFactory;

class UpdateEmployeeTest extends TestCase
{
    use RefreshDatabase;
    use ResponseAssertion;
    use UserFactory;

    /**
     * @return void
     */
    public function test_should_success_update_employee()
    {
        /** @var Employee */
        $employee = Employee::factory()->create();
        $input = [
            'name' => 'Updated Employee'
        ];
        $response = $this
            ->actingAs(
                $this->createUserWithPermission(
                    PermissionEnum::manage_employees()
                )
            )
            ->put(route('employees.update', $employee), $input);

        $response
            ->assertRedirect()
            ->assertSessionHasNoErrors();

        $this->assertDatabaseHas($employee->getTable(), $input);
    }

    /**
     * @return void
     */
    public function test_should_error_update_employee()
    {
        /** @var Employee */
        $employee = Employee::factory()->create();
        $input = [
            'name' => null
        ];
        $response = $this
            ->actingAs(
                $this->createUserWithPermission(
                    PermissionEnum::manage_employees()
                )
            )
            ->put(route('employees.update', $employee), $input);

        $response
            ->assertRedirect()
            ->assertSessionHasErrors(['name']);
    }

    /**
     * @return void
     */
    public function test_should_error_when_not_found()
    {
        $input = [
            'name' => 'Updated Employee'
        ];
        $response = $this
            ->actingAs(
                $this->createUserWithPermission(
                    PermissionEnum::manage_employees()
                )
            )
            ->put(route('employees.update', ['employee' => 0]), $input);

        $response->assertNotFound();
    }
}
