<x-app>
    <x-content-header>
        <h1 class="m-0">{{ __('Edit Customer') }}</h1>
    </x-content-header>

    <section class="content">
        <div class="row">
            <div class="col-lg-6">
                <form
                    action="{{ route('customers.update', $customer) }}"
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
                                    value="{{ old('name') ?? $customer->name }}"
                                />
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="phone">
                                    <span>{{ __('Phone') }}</span>
                                    <span class="text-danger">*</span>
                                </label>
                                <input
                                    type="text"
                                    id="phone"
                                    name="phone"
                                    class="form-control @error('phone') is-invalid @enderror"
                                    value="{{ old('phone') ?? $customer->phone }}"
                                />
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="address">
                                    <span>{{ __('Address') }}</span>
                                    <span class="text-danger">*</span>
                                </label>
                                <textarea
                                    id="address"
                                    name="address"
                                    class="form-control @error('address') is-invalid @enderror"
                                    rows="2"
                                >{{ old('address') ?? $customer->address }}</textarea>
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div id="province-module" class="form-group">
                                <label for="province">
                                    <span>{{ __('Province') }}</span>
                                    <span class="text-danger">*</span>
                                </label>
                                <input
                                    type="text"
                                    id="province"
                                    name="province"
                                    class="form-control @error('province') is-invalid @enderror"
                                    value="{{ old('province') ?? $customer->province }}"
                                />
                                @error('province')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <script>
                                const Province = (function () {
                                    const $el = $('#province-module');
                                    const $input = $el.find('#province');

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
                                })();
                            </script>
                            <div id="city-module" class="form-group">
                                <label for="city">
                                    <span>{{ __('City') }}</span>
                                    <span class="text-danger">*</span>
                                </label>
                                <input
                                    type="text"
                                    id="city"
                                    name="city"
                                    class="form-control @error('city') is-invalid @enderror"
                                    value="{{ old('city') ?? $customer->city }}"
                                />
                                @error('city')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <script>
                                const City = (function () {
                                    let provinceCode = null;

                                    const $el = $('#city-module');
                                    const $input = $el.find('#city');

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

                                    return {
                                        setProvinceCode: setProvinceCode,
                                    };
                                })();
                            </script>
                            <div id="subdistrict-module" class="form-group">
                                <label for="subdistrict">
                                    <span>{{ __('Subdistrict') }}</span>
                                    <span class="text-danger">*</span>
                                </label>
                                <input
                                    type="text"
                                    id="subdistrict"
                                    name="subdistrict"
                                    class="form-control @error('subdistrict') is-invalid @enderror"
                                    value="{{ old('subdistrict') ?? $customer->subdistrict }}"
                                />
                                @error('subdistrict')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <script>
                                const Subdistrict = (function () {
                                    let cityCode = null;

                                    const $el = $('#subdistrict-module');
                                    const $input = $el.find('#subdistrict');

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

                                    return {
                                        setCityCode: setCityCode,
                                    };
                                })();
                            </script>
                            <div id="village-module" class="form-group">
                                <label for="village">
                                    <span>{{ __('Village') }}</span>
                                    <span class="text-danger">*</span>
                                </label>
                                <input
                                    type="text"
                                    id="village"
                                    name="village"
                                    class="form-control @error('village') is-invalid @enderror"
                                    value="{{ old('village') ?? $customer->village }}"
                                />
                                @error('village')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <script>
                                const Village = (function () {
                                    let subdistrictCode = null;

                                    const $el = $('#village-module');
                                    const $input = $el.find('#village');

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

                                    return {
                                        setSubdistrictCode: setSubdistrictCode,
                                    };
                                })();
                            </script>
                            <div class="form-group">
                                <label for="postal_code">
                                    <span>{{ __('Postal Code') }}</span>
                                </label>
                                <input
                                    type="number"
                                    id="postal_code"
                                    name="postal_code"
                                    class="form-control @error('postal_code') is-invalid @enderror"
                                    value="{{ old('postal_code') ?? $customer->postal_code }}"
                                />
                                @error('postal_code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="card-footer">
                            <button
                                type="submit"
                                class="btn btn-primary"
                            >{{ __('Save') }}</button>
                            <a
                                href="{{ route('customers.index') }}"
                                class="btn btn-default"
                            >{{ __('Back') }}</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
</x-app>
