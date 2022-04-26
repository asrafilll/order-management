<x-app>
    <x-content-header>
        <div>
            <h1 class="m-0">{{ __('Payment Methods') }}</h1>
        </div>
        <div>
            <a
                href="{{ route('payment-methods.create') }}"
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
                            <th>{{ __('Created At') }}</th>
                            <th>{{ __('Updated At') }}</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($paymentMethods as $paymentMethod)
                            <tr>
                                <td>{{ $paymentMethod->name }}</td>
                                <td>{{ $paymentMethod->created_at->diffForHumans() }}</td>
                                <td>{{ $paymentMethod->updated_at->diffForHumans() }}</td>
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
                                                href="{{ route('payment-methods.edit', $paymentMethod) }}"
                                            >{{ __('Edit') }}</a>
                                            <button
                                                type="button"
                                                class="dropdown-item text-danger"
                                                data-toggle="modal"
                                                data-target="#modal-delete"
                                                data-action="{{ route('payment-methods.destroy', $paymentMethod) }}"
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
                {!! $paymentMethods->withQueryString()->links() !!}
            </div>
        </div>
    </section>
</x-app>
