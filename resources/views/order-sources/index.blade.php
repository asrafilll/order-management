<x-app>
    <x-content-header>
        <div>
            <h1 class="m-0">{{ __('Order Sources') }}</h1>
        </div>
        <div>
            <a
                href="{{ route('order-sources.create') }}"
                class="btn btn-primary"
            >{{ __('Create') }}</a>
        </div>
    </x-content-header>

    <section class="content">
        <div class="card">
            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th>{{ __('Name') }}</th>
                            <th>{{ __('Parent') }}</th>
                            <th>{{ __('Created At') }}</th>
                            <th>{{ __('Updated At') }}</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($orderSources as $orderSource)
                            <tr>
                                <td>{{ $orderSource->name }}</td>
                                <td>{{ $orderSource->parent_name ?? '-' }}</td>
                                <td>{{ $orderSource->created_at->diffForHumans() }}</td>
                                <td>{{ $orderSource->updated_at->diffForHumans() }}</td>
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
                                                href="{{ route('order-sources.edit', $orderSource) }}"
                                            >{{ __('Edit') }}</a>
                                            <button
                                                type="button"
                                                class="dropdown-item text-danger"
                                                data-toggle="modal"
                                                data-target="#modal-delete"
                                                data-action="{{ route('order-sources.destroy', $orderSource) }}"
                                            >{{ __('Delete') }}</button>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td
                                    colspan="4"
                                    class="text-center"
                                >{{ __('Data not found') }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer d-flex justify-content-end">
                {!! $orderSources->withQueryString()->links() !!}
            </div>
        </div>
    </section>
</x-app>
