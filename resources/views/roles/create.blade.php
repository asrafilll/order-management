<x-app>
    <x-content-header>
        <h1 class="m-0">{{ __('Create Role') }}</h1>
    </x-content-header>

    <section class="content">
        <div class="row">
            <div class="col-lg-6">
                <form
                    action="{{ route('roles.store') }}"
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
                                <label>{{ __('Permissions') }}</label>
                                @foreach ($permissions as $permission)
                                    <div class="icheck-primary">
                                        <input
                                            type="checkbox"
                                            id="permission{{ $permission->id }}"
                                            name="permissions[]"
                                            value="{{ $permission->id }}"
                                        >
                                        <label for="permission{{ $permission->id }}">
                                            {{ Str::title(__($permission->name)) }}
                                        </label>
                                    </div>
                                @endforeach
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
