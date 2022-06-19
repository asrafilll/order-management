<table>
    <tr>
        <td>
            <table>
                <tr>
                    <td>
                        <img
                            src="themes/img/logo-300x100.png"
                            alt="{{ Config::get('app.name') }}"
                            height="100"
                        />
                    </td>
                    <td width="100%"></td>
                    <td>
                        <img
                            src="themes/img/qr.png"
                            alt="{{ Config::get('app.url') }}"
                            height="100"
                        />
                    </td>
                </tr>
            </table>
            <hr />
            <br />
            <br />
            <table style="text-align: center;">
                <tr>
                    <td width="33%">
                        <p style="margin-bottom: 0.3rem;">{{ __('Payment Method') }}:</p>
                        <p style="font-weight: bold;">{{ $order->payment_method_name ?? '-' }}</p>
                    </td>
                    <td width="33%">
                        <p style="margin-bottom: 0.3rem;">{{ __('Shipping') }}:</p>
                        <p style="font-weight: bold;">{{ $order->shipping_name ?? '-' }}</p>
                    </td>
                    <td width="33%"></td>
                </tr>
            </table>
            <br />
            <br />
            <table style="border: 1px solid #000;">
                <tr>
                    <td style="font-weight: bold; padding: 1rem; font-style: italic;">{{ __('NOTE') }}:</td>
                    <td
                        width="100%"
                        style="padding: 1rem;"
                    >{{ $order->note }}</td>
                </tr>
            </table>
            <br />
            <br />
            <table>
                <tr>
                    <td width="45%">
                        <ul style="line-height: 1.4;">
                            <li>{{ __('Destination') }}:</li>
                            <li style="font-size: 1.1rem; font-weight: bold;">{{ $order->customer_name }}</li>
                            <li>{{ $order->customer_address }}</li>
                            <li>{{ $order->getCustomerAddress() }}</li>
                            <li>({{ __('Phone') . '. ' . $order->customer_phone }})</li>
                        </ul>
                    </td>
                    <td width="10%"></td>
                    <td width="45%">
                        <ul style="line-height: 1.4;">
                            <li>{{ __('Origin') }}:</li>
                            <li style="font-size: 1.1rem; font-weight: bold;">{{ $company['name'] }}</li>
                            <li>{{ $company['address'] }}</li>
                            <li>{{ $companyAddress }}</li>
                            <li>({{ __('Phone') . '. ' . $company['phone'] }})</li>
                        </ul>
                    </td>
                </tr>
            </table>
            <br />
            <hr />
            <br />
            <table>
                <tr>
                    <td style="padding: 0.2rem;">{{ __('Product') }}:</td>
                    <td style="padding: 0.2rem;">{{ __('Variant') }}:</td>
                    <td style="padding: 0.2rem;">{{ __('Note') }}:</td>
                    <td style="padding: 0.2rem;">{{ __('Quantity') }}:</td>
                </tr>
                @foreach ($order->items as $item)
                    <tr>
                        <td style="padding: 0.2rem;">{{ $loop->iteration }}. {{ $item->product_name }}</td>
                        <td style="padding: 0.2rem;">{{ $item->variant_name }}</td>
                        <td style="padding: 0.2rem;">{{ $item->note }}</td>
                        <td style="padding: 0.2rem;">{{ $item->quantity }}</td>
                    </tr>
                @endforeach
            </table>
        </td>
    </tr>
</table>
