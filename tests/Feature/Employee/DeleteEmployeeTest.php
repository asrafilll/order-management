<?php

namespace Tests\Feature\Employee;

use App\Enums\PermissionEnum;
use App\Models\Employee;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tests\Utils\ResponseAssertion;
use Tests\Utils\UserFactory;

class DeleteEmployeeTest extends TestCase
{
    use RefreshDatabase;
    use ResponseAssertion;
    use UserFactory;

    /**
     * @return void
     */
    public function test_should_success_delete_employee()
    {
        /** @var Employee */
        $employee = Employee::factory()->create();
        $response = $this
            ->actingAs(
                $this->createUserWithPermission(
                    PermissionEnum::manage_employees()
                )
            )
            ->delete(route('employees.destroy', $employee));

        $response
            ->assertRedirect()
            ->assertSessionHasNoErrors();
    }

    public function test_should_error_when_not_found()
    {
        $response = $this
            ->actingAs(
                $this->createUserWithPermission(
                    PermissionEnum::manage_employees()
                )
            )
            ->delete(route('employees.destroy', ['employee' => '0']));

        $response->assertNotFound();
    }
}
