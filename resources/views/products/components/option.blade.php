<div class="option-wrapper">
    <div class="form-group row align-items-end">
        <div class="col">
            <label for="option{{ $index }}">
                <span>{{ __('Option ' . $index . ' Name') }}</span>
                <span class="text-danger">*</span>
            </label>
            <input
                type="text"
                name="option{{ $index }}"
                id="option{{ $index }}"
                class="form-control option @error('option{{ $index }}') is-invalid @enderror"
                placeholder="eg: Color or Size"
            />
            @error('option{{ $index }}')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        @if ($index > 1)
            <div class="col-auto">
                <button
                    type="button"
                    class="btn btn-default btn-delete-option"
                >
                    <i class="fas fa-trash-alt"></i>
                </button>
            </div>
        @endif
    </div>
    <div class="form-group">
        <label for="values{{ $index }}">
            <span>{{ __('Values') }}</span>
            <span class="text-danger">*</span>
        </label>
        <input
            type="text"
            name="values{{ $index }}"
            id="values{{ $index }}"
            class="form-control values @error('values{{ $index }}') is-invalid @enderror"
            placeholder="eg: Red|Green|Blue or Small|Medium|Large"
        />
        <small>{{ __('Separate value with | (pipe) symbol.') }}</small>
        @error('values{{ $index }}')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
