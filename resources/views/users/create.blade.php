<x-app>
    <x-content-header>
        <h1 class="m-0">{{ __('Create User') }}</h1>
    </x-content-header>

    <section class="content">
        <div class="row">
            <div class="col-lg-6">
                <form
                    id="form-create-user"
                    action="{{ route('users.store') }}"
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
                                <label for="email">
                                    <span>{{ __('Email') }}</span>
                                    <span class="text-danger">*</span>
                                </label>
                                <input
                                    type="email"
                                    id="email"
                                    name="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    value="{{ old('email') }}"
                                />
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="password">
                                    <span>{{ __('Password') }}</span>
                                    <span class="text-danger">*</span>
                                </label>
                                <input
                                    type="password"
                                    id="password"
                                    name="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                >
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="password_confirmation">
                                    <span>{{ __('Password confirmation') }}</span>
                                    <span class="text-danger">*</span>
                                </label>
                                <input
                                    type="password"
                                    id="password_confirmation"
                                    name="password_confirmation"
                                    class="form-control @error('password') is-invalid @enderror"
                                >
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="card-footer">
                            <button
                                type="submit"
                                class="btn btn-primary"
                                id="btn-submit"
                            >{{ __('Save') }}</button>
                            <a
                                href="{{ route('users.index') }}"
                                class="btn btn-default"
                            >{{ __('Back') }}</a>
                        </div>
                    </div>
                </form>
                <script>
                    $(function() {
                        const $formCreateUser = $('#form-create-user');
                        const $btnSubmit = $('#btn-submit');

                        $formCreateUser.on('submit', function() {
                            $btnSubmit.attr('disabled', true);
                        });
                    });
                </script>
            </div>
        </div>
    </section>
</x-app>
