<x-app>
    <x-content-header>
        <div>
            <h1 class="m-0">Users</h1>
        </div>
        <div>
            <a
                href="#"
                class="btn btn-primary"
            >{{ __('Create') }}</a>
        </div>
    </x-content-header>

    <!-- Main content -->
    <section class="content">
        <div class="card">
            <div class="card-header">
                <div class="input-group">
                    <input
                        type="text"
                        name="table_search"
                        class="form-control"
                        placeholder="Search"
                    >

                    <div class="input-group-append">
                        <button
                            type="submit"
                            class="btn btn-default"
                        >
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th>{{ __('Name') }}</th>
                            <th>{{ __('Email') }}</th>
                            <th>{{ __('Created At') }}</th>
                            <th>{{ __('Updated At') }}</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->created_at->diffForHumans() }}</td>
                                <td>{{ $user->updated_at->diffForHumans() }}</td>
                                <td class="text-right">
                                    <div class="dropdown">
                                        <button
                                            class="btn btn-light"
                                            type="button"
                                            data-toggle="dropdown"
                                        >
                                            <i class="fas fa-ellipsis-v"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a
                                                class="dropdown-item"
                                                href="#"
                                            >{{ __('Edit') }}</a>
                                            <a
                                                class="dropdown-item text-danger"
                                                href="#"
                                            >{{ __('Delete') }}</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td
                                    colspan="5"
                                    class="text-center"
                                >{{ __('Data not found') }}</td>
                            </tr>
                        @endforelse
                        <tr>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="card-footer d-flex justify-content-end">
                {!! $users->withQueryString()->links() !!}
            </div>
        </div>
    </section>
    <!-- /.content -->
</x-app>
