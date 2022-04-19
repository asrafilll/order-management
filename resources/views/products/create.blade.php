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
            <div id="product-option-module">
                <div class="card">
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
                <script id="option-template" type="text/html">
                    <div class="option-wrapper px-3 py-2 border">
                        <div class="form-group row align-items-end">
                            <div class="col">
                                <label for="options-@{{ index }}-name">
                                    <span>{{ __('Option Name') }}</span>
                                    <span class="text-danger">*</span>
                                </label>
                                <input
                                    type="text"
                                    name="options[@{{ index }}][name]"
                                    id="options-@{{ index }}-name"
                                    class="form-control option-name"
                                    placeholder="eg: Color or Size"
                                />
                            </div>
                            <div class="col-auto">
                                <button
                                    type="button"
                                    class="btn btn-default btn-delete-option"
                                    tabindex="-1"
                                >
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>
                                <span>{{ __('Values') }}</span>
                                <span class="text-danger">*</span>
                            </label>
                            <div class="option-values-wrapper">
                                <div class="row option-value-wrapper mb-1">
                                    <div class="col">
                                        <input
                                            type="text"
                                            name="options[@{{ index }}][values][]"
                                            class="form-control option-value"
                                            placeholder="{{ __('Add another value') }}"
                                        />
                                    </div>
                                    <div class="col-auto">
                                        <button
                                            type="button"
                                            class="btn btn-default btn-delete-option-value"
                                            tabindex="-1"
                                            disabled
                                        >
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </script>
            </div>
            <script>
                const ProductOption = (function () {
                    const MAX_OPTIONS_LENGTH = 2;
                    const MIN_OPTION_VALUES_LENGTH = 2;
                    const template = $('#option-template').html();

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
                        $options.append(Mustache.render(template, {
                            index: _getOptionsLength(),
                        }));

                        if (_getOptionsLength() >= MAX_OPTIONS_LENGTH) {
                            $add.hide();
                        }
                    }

                    function _getOptionsLength() {
                        return $options.children().length;
                    }

                    function _deleteOptionHandler() {
                        $options.children().last().remove();

                        if (_getOptionsLength() < 3) {
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
                        Variants.generate();
                    }

                    function _deleteOptionValueHandler() {
                        const $this = $(this);
                        const $optionValuesWrapper = $this.closest('.option-values-wrapper');
                        const $optionValueWrapper = $this.closest('.option-value-wrapper');

                        $optionValueWrapper.remove();

                        _toggleOptionValueDelete($optionValuesWrapper);
                        Variants.generate();
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

                    function getOptions() {
                        return $('.option-wrapper')
                            .toArray()
                            .reduce(function (acc, element) {
                                const name = $(element).find('.option-name').val();

                                if (name.length < 1) {
                                    return acc;
                                }

                                const values = $(element).find('.option-value')
                                    .toArray()
                                    .reduce(function (acc, element) {
                                        const value = $(element).val();

                                        if (value.length < 1) {
                                            return acc;
                                        }

                                        acc.push(value);

                                        return acc;
                                    }, []);

                                if (values.length < 1) {
                                    return acc;
                                }

                                acc.push({
                                    'name': name,
                                    'values': values,
                                });

                                return acc;
                            }, []);
                    }

                    return {
                        getOptions: getOptions,
                    };
                })();
            </script>
            <div class="card" id="variants-module">
                <div class="card-header d-flex align-items-center">
                    <h3 class="card-title">{{ __('Variants') }}</h3>
                </div>
                <div
                    class="card-body p-0"
                    id="variants"
                >
                </div>
                <script id="variant-template" type="text/html">
                    @{{ #variants }}
                    <div class="row align-items-center px-3 py-2 border">
                        <div class="col-lg">
                            <p class="text-bold">#@{{ currentRow }} - @{{ name }}</p>
                        </div>
                        <div class="col-lg">
                            <div class="form-group">
                                <label for="variant-@{{ index }}-price">
                                    <span>{{ __('Price') }}</span>
                                    <span class="text-danger">*</span>
                                </label>
                                <input
                                    type="number"
                                    name="variant[@{{ index }}][price]"
                                    id="variant-@{{ index }}-price"
                                    class="form-control"
                                />
                            </div>
                        </div>
                        <div class="col-lg">
                            <div class="form-group">
                                <label for="variant-@{{ index }}-weight">
                                    <span>{{ __('Weight in gram') }}</span>
                                    <span class="text-danger">*</span>
                                </label>
                                <input
                                    type="number"
                                    name="variant[@{{ index }}][weight]"
                                    id="variant-@{{ index }}-weight"
                                    class="form-control"
                                />
                            </div>
                        </div>
                    </div>
                    @{{ /variants }}
                </script>
            </div>
            <script>
                const Variants = (function () {
                    const template = $('#variant-template').html();
                    let variants = [];

                    // Cache DOM
                    const $el = $('#variants-module');
                    const $variants = $el.find('#variants');

                    _render();

                    function _render() {
                        $variants.html(
                            Mustache.render(template, {
                                variants: variants,
                                currentRow: function () {
                                    return this.index + 1;
                                },
                            })
                        );
                    }

                    function generate() {
                        variants = [];
                        const options = ProductOption.getOptions();

                        if (options.length < 1) {
                            return;
                        }

                        let index = 0;

                        options[0].values.forEach(function (value1) {
                            if (typeof options[1] === 'undefined') {
                                variants.push({
                                    index: index,
                                    name: value1,
                                });
                                index++;
                            } else {
                                options[1].values.forEach(function (value2) {
                                    variants.push({
                                        index: index,
                                        name: [value1, value2].join(' / '),
                                    });
                                    index++;
                                });
                            }
                        });

                        _render();
                    }

                    return {
                        generate: generate,
                    };
                })();
            </script>
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
