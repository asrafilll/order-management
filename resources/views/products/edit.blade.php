<x-app>
    <x-content-header>
        <h1 class="m-0">{{ __('Edit Product') }}</h1>
    </x-content-header>

    <section class="content">
        @if($errors->any())
            <div class="alert alert-danger">
                <h5>
                    <i class="icon fas fa-ban"></i>
                    <span>{{ __('The given data is invalid.') }}</span>
                </h5>
                <ul>
                    @foreach ($errors->all() as $message)
                        <li>{{ $message }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form
            action="{{ route('products.update', $product) }}"
            method="POST"
            novalidate
        >
            @csrf
            @method('PUT')
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
                            value="{{ old('name') ?? $product->name }}"
                        />
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="description">
                            <span>{{ __('Description') }}</span>
                        </label>
                        <textarea
                            name="description"
                            id="description"
                            rows="4"
                            class="form-control"
                        >{{ old('description') ?? $product->description }}</textarea>
                    </div>
                </div>
            </div>
            <div id="product-option-module">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{ __('Options') }}</h3>
                    </div>
                    <div class="card-body p-0">
                        <div id="options">
                            @php
                                $option1 = $product->options->first();
                            @endphp
                            <div class="option-wrapper px-3 py-2 border">
                                <div class="form-group">
                                    <label for="options.0.name">
                                        <span>{{ __('Option :number Name', ['number' => 1]) }}</span>
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input
                                        type="text"
                                        name="options[0][name]"
                                        id="options.0.name"
                                        class="form-control option-name @error('options.0.name') is-invalid @enderror"
                                        placeholder="eg: Color"
                                        value="{{ old('options')[0]['name'] ?? $option1->name ?? '' }}"
                                    />
                                    @error('options.0.name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>
                                        <span>{{ __('Values') }}</span>
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="option-values-wrapper">
                                        @if (isset(old('options')[0]['values']) || !is_null($option1))
                                            @php
                                                $values1 = isset(old('options')[0]['values'])
                                                    ? old('options')[0]['values']
                                                    : json_decode($option1->values);
                                            @endphp
                                            @foreach ($values1 as $value)
                                                <div class="row option-value-wrapper mb-1">
                                                    <div class="col">
                                                        <input
                                                            type="text"
                                                            name="options[0][values][]"
                                                            class="form-control option-value"
                                                            placeholder="{{ __('Add another value') }}"
                                                            value="{{ $value }}"
                                                        />
                                                    </div>
                                                    <div class="col-auto">
                                                        <button
                                                            type="button"
                                                            class="btn btn-default btn-delete-option-value"
                                                            tabindex="-1"
                                                            @if(is_null($value)) disabled @endif
                                                        >
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            <div class="row option-value-wrapper mb-1">
                                                <div class="col">
                                                    <input
                                                        type="text"
                                                        name="options[0][values][]"
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
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @php
                                $option2 = !is_null($option1) ? $product->options->where('id', '!=', $option1->id)->first() : null;
                            @endphp
                            <div class="option-wrapper px-3 py-2 border">
                                <div class="form-group">
                                    <label for="options.1.name">
                                        <span>{{ __('Option :number Name', ['number' => 2]) }}</span>
                                    </label>
                                    <input
                                        type="text"
                                        name="options[1][name]"
                                        id="options.1.name"
                                        class="form-control option-name @error('options.1.name') is-invalid @enderror"
                                        placeholder="eg: Size"
                                        value="{{ old('options')[1]['name'] ?? $option2->name ?? '' }}"
                                    />
                                    @error('options.1.name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>
                                        <span>{{ __('Values') }}</span>
                                    </label>
                                    <div class="option-values-wrapper">
                                        @if (isset(old('options')[1]['values']) || !is_null($option2))
                                            @php
                                                $values2 = isset(old('options')[1]['values'])
                                                    ? old('options')[1]['values']
                                                    : json_decode($option2->values);
                                            @endphp
                                            @foreach ($values2 as $value)
                                                <div class="row option-value-wrapper mb-1">
                                                    <div class="col">
                                                        <input
                                                            type="text"
                                                            name="options[1][values][]"
                                                            class="form-control option-value"
                                                            placeholder="{{ __('Add another value') }}"
                                                            value="{{ $value }}"
                                                        />
                                                    </div>
                                                    <div class="col-auto">
                                                        <button
                                                            type="button"
                                                            class="btn btn-default btn-delete-option-value"
                                                            tabindex="-1"
                                                            @if(is_null($value)) disabled @endif
                                                        >
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            <div class="row option-value-wrapper mb-1">
                                                <div class="col">
                                                    <input
                                                        type="text"
                                                        name="options[1][values][]"
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
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <script>
                const ProductOption = (function () {
                    const MIN_OPTION_VALUES_LENGTH = 2;
                    const template = $('#option-template').html();

                    // Cache DOM
                    const $el = $('#product-option-module');

                    // Bind events
                    $(document).on('keyup', '.option-value', _addOptionValueHandler);
                    $(document).on('click', '.btn-delete-option-value', _deleteOptionValueHandler);

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

                        Swal.fire({
                            title: '{{ __('Are you sure want to delete? Variants with this option value will be deleted. This can\'t be undone.') }}',
                            showCancelButton: true,
                            confirmButtonText: '{{ __('Yes') }}',
                        }).then(function (result) {
                            if (result.isConfirmed) {
                                $optionValueWrapper.remove();

                                _toggleOptionValueDelete($optionValuesWrapper);
                                Variants.generate();
                            }
                        });
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
                            <input type="hidden" name="variants[@{{ index }}][name]" value="@{{ name }}">
                            <input type="hidden" name="variants[@{{ index }}][option1]" value="@{{ option1 }}">
                            <input type="hidden" name="variants[@{{ index }}][value1]" value="@{{ value1 }}">
                            <input type="hidden" name="variants[@{{ index }}][option2]" value="@{{ option2 }}">
                            <input type="hidden" name="variants[@{{ index }}][value2]" value="@{{ value2 }}">
                        </div>
                        <div class="col-lg">
                            <div class="form-group">
                                <label for="variant-@{{ index }}-price">
                                    <span>{{ __('Price') }}</span>
                                    <span class="text-danger">*</span>
                                </label>
                                <input
                                    type="number"
                                    name="variants[@{{ index }}][price]"
                                    id="variant-@{{ index }}-price"
                                    class="form-control"
                                    value="@{{ price }}"
                                />
                            </div>
                        </div>
                        <div class="col-lg">
                            <div class="form-group">
                                <label for="variant-@{{ index }}-weight">
                                    <span>{{ __('Weight') }} (gram)</span>
                                    <span class="text-danger">*</span>
                                </label>
                                <input
                                    type="number"
                                    name="variants[@{{ index }}][weight]"
                                    id="variant-@{{ index }}-weight"
                                    class="form-control"
                                    value="@{{ weight }}"
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

                    generate();

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
                        const existingVariants = @json($product->variants).map(function (variant, index) {
                            variant['index'] = index;
                            return variant;
                        });
                        const options = ProductOption.getOptions();

                        if (options.length < 1) {
                            return;
                        }

                        generatedVariants = [];

                        let index = 0;

                        options[0].values.forEach(function (value1) {
                            if (typeof options[1] === 'undefined') {
                                const name = value1;
                                const variantExists = existingVariants.find(function (existingVariant) {
                                    return existingVariant.name === name;
                                });

                                generatedVariants.push(variantExists ?? {
                                    index: index,
                                    name: value1,
                                    option1: options[0].name,
                                    value1: value1,
                                    option2: null,
                                    value2: null,
                                });
                                index++;
                            } else {
                                options[1].values.forEach(function (value2) {
                                    const name = [value1, value2].join(' / ');
                                    const variantExists = existingVariants.find(function (existingVariant) {
                                        return existingVariant.name === name;
                                    });

                                    generatedVariants.push(variantExists ?? {
                                        index: index,
                                        name: name,
                                        option1: options[0].name,
                                        value1: value1,
                                        option2: options[1].name,
                                        value2: value2,
                                    });
                                    index++;
                                });
                            }
                        });

                        variants = generatedVariants;

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
                                    @if (old('status') == $status || $product->status == $status) selected @endif
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
