<x-app>
    <x-content-header>
        <h1 class="m-0">{{ __('Create Customer') }}</h1>
    </x-content-header>

    <section class="content">
        <div class="row">
            <div class="col-lg-6">
                <form
                    action="{{ route('customers.store') }}"
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
                                <label for="phone">
                                    <span>{{ __('Phone') }}</span>
                                    <span class="text-danger">*</span>
                                </label>
                                <input
                                    type="text"
                                    id="phone"
                                    name="phone"
                                    class="form-control @error('phone') is-invalid @enderror"
                                    value="{{ old('phone') }}"
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
                                >{{ old('address') }}</textarea>
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="province">
                                    <span>{{ __('Province') }}</span>
                                    <span class="text-danger">*</span>
                                </label>
                                <input
                                    type="text"
                                    id="province"
                                    name="province"
                                    class="form-control @error('province') is-invalid @enderror"
                                    value="{{ old('province') }}"
                                />
                                @error('province')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="city">
                                    <span>{{ __('City') }}</span>
                                    <span class="text-danger">*</span>
                                </label>
                                <input
                                    type="text"
                                    id="city"
                                    name="city"
                                    class="form-control @error('city') is-invalid @enderror"
                                    value="{{ old('city') }}"
                                />
                                @error('city')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="subdistrict">
                                    <span>{{ __('Subdistrict') }}</span>
                                    <span class="text-danger">*</span>
                                </label>
                                <input
                                    type="text"
                                    id="subdistrict"
                                    name="subdistrict"
                                    class="form-control @error('subdistrict') is-invalid @enderror"
                                    value="{{ old('subdistrict') }}"
                                />
                                @error('subdistrict')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="village">
                                    <span>{{ __('Village') }}</span>
                                    <span class="text-danger">*</span>
                                </label>
                                <input
                                    type="text"
                                    id="village"
                                    name="village"
                                    class="form-control @error('village') is-invalid @enderror"
                                    value="{{ old('village') }}"
                                />
                                @error('village')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="postal_code">
                                    <span>{{ __('Postal Code') }}</span>
                                    <span class="text-danger">*</span>
                                </label>
                                <input
                                    type="number"
                                    id="postal_code"
                                    name="postal_code"
                                    class="form-control @error('postal_code') is-invalid @enderror"
                                    value="{{ old('postal_code') }}"
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
