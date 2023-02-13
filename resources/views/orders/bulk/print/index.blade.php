<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta
        http-equiv="Content-Type"
        content="text/html; charset=utf-8"
    />
    <title>Orders</title>
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
            font-size: 0.8rem;
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
            border: 1px solid #000;
        }

        table {
            width: 100%;
        }

        img {
            padding: 0.2rem 0.5rem;
        }
    </style>
</head>

<body>
    @foreach ($orders as $order)
        @if ($loop->odd)
            <table style="border-collapse: separate; border-spacing: 1rem 0.5rem;">
                <tr>
        @endif
        <td width="50%" style="border: 1px solid #000;">
            <x-print-order
                :order="$order"
                :company="$company"
                :companyAddress="$companyAddress"
            />
        </td>
        @if ($loop->even)
                </tr>
            </table>
        @endif
    @endforeach
</body>

</html>