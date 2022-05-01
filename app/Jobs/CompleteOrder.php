<?php

namespace App\Jobs;

use App\Enums\OrderHistoryTypeEnum;
use App\Enums\OrderStatusEnum;
use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CompleteOrder implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    protected Order $order;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if ($this->order->status->equals(OrderStatusEnum::sent())) {
            $currentStatus = $this->order->status;
            $this->order->status = OrderStatusEnum::completed();
            $this->order->saveQuietly();
            $this->order->histories()->create([
                'type' => OrderHistoryTypeEnum::status(),
                'from' => $currentStatus,
                'to' => OrderStatusEnum::completed(),
            ]);
        }
    }
}
