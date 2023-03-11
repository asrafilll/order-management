<?php

namespace App\Exports;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderSource;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Excel;

class OrdersExport implements
    FromQuery,
    WithHeadings,
    WithMapping,
    ShouldAutoSize,
    Responsable
{
    use Exportable;

    const FILE_NAME = 'orders.xlsx';

    private $fileName = self::FILE_NAME;

    private $writerType = Excel::XLSX;

    /** @var Request */
    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @return Builder|EloquentBuilder|Relation
     */
    public function query()
    {
        $query = OrderItem::query()
            ->latest()
            ->select([
                'orders.*',
                'order_items.product_name',
                'order_items.variant_name',
            ])
            ->join('orders', 'order_items.order_id', 'orders.id');

        if ($this->request->filled('search')) {
            $query->where(function ($query) {
                $query
                    ->orWhere('orders.status', 'LIKE', '%' . $this->request->get('search') . '%')
                    ->orWhere('orders.source_name', 'LIKE', '%' . $this->request->get('search') . '%')
                    ->orWhere('orders.payment_status', 'LIKE', '%' . $this->request->get('search') . '%')
                    ->orWhere('orders.customer_name', 'LIKE', '%' . $this->request->get('search') . '%')
                    ->orWhere('orders.items_quantity', 'LIKE', '%' . $this->request->get('search') . '%')
                    ->orWhere('orders.total_price', 'LIKE', '%' . $this->request->get('search') . '%');
            });
        }

        $filters = [
            'orders.customer_id' => 'customer_id',
            'orders.status' => 'status',
            'orders.payment_status' => 'payment_status',
            'orders.sales_id' => 'sales_id',
            'orders.customer_type' => 'customer_type',
            'orders.payment_method_id' => 'payment_method_id',
            'orders.shipping_id' => 'shipping_id',
            'orders.customer_province' => 'customer_province',
            'orders.customer_city' => 'customer_city',
            'orders.customer_subdistrict' => 'customer_subdistrict',
            'orders.customer_village' => 'customer_village',
        ];

        foreach ($filters as $field => $filter) {
            if ($this->request->filled($filter)) {
                $query->where($field, $this->request->get($filter));
            }
        }

        if ($this->request->filled('source_id')) {
            /** @var OrderSource */
            $orderSource = OrderSource::with(['child'])->find($this->request->get('source_id'));

            if ($orderSource->child->count() < 1) {
                $query->where('source_id', $orderSource->id);
            } else {
                $query->whereIn('source_id', $orderSource->child->pluck('id'));
            }
        }

        if ($this->request->filled('variant_name')) {
            $query->where('order_items.product_name', 'LIKE', '%' . $this->request->get('variant_name') . '%');
        }

        if ($this->request->filled('start_date')) {
            $query->whereRaw('DATE(orders.created_at) >= ?', [$this->request->get('start_date')]);
        }

        if ($this->request->filled('end_date')) {
            $query->whereRaw('DATE(orders.created_at) <= ?', [$this->request->get('end_date')]);
        }

        return $query;
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            __('ID'),
            __('Created At'),
            __('Closing Date'),
            __('Product'),
            __('Variant'),
            __('Name'),
            __('Phone'),
            __('Address'),
            __('Province'),
            __('City'),
            __('Subdistrict'),
            __('Village'),
            __('Postal Code'),
            __('Items Quantity'),
            __('Items Price'),
            __('Items Discount'),
            __('Shipping Price'),
            __('Shipping Discount'),
            __('Total'),
            __('Payment Method'),
            __('Shipping'),
            __('Airwaybill'),
            __('Shipping Date'),
            __('Note'),
            __('Customer Type'),
            __('Source'),
            __('Sales'),
            __('Creator'),
            __('Packer'),
            __('Payment Status'),
            __('Status'),
        ];
    }

    /**
     * @param object $row
     * @return array
     */
    public function map($row): array
    {
        return [
            $row->id,
            $row->created_at,
            $row->closing_date,
            $row->product_name,
            $row->variant_name,
            $row->customer_name,
            $row->customer_phone,
            $row->customer_address,
            $row->customer_province,
            $row->customer_city,
            $row->customer_subdistrict,
            $row->customer_village,
            $row->customer_postal_code,
            $row->items_quantity,
            $row->items_price,
            $row->items_discount,
            $row->shipping_price,
            $row->shipping_discount,
            $row->total_price,
            $row->payment_method_name,
            $row->shipping_name,
            $row->shipping_airwaybill,
            $row->shipping_date,
            $row->note,
            Str::upper($row->customer_type),
            $row->source_name,
            $row->sales_name,
            $row->creator_name,
            $row->packer_name,
            Str::upper($row->payment_status),
            Str::upper($row->status),
        ];
    }
}
