<x-app>
    <x-content-header>
        <h1 class="m-0">{{ __('Edit Payment Method') }}</h1>
    </x-content-header>

    <section class="content">
        <div class="row">
            <div class="col-lg-6">
                <form
                    action="{{ route('payment-methods.update', $paymentMethod) }}"
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
                                    value="{{ old('name') ?? $paymentMethod->name }}"
                                />
                                @error('name')
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
                                href="{{ route('payment-methods.index') }}"
                                class="btn btn-default"
                            >{{ __('Back') }}</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
</x-app>
