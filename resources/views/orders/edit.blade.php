<x-app>
    <x-content-header>
        <h1 class="m-0">{{ __('Edit Order') }}</h1>
    </x-content-header>

    <section class="content">
        <div class="row">
            <div class="col-lg">
                <x-order-items :order="$order" />
                <x-order-shipping :order="$order" />
                <x-order-payment :order="$order" />
            </div>
            <div class="col-lg-3">
                <x-order-status :order="$order" :orderStatuses="$orderStatuses" />
                <x-order-general-information :order="$order" />
                <x-order-note :order="$order" />
                <x-order-contributors :order="$order" />
                <x-order-shipping-detail :order="$order" />
                <x-order-closing-date :order="$order" />
                <x-order-histories :order="$order" />
            </div>
        </div>
    </section>
</x-app>
