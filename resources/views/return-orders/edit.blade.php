<x-app>
    <x-content-header>
        <h1 class="m-0">{{ __('Edit Return') }}</h1>
    </x-content-header>

    <section class="content">
        <div class="row">
            <div class="col-lg">
                <x-return-order-order :returnOrder="$returnOrder" />
            </div>
            <div class="col-lg-4">
                <x-return-order-status
                    :returnOrderStatuses="$returnOrderStatuses"
                    :returnOrder="$returnOrder"
                />
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <x-return-order-order-items :returnOrder="$returnOrder" />
            </div>
            <div class="col-lg-6">
                <x-return-order-items :returnOrder="$returnOrder" />
            </div>
        </div>
    </section>
</x-app>
