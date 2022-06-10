@props(['order'])

<div>
    <form
        id="order-contributors-module"
        action="{{ route('orders.contributors.update', $order) }}"
        method="POST"
    >
        @csrf
        @method('PUT')
        <div class="card">
            <div class="card-header">{{ __('Contributors') }}</div>
            <div class="card-body">
                <div class="form-group">
                    <label for="sales_name">
                        <span>{{ __('Sales') }}</span>
                        <span class="text-danger">*</span>
                    </label>
                    <input
                        type="hidden"
                        name="sales_id"
                        id="sales_id"
                        value="{{ old('sales_id') ?? $order->sales_id }}"
                    />
                    <input
                        type="text"
                        name="sales_name"
                        id="sales_name"
                        class="form-control @error('sales_name') is-invalid @enderror @error('sales_id') is-invalid @enderror"
                        value="{{ old('sales_name') ?? $order->sales_name }}"
                    />
                    @error('sales_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    @error('sales_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="creator_name">
                        <span>{{ __('Creator') }}</span>
                        <span class="text-danger">*</span>
                    </label>
                    <input
                        type="hidden"
                        name="creator_id"
                        id="creator_id"
                        value="{{ old('creator_id') ?? $order->creator_id }}"
                    />
                    <input
                        type="text"
                        name="creator_name"
                        id="creator_name"
                        class="form-control @error('creator_name') is-invalid @enderror @error('creator_id') is-invalid @enderror"
                        value="{{ old('creator_name') ?? $order->creator_name }}"
                    />
                    @error('creator_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    @error('creator_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="packer_name">
                        <span>{{ __('Packer') }}</span>
                        <span class="text-danger">*</span>
                    </label>
                    <input
                        type="hidden"
                        name="packer_id"
                        id="packer_id"
                        value="{{ old('packer_id') ?? $order->packer_id }}"
                    />
                    <input
                        type="text"
                        name="packer_name"
                        id="packer_name"
                        class="form-control @error('packer_name') is-invalid @enderror @error('packer_id') is-invalid @enderror"
                        value="{{ old('packer_name') ?? $order->packer_name }}"
                    />
                    @error('packer_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    @error('packer_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="card-footer">
                <button
                    type="submit"
                    class="btn btn-primary"
                >{{ __('Save') }}</button>
            </div>
        </div>
    </form>
    <script>
        const OrderContributors = (function() {
            const $el = $('#order-contributors-module');
            const $salesId = $el.find('#sales_id');
            const $salesName = $el.find('#sales_name');
            const $creatorId = $el.find('#creator_id');
            const $creatorName = $el.find('#creator_name');
            const $packerId = $el.find('#packer_id');
            const $packerName = $el.find('#packer_name');

            init();

            function init() {
                $salesName.autocomplete({
                    source: handleSource,
                    select: function(event, ui) {
                        $salesId.val(ui.item.id);
                    },
                });

                $creatorName.autocomplete({
                    source: handleSource,
                    select: function(event, ui) {
                        $creatorId.val(ui.item.id);
                    },
                });

                $packerName.autocomplete({
                    source: handleSource,
                    select: function(event, ui) {
                        $packerId.val(ui.item.id);
                    },
                });
            }

            function handleSource(request, response) {
                $.ajax({
                    method: 'GET',
                    url: '{{ route('web-api.employees.index') }}',
                    data: {
                        q: request.term,
                    },
                    success: function(res) {
                        response(res.data.map(function(employee) {
                            return {
                                id: employee.id,
                                label: employee.name,
                                value: employee.name,
                            };
                        }))
                    },
                });
            }
        })();
    </script>
</div>
