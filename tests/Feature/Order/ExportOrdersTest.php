<?php

namespace Tests\Feature\Order;

use App\Enums\PermissionEnum;
use App\Exports\OrdersExport;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Maatwebsite\Excel\Facades\Excel;
use Tests\TestCase;
use Tests\Utils\ResponseAssertion;
use Tests\Utils\UserFactory;

class ExportOrdersTest extends TestCase
{
    use RefreshDatabase;
    use ResponseAssertion;
    use UserFactory;

    /**
     * @return void
     */
    public function test_can_export_orders()
    {
        Excel::fake();

        $response = $this
            ->actingAs(
                $this->createUserWithPermission(
                    PermissionEnum::manage_orders()
                )
            )
            ->get(route('orders.index', [
                'action' => 'export',
            ]));

        $response->assertOk();

        Excel::assertDownloaded(OrdersExport::FILE_NAME);
    }
}
