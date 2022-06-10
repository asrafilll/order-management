@props(['order'])

<form
    action="{{ route('orders.note.update', $order) }}"
    method="POST"
>
    @csrf
    @method('PUT')
    <div class="card">
        <div class="card-header">{{ __('Note') }}</div>
        <div class="card-body">
            <input
                type="text"
                name="note"
                id="note"
                class="form-control"
                value="{{ $order->note }}"
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
