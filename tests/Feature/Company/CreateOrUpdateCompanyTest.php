<?php

namespace Tests\Feature\Company;

use App\Enums\PermissionEnum;
use App\Models\Meta;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tests\Utils\UserFactory;

class CreateOrUpdateCompanyTest extends TestCase
{
    use RefreshDatabase;
    use UserFactory;

    /**
     * @return void
     */
    public function test_should_success_create_or_update_company()
    {
        $input = [
            'name' => 'My Company',
            'phone' => '628123123123',
            'address' => 'Company address',
            'province' => 'JAWA BARAT',
            'city' => 'BANDUNG',
            'subdistrict' => 'CIBEUNYING KIDUL',
            'village' => 'CICADAS',
            'postal_code' => '40121',
        ];

        $response = $this
            ->actingAs(
                $this->createUserWithPermission(
                    PermissionEnum::manage_company()
                )
            )
            ->post(route('company.store'), $input);

        $response
            ->assertRedirect()
            ->assertSessionHasNoErrors();

        foreach ($input as $key => $value) {
            $this->assertEquals($value, Meta::findByKey('company_' . $key));
        }
    }
}
