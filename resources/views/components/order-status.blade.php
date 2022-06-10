@props(['order', 'orderStatuses'])

<form
    action="{{ route('orders.status.update', $order) }}"
    method="POST"
>
    @csrf
    @method('PUT')
    <div class="card">
        <div class="card-header">{{ __('Status') }}</div>
        @if (count($orderStatuses))
            <div class="card-body">
                <select
                    name="status"
                    id="status"
                    class="form-control @error('status') is-invalid @enderror"
                >
                    @foreach ($orderStatuses as $orderStatus)
                        <option
                            value="{{ $orderStatus }}"
                            @if (old('status') == $orderStatus || $order->status == $orderStatus) selected @endif
                        >{{ __(Str::upper($orderStatus)) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="card-footer">
                <button
                    type="submit"
                    class="btn btn-primary"
                >{{ __('Save') }}</button>
            </div>
        @else
            <div class="card-body">
                <div>{{ __(Str::upper($order->status)) }}</div>
            </div>
        @endif
    </div>
</form>
