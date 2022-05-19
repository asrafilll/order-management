<?php

namespace App\Exports;

use App\Models\Order;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Query\Builder;
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

    /** @var Builder|EloquentBuilder|Relation */
    private $_query;

    /**
     * @param Builder|EloquentBuilder|Relation $query
     */
    public function __construct($query)
    {
        $this->_query = $query;
    }

    /**
     * @return Builder|EloquentBuilder|Relation
     */
    public function query()
    {
        return $this->_query;
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            __('ID'),
            __('Closing Date'),
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
     * @param Order $order
     * @return array
     */
    public function map($order): array
    {
        return [
            $order->id,
            $order->created_at,
            $order->customer_name,
            $order->customer_phone,
            $order->customer_address,
            $order->customer_province,
            $order->customer_city,
            $order->customer_subdistrict,
            $order->customer_village,
            $order->customer_postal_code,
            $order->items_quantity,
            $order->items_price,
            $order->items_discount,
            $order->shipping_price,
            $order->shipping_discount,
            $order->total_price,
            $order->payment_method_name,
            $order->shipping_name,
            $order->shipping_airwaybill,
            $order->shipping_date,
            $order->note,
            Str::upper($order->customer_type),
            $order->source_name,
            $order->sales_name,
            $order->creator_name,
            $order->packer_name,
            Str::upper($order->payment_status),
            Str::upper($order->status),
        ];
    }
}
