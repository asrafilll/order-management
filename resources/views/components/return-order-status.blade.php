@props(['returnOrderStatuses', 'returnOrder'])

<div class="card">
    <div class="card-header">{{ __('Status') }}</div>
    <div class="card-body">
        <select
            name="status"
            id="status"
            class="form-control @error('status') is-invalid @enderror"
        >
            @foreach ($returnOrderStatuses as $returnOrderStatus)
                <option
                    value="{{ $returnOrderStatus }}"
                    @if (old('status') == $returnOrderStatus || $returnOrder->status == $returnOrderStatus) selected @endif
                >{{ __(Str::upper($returnOrderStatus)) }}</option>
            @endforeach
        </select>
    </div>
    <div class="card-footer">
        <button
            type="submit"
            class="btn btn-primary"
        >{{ __('Save') }}</button>
    </div>
</div>
