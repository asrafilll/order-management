<x-app>
    <x-content-header>
        <h1 class="m-0">{{ __('Create Product') }}</h1>
    </x-content-header>

    <section class="content">
        <form
            action="{{ route('products.store') }}"
            method="POST"
            novalidate
        >
            @csrf
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
            <div class="card" id="product-option-module">
                <div class="card-header">
                    <h3 class="card-title">{{ __('Options') }}</h3>
                </div>
                <div class="card-body p-0">
                    <div id="options"></div>
                    <button
                        type="button"
                        id="btn-add-option"
                        class="btn btn-default btn-block text-left text-primary"
                    >{{ __('Add another option') }}</button>
                </div>
            </div>
            <script>
                const ProductOption = (function () {
                    const MAX_OPTIONS_LENGTH = 2;
                    const MIN_OPTION_VALUES_LENGTH = 2;

                    // Cache DOM
                    const $el = $('#product-option-module');
                    const $options = $el.find('#options');
                    const $add = $el.find('#btn-add-option');

                    // Bind events
                    $add.on('click', _addOptionHandler);
                    $(document).on('click', '.btn-delete-option', _deleteOptionHandler);
                    $(document).on('keyup', '.option-value', _addOptionValueHandler);
                    $(document).on('click', '.btn-delete-option-value', _deleteOptionValueHandler);

                    // Initial
                    $add.trigger('click');

                    function _addOptionHandler() {
                        const url = new URL('{{ route('products.create') }}');
                        url.searchParams.set('action', 'add-option');
                        url.searchParams.set('index', getOptionsLength());

                        $.get(url, function(response) {
                            $options.append(response);

                            if (getOptionsLength() >= MAX_OPTIONS_LENGTH) {
                                $add.hide();
                            }
                        });
                    }

                    function getOptionsLength() {
                        return $options.children().length;
                    }

                    function _deleteOptionHandler() {
                        $options.children().last().remove();

                        if (getOptionsLength() < 3) {
                            $add.show();
                        }
                    }

                    function _addOptionValueHandler() {
                        const $this = $(this);
                        const $optionValuesWrapper = $this.closest('.option-values-wrapper');
                        const $optionValueWrapper = $this.closest('.option-value-wrapper');

                        if ($this.val().length > 0 && $optionValueWrapper.next().length < 1) {
                            const $clone = $optionValueWrapper.clone();
                            $clone.find('input').val(null);
                            $optionValuesWrapper.append($clone);
                        }

                        _toggleOptionValueDelete($optionValuesWrapper);
                    }

                    function _deleteOptionValueHandler() {
                        const $this = $(this);
                        const $optionValuesWrapper = $this.closest('.option-values-wrapper');
                        const $optionValueWrapper = $this.closest('.option-value-wrapper');

                        $optionValueWrapper.remove();

                        _toggleOptionValueDelete($optionValuesWrapper);
                    }

                    function _toggleOptionValueDelete($optionValuesWrapper) {
                        const $deleteOptionValues = $optionValuesWrapper.find('.btn-delete-option-value');

                        if ($optionValuesWrapper.children().length > MIN_OPTION_VALUES_LENGTH) {
                            $deleteOptionValues.removeAttr('disabled');
                            $deleteOptionValues.last().attr('disabled', true);
                        } else {
                            $deleteOptionValues.attr('disabled', true);
                        }
                    }

                    return {
                        getOptionsLength: getOptionsLength,
                    };
                })();
            </script>
            <div class="card">
                <div class="card-header d-flex align-items-center">
                    <h3 class="card-title">{{ __('Variants') }}</h3>
                </div>
                <div
                    class="card-body"
                    id="variants"
                ></div>
            </div>
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
                <div class="card-footer">
                    <button
                        type="submit"
                        class="btn btn-primary"
                    >{{ __('Save') }}</button>
                </div>
            </div>
        </form>
    </section>
</x-app>
