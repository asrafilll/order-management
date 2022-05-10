<x-app>
    <x-content-header>
        <h1 class="m-0">{{ __('Create Order Source') }}</h1>
    </x-content-header>

    <section class="content">
        <div class="row">
            <div class="col-lg-6">
                <form
                    action="{{ route('order-sources.store') }}"
                    method="POST"
                    novalidate
                >
                    @csrf
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="name">
                                    <span>{{ __('Name') }}</span>
                                </label>
                                <input
                                    type="text"
                                    id="name"
                                    name="name"
                                    class="form-control @error('name') is-invalid @enderror"
                                    value="{{ old('name') }}"
                                />
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div
                                id="order-source-parent-module"
                                class="form-group"
                            >
                                <label for="parent_name">
                                    <span>{{ __('Parent') }}</span>
                                    <span class="text-danger">*</span>
                                </label>
                                <input
                                    type="hidden"
                                    id="parent_id"
                                    name="parent_id"
                                    value="{{ old('parent_id') }}"
                                />
                                <input
                                    type="text"
                                    id="parent_name"
                                    name="parent_name"
                                    class="form-control @error('parent_name') is-invalid @enderror"
                                    value="{{ old('parent_name') }}"
                                />
                                @error('parent_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <script>
                                const OrderSourceParent = (function() {
                                    const $el = $('#order-source-parent-module');
                                    const $id = $el.find('#parent_id');
                                    const $name = $el.find('#parent_name');

                                    init();

                                    function init() {
                                        $name.autocomplete({
                                            source: function(request, response) {
                                                $.ajax({
                                                    method: 'GET',
                                                    url: '{{ route('web-api.order-sources.index', ['parent_only' => 1]) }}',
                                                    data: {
                                                        q: request.term,
                                                    },
                                                    success: function(res) {
                                                        response(res.data.map(function(orderSource) {
                                                            return {
                                                                id: orderSource.id,
                                                                label: orderSource.name,
                                                                value: orderSource.name,
                                                            };
                                                        }))
                                                    },
                                                });
                                            },
                                            select: function(event, ui) {
                                                $id.val(ui.item.id);
                                            },
                                        });
                                    }
                                })();
                            </script>
                        </div>
                        <div class="card-footer">
                            <button
                                type="submit"
                                class="btn btn-primary"
                            >{{ __('Save') }}</button>
                            <a
                                href="{{ route('order-sources.index') }}"
                                class="btn btn-default"
                            >{{ __('Back') }}</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
</x-app>
