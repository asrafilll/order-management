<x-app>
    <x-content-header>
        <h1 class="m-0">{{ __('Create User') }}</h1>
    </x-content-header>

    <section class="content">
        <form
            action="{{ route('products.store') }}"
            method="POST"
            novalidate
        >
            @csrf
            <div class="row">
                <div class="col-lg-9">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="name">
                                    <span>{{ __('Name') }}</span>
                                    <span class="text-danger">*</span>
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
                            <div class="form-group">
                                <label for="description">
                                    <span>{{ __('Description') }}</span>
                                    <span class="text-danger">*</span>
                                </label>
                                <textarea
                                    name="description"
                                    id="description"
                                    rows="4"
                                    class="form-control @error('description') is-invalid @enderror"
                                >{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{{ __('Options') }}</h3>
                        </div>
                        <div class="card-body">
                            <div id="options">
                                @include('products.components.option', ['index' => 1])
                            </div>
                            <a
                                href="javascript:void(0)"
                                id="btn-add-option"
                            >{{ __('Add another option') }}</a>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header d-flex align-items-center">
                            <h3 class="card-title">{{ __('Variants') }}</h3>
                        </div>
                        <div
                            class="card-body"
                            id="variants"
                        ></div>
                    </div>
                </div>
                <div class="col-lg">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="status">
                                    <span>{{ __('Status') }}</span>
                                    <span class="text-danger">*</span>
                                </label>
                                <select
                                    name="status"
                                    id="status"
                                    class="form-control @error('status') is-invalid @enderror"
                                >
                                    @foreach (\App\Enums\ProductStatusEnum::toValues() as $status)
                                        <option
                                            value="{{ $status }}"
                                            @if (old('status') == $status) selected @endif
                                        >{{ Str::title($status) }}</option>
                                    @endforeach
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </section>
    <script>
        $(function() {
            const $options = $('#options');
            const $variants = $('#variants');
            const $btnAddOption = $('#btn-add-option');

            $btnAddOption.on('click', addOption);
            $(document).on('click', '.btn-delete-option', deleteOption);
            $(document).on('keyup', '.values', $.debounce(500, generateVariants));

            function addOption() {
                const url = new URL('{{ route('products.create') }}');
                url.searchParams.set('action', 'add-option');
                url.searchParams.set('index', $options.children().length + 1);

                if ($options.children().length > 1) {
                    $btnAddOption.hide();
                }

                if ($options.children().length > 2) {
                    return;
                }

                $.get(url, function(response) {
                    $options.append(response)
                });
            }

            function deleteOption() {
                $('.option-wrapper').last().remove();

                if ($options.children().length < 3) {
                    $btnAddOption.show();
                }

                generateVariants();
            }

            function generateVariants() {
                const url = new URL('{{ route('products.create') }}');
                url.searchParams.set('action', 'generate-variants');
                for (let i = 1; i <= $options.children().length; i++) {
                    const option = $('#option' + i).val();
                    const values = $('#values' + i).val();
                    if (option.length > 0 && values.length > 0) {
                        url.searchParams.set('values' + i, values);
                    }
                }

                $.get(url, function(response) {
                    $variants.html(response);
                });
            }
        });
    </script>
</x-app>
