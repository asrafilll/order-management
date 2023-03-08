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
        $this->_query = $this->_query = \App\Models\OrderItem::with('order')->whereIn('order_id',$query->pluck('id'));
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
            __('Created At'),
            __('Closing Date'),
            __('Nama Produk'),
            __('Variasi'),
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
            $order->order->id,
            $order->order->created_at,
            $order->order->closing_date,
            $order->product_name, // Nama Produk
            $order->variant_name, // Variant Produk
            $order->order->customer_name ,
            $order->order->customer_phone ,
            $order->order->customer_address ,
            $order->order->customer_province,
            $order->order->customer_city ,
            $order->order->customer_subdistrict ,
            $order->order->customer_village ,
            $order->order->customer_postal_code ,

            $order->quantity ,
            $order->variant_price ,
            
            $order->order->items_discount ,
            $order->order->shipping_price,
            $order->order->shipping_discount,
            $order->quantity * $order->variant_price,
            $order->order->payment_method_name,
            $order->order->shipping_name ,
            $order->order->shipping_airwaybill ,
            $order->order->shipping_date ,
            $order->order->note ,
            Str::upper($order->order->customer_type),
            $order->order->source_name ,
            $order->order->sales_name ,
            $order->order->creator_name ,
            $order->order->packer_name ,
            Str::upper($order->order->payment_status),
            Str::upper($order->order->status),
        ];
    }
}
