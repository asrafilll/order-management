<x-app>
    <x-content-header>
        <div>
            <h1 class="m-0">{{ __('Products') }}</h1>
        </div>
        <div>
            <a
                href="{{ route('products.create') }}"
                class="btn btn-primary"
            >{{ __('Create') }}</a>
        </div>
    </x-content-header>

    <section class="content">
        <div class="card">
            <div class="card-header">
                <form
                    action=""
                    metho="GET"
                >
                    <div class="input-group">
                        <input
                            type="text"
                            name="search"
                            class="form-control"
                            placeholder="Search here"
                            value="{{ Request::get('search') }}"
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
                </form>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th>{{ __('Name') }}</th>
                            <th>{{ __('Status') }}</th>
                            <th>{{ __('Created At') }}</th>
                            <th>{{ __('Updated At') }}</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($products as $product)
                            <tr>
                                <td>{{ $product->name }}</td>
                                <td>{{ Str::upper($product->status) }}</td>
                                <td>{{ $product->created_at->diffForHumans() }}</td>
                                <td>{{ $product->updated_at->diffForHumans() }}</td>
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
                                                href="{{ route('products.edit', $product) }}"
                                            >{{ __('Edit') }}</a>
                                            <button
                                                type="button"
                                                class="dropdown-item text-danger"
                                                data-toggle="modal"
                                                data-target="#modal-delete"
                                                data-action="{{ route('products.destroy', $product) }}"
                                            >{{ __('Delete') }}</button>
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
                    </tbody>
                </table>
            </div>
            <div class="card-footer d-flex justify-content-end">
                {!! $products->withQueryString()->links() !!}
            </div>
        </div>
    </section>
</x-app>
