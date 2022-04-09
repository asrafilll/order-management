<x-app>
    <x-content-header>
        <h1 class="m-0">{{ __('Edit User') }}</h1>
    </x-content-header>

    <section class="content">
        <div class="row">
            <div class="col-lg-6">
                <form
                    action="{{ route('users.update', $user) }}"
                    method="POST"
                    novalidate
                >
                    @csrf
                    @method('PUT')
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{{ __('Information') }}</h3>
                        </div>
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
                                    value="{{ old('name') ?? $user->name }}"
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
                                    value="{{ old('email') ?? $user->email }}"
                                />
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="role">
                                    <span>{{ __('Role') }}</span>
                                    <span class="text-danger">*</span>
                                </label>
                                <select
                                    name="role"
                                    id="role"
                                    class="form-control @error('role') is-invalid @enderror"
                                >
                                    <option
                                        value=""
                                        hidden
                                    ></option>
                                    @foreach ($roles as $role)
                                        <option
                                            value="{{ $role->id }}"
                                            @if (old('role') == $role->id || $user->role->id == $role->id) selected @endif
                                        >
                                            {{ Str::title(__($role->name)) }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('role')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                        </div>
                        <div class="card-footer">
                            <button
                                type="submit"
                                class="btn btn-primary"
                            >{{ __('Save') }}</button>
                            <a
                                href="{{ route('users.index') }}"
                                class="btn btn-default"
                            >{{ __('Back') }}</a>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-lg-6">
                <form
                    action="{{ route('users.update.password', $user) }}"
                    method="POST"
                    novalidate
                >
                    @csrf
                    @method('PUT')
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{{ __('Password') }}</h3>
                        </div>
                        <div class="card-body">
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
                            >{{ __('Save') }}</button>
                            <a
                                href="{{ route('users.index') }}"
                                class="btn btn-default"
                            >{{ __('Back') }}</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
</x-app>
