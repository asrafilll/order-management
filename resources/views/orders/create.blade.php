<x-app>
    <x-content-header>
        <h1 class="m-0">{{ __('Create Order') }}</h1>
    </x-content-header>

    <section class="content">
        <div class="row">
            <div class="col-lg-6">
                <form
                    action="{{ route('orders.store') }}"
                    method="POST"
                    novalidate
                >
                    @csrf
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{{ __('Source') }}</h3>
                        </div>
                        <div id="source-module" class="card-body">
                            <div class="form-group">
                                <label for="source_name">
                                    <span>{{ __('Name') }}</span>
                                    <span class="text-danger">*</span>
                                </label>
                                <input
                                    type="hidden"
                                    name="source_id"
                                    id="source_id"
                                    value="{{ old('source_id') }}"
                                />
                                <input
                                    type="text"
                                    id="source_name"
                                    name="source_name"
                                    class="form-control @error('source_name') is-invalid @enderror"
                                    value="{{ old('source_name') }}"
                                />
                                @error('source_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <script>
                            const Source = (function () {
                                const $el = $('#source-module');
                                const $id = $el.find('#source_id');
                                const $name = $el.find('#source_name');

                                init();

                                function init() {
                                    $name.autocomplete({
                                        source: function (request, response) {
                                            $.ajax({
                                                method: 'GET',
                                                url: '{{ route('web-api.order-sources.index') }}',
                                                data: {
                                                    q: request.term,
                                                },
                                                success: function (res) {
                                                    response(res.data.map(function (orderSource) {
                                                        return {
                                                            id: orderSource.id,
                                                            label: orderSource.name,
                                                            value: orderSource.name,
                                                        };
                                                    }))
                                                },
                                            });
                                        },
                                        select: function (event, ui) {
                                            $id.val(ui.item.id);
                                        },
                                    });
                                }
                            })();
                        </script>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{{ __('Customer') }}</h3>
                        </div>
                        <div id="customer-module" class="card-body">
                            <div class="form-group">
                                <label for="customer_name">
                                    <span>{{ __('Name') }}</span>
                                    <span class="text-danger">*</span>
                                </label>
                                <input
                                    type="hidden"
                                    name="customer_id"
                                    id="customer_id"
                                    value="{{ old('customer_id') }}"
                                />
                                <input
                                    type="text"
                                    id="customer_name"
                                    name="customer_name"
                                    class="form-control @error('customer_name') is-invalid @enderror"
                                    value="{{ old('customer_name') }}"
                                />
                                @error('customer_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="customer_phone">
                                    <span>{{ __('Phone') }}</span>
                                    <span class="text-danger">*</span>
                                </label>
                                <input
                                    type="text"
                                    id="customer_phone"
                                    name="customer_phone"
                                    class="form-control @error('customer_phone') is-invalid @enderror"
                                    value="{{ old('customer_phone') }}"
                                />
                                @error('customer_phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="customer_address">
                                    <span>{{ __('Address') }}</span>
                                    <span class="text-danger">*</span>
                                </label>
                                <textarea
                                    id="customer_address"
                                    name="customer_address"
                                    class="form-control @error('customer_address') is-invalid @enderror"
                                    rows="2"
                                >{{ old('customer_address') }}</textarea>
                                @error('customer_address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div id="province-module" class="form-group">
                                <label for="customer_province">
                                    <span>{{ __('Province') }}</span>
                                    <span class="text-danger">*</span>
                                </label>
                                <input
                                    type="text"
                                    id="customer_province"
                                    name="customer_province"
                                    class="form-control @error('customer_province') is-invalid @enderror"
                                    value="{{ old('customer_province') }}"
                                />
                                @error('customer_province')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <script>
                                const Province = (function () {
                                    const $el = $('#province-module');
                                    const $input = $el.find('#customer_province');

                                    init();

                                    function init() {
                                        $input.autocomplete({
                                            source: function (request, response) {
                                                $.ajax({
                                                    method: 'GET',
                                                    url: '{{ route('web-api.provinces.index') }}',
                                                    data: {
                                                        q: request.term,
                                                    },
                                                    success: function (res) {
                                                        response(res.data.map(function (province) {
                                                            return {
                                                                code: province.code,
                                                                label: province.name,
                                                                value: province.name,
                                                            };
                                                        }))
                                                    },
                                                });
                                            },
                                            select: function (event, ui) {
                                                City.setProvinceCode(ui.item.code);
                                            }
                                        });
                                    }

                                    function setValue(value) {
                                        $input.removeAttr('disabled');
                                        $input.val(value);
                                    }

                                    return {
                                        setValue: setValue,
                                    };
                                })();
                            </script>
                            <div id ="city-module" class="form-group">
                                <label for="customer_city">
                                    <span>{{ __('City') }}</span>
                                    <span class="text-danger">*</span>
                                </label>
                                <input
                                    type="text"
                                    id="customer_city"
                                    name="customer_city"
                                    class="form-control @error('customer_city') is-invalid @enderror"
                                    value="{{ old('customer_city') }}"
                                    @if(!old('customer_city')) disabled @endif
                                />
                                @error('customer_city')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <script>
                                const City = (function () {
                                    let provinceCode = null;

                                    const $el = $('#city-module');
                                    const $input = $el.find('#customer_city');

                                    init();

                                    function init() {
                                        if (!provinceCode || provinceCode.length < 1) {
                                            return;
                                        }

                                        $input.removeAttr('disabled');

                                        if ($input.autocomplete('instance')) {
                                            $input.autocomplete('destroy');
                                        }

                                        $input.autocomplete({
                                            source: function (request, response) {
                                                $.ajax({
                                                    method: 'GET',
                                                    url: '{{ route('web-api.cities.index') }}',
                                                    data: {
                                                        q: request.term,
                                                        province_code: provinceCode,
                                                    },
                                                    success: function (res) {
                                                        response(res.data.map(function (city) {
                                                            return {
                                                                code: city.code,
                                                                label: city.name,
                                                                value: city.name,
                                                            };
                                                        }))
                                                    },
                                                });
                                            },
                                            select: function (event, ui) {
                                                Subdistrict.setCityCode(ui.item.code);
                                            }
                                        });
                                    }

                                    function setProvinceCode(newProvinceCode) {
                                        provinceCode = newProvinceCode;
                                        $input.val(null);
                                        $input.attr('disabled', true);
                                        Subdistrict.setCityCode(null);
                                        init();
                                    }

                                    function setValue(value) {
                                        $input.removeAttr('disabled');
                                        $input.val(value);
                                    }

                                    return {
                                        setProvinceCode: setProvinceCode,
                                        setValue: setValue,
                                    };
                                })();
                            </script>
                            <div id="subdistrict-module" class="form-group">
                                <label for="customer_subdistrict">
                                    <span>{{ __('Subdistrict') }}</span>
                                    <span class="text-danger">*</span>
                                </label>
                                <input
                                    type="text"
                                    id="customer_subdistrict"
                                    name="customer_subdistrict"
                                    class="form-control @error('customer_subdistrict') is-invalid @enderror"
                                    value="{{ old('customer_subdistrict') }}"
                                    @if(!old('customer_subdistrict')) disabled @endif
                                />
                                @error('customer_subdistrict')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <script>
                                const Subdistrict = (function () {
                                    let cityCode = null;

                                    const $el = $('#subdistrict-module');
                                    const $input = $el.find('#customer_subdistrict');

                                    init();

                                    function init() {
                                        if (!cityCode || cityCode.length < 1) {
                                            return;
                                        }

                                        $input.removeAttr('disabled');

                                        if ($input.autocomplete('instance')) {
                                            $input.autocomplete('destroy');
                                        }

                                        $input.autocomplete({
                                            source: function (request, response) {
                                                $.ajax({
                                                    method: 'GET',
                                                    url: '{{ route('web-api.subdistricts.index') }}',
                                                    data: {
                                                        q: request.term,
                                                        city_code: cityCode,
                                                    },
                                                    success: function (res) {
                                                        response(res.data.map(function (subdistrict) {
                                                            return {
                                                                code: subdistrict.code,
                                                                label: subdistrict.name,
                                                                value: subdistrict.name,
                                                            };
                                                        }))
                                                    },
                                                });
                                            },
                                            select: function (event, ui) {
                                                Village.setSubdistrictCode(ui.item.code);
                                            }
                                        });
                                    }

                                    function setCityCode(newCityCode) {
                                        cityCode = newCityCode;
                                        $input.val(null);
                                        $input.attr('disabled', true);
                                        Village.setSubdistrictCode(null);
                                        init();
                                    }

                                    function setValue(value) {
                                        $input.removeAttr('disabled');
                                        $input.val(value);
                                    }

                                    return {
                                        setCityCode: setCityCode,
                                        setValue: setValue,
                                    };
                                })();
                            </script>
                            <div id="village-module" class="form-group">
                                <label for="customer_village">
                                    <span>{{ __('Village') }}</span>
                                    <span class="text-danger">*</span>
                                </label>
                                <input
                                    type="text"
                                    id="customer_village"
                                    name="customer_village"
                                    class="form-control @error('customer_village') is-invalid @enderror"
                                    value="{{ old('customer_village') }}"
                                    @if(!old('customer_village')) disabled @endif
                                />
                                @error('customer_village')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <script>
                                const Village = (function () {
                                    let subdistrictCode = null;

                                    const $el = $('#village-module');
                                    const $input = $el.find('#customer_village');

                                    init();

                                    function init() {
                                        if (!subdistrictCode || subdistrictCode.length < 1) {
                                            return;
                                        }

                                        $input.removeAttr('disabled');

                                        if ($input.autocomplete('instance')) {
                                            $input.autocomplete('destroy');
                                        }

                                        $input.autocomplete({
                                            source: function (request, response) {
                                                $.ajax({
                                                    method: 'GET',
                                                    url: '{{ route('web-api.villages.index') }}',
                                                    data: {
                                                        q: request.term,
                                                        subdistrict_code: subdistrictCode,
                                                    },
                                                    success: function (res) {
                                                        response(res.data.map(function (village) {
                                                            return {
                                                                id: village.code,
                                                                label: village.name,
                                                                value: village.name,
                                                            };
                                                        }))
                                                    },
                                                });
                                            },
                                        });
                                    }

                                    function setSubdistrictCode(newSubdistrictCode) {
                                        subdistrictCode = newSubdistrictCode;
                                        $input.val(null);
                                        $input.attr('disabled', true);
                                        init();
                                    }

                                    function setValue(value) {
                                        $input.removeAttr('disabled');
                                        $input.val(value);
                                    }

                                    return {
                                        setSubdistrictCode: setSubdistrictCode,
                                        setValue: setValue,
                                    };
                                })();
                            </script>
                            <div class="form-group">
                                <label for="customer_postal_code">
                                    <span>{{ __('Postal Code') }}</span>
                                    <span class="text-danger">*</span>
                                </label>
                                <input
                                    type="number"
                                    id="customer_postal_code"
                                    name="customer_postal_code"
                                    class="form-control @error('customer_postal_code') is-invalid @enderror"
                                    value="{{ old('customer_postal_code') }}"
                                />
                                @error('customer_postal_code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <script>
                            const Customer = (function () {
                                const $el = $('#customer-module');
                                const $id = $el.find('#customer_id');
                                const $name = $el.find('#customer_name');
                                const $phone = $el.find('#customer_phone');
                                const $address = $el.find('#customer_address');
                                const $postalCode = $el.find('#customer_postal_code');

                                init();

                                function init() {
                                    $name.autocomplete({
                                        source: function (request, response) {
                                            $.ajax({
                                                method: 'GET',
                                                url: '{{ route('web-api.customers.index') }}',
                                                data: {
                                                    q: request.term,
                                                },
                                                success: function (res) {
                                                    response(res.data.map(function (customer) {
                                                        return {
                                                            label: customer.name,
                                                            value: customer.name,
                                                            customer: customer,
                                                        };
                                                    }))
                                                },
                                            });
                                        },
                                        select: function (event, ui) {
                                            const customer = ui.item.customer;
                                            $id.val(customer.id);
                                            $phone.val(customer.phone);
                                            $address.val(customer.address);
                                            $postalCode.val(customer.postal_code);
                                            Province.setValue(customer.province);
                                            City.setValue(customer.city);
                                            Subdistrict.setValue(customer.subdistrict);
                                            Village.setValue(customer.village);
                                        },
                                    });
                                }
                            })();
                        </script>
                    </div>
                    <div class="card">
                        <div class="card-footer">
                            <button
                                type="submit"
                                class="btn btn-primary"
                            >{{ __('Save') }}</button>
                            <a
                                href="{{ route('orders.index') }}"
                                class="btn btn-default"
                            >{{ __('Back') }}</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
</x-app>
