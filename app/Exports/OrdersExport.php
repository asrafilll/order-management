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
        $rows = [];
        $products = $order->items;
        // Setiap produk menjadi baris terpisah
        foreach ($products as $key=>$product) {
            $rows[] = [
            $key == 0 ? $order->id : "",
            $key == 0 ? $order->created_at : "",
            $key == 0 ? $order->closing_date : "",
            $product->product_name, // Nama Produk
            $product->variant_name, // Variant Produk
            $key == 0 ? $order->customer_name : "",
            $key == 0 ? $order->customer_phone : "",
            $key == 0 ? $order->customer_address : "",
            $key == 0 ?  $order->customer_province : "",
            $key == 0 ? $order->customer_city : "",
            $key == 0 ? $order->customer_subdistrict : "",
            $key == 0 ? $order->customer_village : "",
            $key == 0 ? $order->customer_postal_code : "",
            $key == 0 ? $order->items_quantity : "",
            $key == 0 ? $order->items_price : "",
            $key == 0 ? $order->items_discount:"" ,
            $key == 0 ? $order->shipping_price: "",
            $key == 0 ? $order->shipping_discount : "",
            $key == 0 ? $order->total_price : "",
            $key == 0 ? $order->payment_method_name : "",
            $key == 0 ? $order->shipping_name : "",
            $key == 0 ? $order->shipping_airwaybill :"",
            $key == 0 ? $order->shipping_date :"",
            $key == 0 ? $order->note :"",
            $key == 0 ? Str::upper($order->customer_type) :"",
            $key == 0 ? $order->source_name :"",
            $key == 0 ? $order->sales_name :"",
            $key == 0 ? $order->creator_name :"",
            $key == 0 ? $order->packer_name :"",
            $key == 0 ? Str::upper($order->payment_status):"",
            $key == 0 ? Str::upper($order->status):"",
            ];
        }
    
        return $rows;
    }
}
