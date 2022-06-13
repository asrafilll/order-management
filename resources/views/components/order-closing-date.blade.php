@props(['order'])

<div>
    <form
        action="{{ route('orders.closing-date.update', $order) }}"
        method="POST"
    >
        @csrf
        @method('PUT')
        <div class="card">
            <div class="card-header">{{ __('Closing Date') }}</div>
            <div class="card-body">
                <input
                    type="date"
                    name="closing_date"
                    id="closing_date"
                    class="form-control"
                    value="{{ $order->closing_date }}"
                />
            </div>
            <div class="card-footer">
                <button
                    type="submit"
                    class="btn btn-primary"
                >{{ __('Save') }}</button>
            </div>
        </div>
    </form>
</div>
