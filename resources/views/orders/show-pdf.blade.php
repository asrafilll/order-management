<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta
        http-equiv="Content-Type"
        content="text/html; charset=utf-8"
    />
    <title>Order {{ $order->id }}</title>
    <!-- CSS Reset -->
    <style>
        /* http://meyerweb.com/eric/tools/css/reset/v2.0 | 20110126 License: none (public domain) */
        html,
        body,
        div,
        span,
        applet,
        object,
        iframe,
        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        p,
        blockquote,
        pre,
        a,
        abbr,
        acronym,
        address,
        big,
        cite,
        code,
        del,
        dfn,
        em,
        img,
        ins,
        kbd,
        q,
        s,
        samp,
        small,
        strike,
        strong,
        sub,
        sup,
        tt,
        var,
        b,
        u,
        i,
        center,
        dl,
        dt,
        dd,
        ol,
        ul,
        li,
        fieldset,
        form,
        label,
        legend,
        table,
        caption,
        tbody,
        tfoot,
        thead,
        tr,
        th,
        td,
        article,
        aside,
        canvas,
        details,
        embed,
        figure,
        figcaption,
        footer,
        header,
        hgroup,
        menu,
        nav,
        output,
        ruby,
        section,
        summary,
        time,
        mark,
        audio,
        video {
            margin: 0;
            padding: 0;
            border: 0;
            font-size: 100%;
            font: inherit;
            vertical-align: baseline;
        }

        /* HTML5 display-role reset for older browsers */
        article,
        aside,
        details,
        figcaption,
        figure,
        footer,
        header,
        hgroup,
        menu,
        nav,
        section {
            display: block;
        }

        body {
            line-height: 1;
        }

        ol,
        ul {
            list-style: none;
        }

        blockquote,
        q {
            quotes: none;
        }

        blockquote:before,
        blockquote:after,
        q:before,
        q:after {
            content: '';
            content: none;
        }

        table {
            border-collapse: collapse;
            border-spacing: 0;
        }

    </style>

    <style>
        body {
            padding: 2rem;
            border: 1px solid #000;
        }

        table {
            width: 100%;
            {{-- border: 1px solid #000; --}}
        }

        td {
            {{-- border: 1px solid #000; --}}
        }

        img {
            padding: 1px;
        }

    </style>
</head>

<body>
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
                    <li>{{ $customerAddress }}</li>
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
            <td style="padding: 0.2rem;">{{ __('Quantity') }}:</td>
        </tr>
        @foreach ($order->items  as $item)
            <tr>
                <td style="padding: 0.2rem;">{{ $loop->iteration }}. {{ $item->product_name }}</td>
                <td style="padding: 0.2rem;">{{ $item->variant_name }}</td>
                <td style="padding: 0.2rem;">{{ $item->quantity }}</td>
            </tr>
        @endforeach
    </table>
</body>

</html>
