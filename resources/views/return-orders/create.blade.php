<x-app>
    <x-content-header>
        <h1 class="m-0">{{ __('Create Return') }}</h1>
    </x-content-header>

    <section class="content">
        <div class="row">
            <div class="col-lg-6">
                <form
                    action="{{ route('return-orders.store') }}"
                    method="POST"
                    novalidate
                >
                    @csrf
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="order_id">
                                    <span>{{ __('Order ID') }}</span>
                                    <span class="text-danger">*</span>
                                </label>
                                <input
                                    type="text"
                                    id="order_id"
                                    name="order_id"
                                    class="form-control @error('order_id') is-invalid @enderror"
                                    value="{{ old('order_id') }}"
                                />
                                @error('order_id')
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
                                href="{{ route('return-orders.index') }}"
                                class="btn btn-default"
                            >{{ __('Back') }}</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
</x-app>
