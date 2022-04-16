@php
    $index = $index ?? 0;
@endphp

<div class="option-wrapper">
    <div class="form-group row align-items-end">
        <div class="col">
            <label for="options-{{ $index }}-name">
                <span>{{ __('Option :name Name', ['name' => $index + 1]) }}</span>
                <span class="text-danger">*</span>
            </label>
            <input
                type="text"
                name="options[{{ $index }}][name]"
                id="options-{{ $index }}-name"
                class="form-control @error('options[{{ $index }}][name]') is-invalid @enderror"
                placeholder="eg: Color or Size"
            />
            @error('options[{{ $index }}][name]')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        @if ($index > 0)
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
        <label for="options-{{ $index }}-values">
            <span>{{ __('Values') }}</span>
            <span class="text-danger">*</span>
        </label>
        <input
            type="text"
            name="options[{{ $index }}][values]"
            id="options-{{ $index }}-values"
            class="form-control values @error('options[{{ $index }}][values]') is-invalid @enderror"
            placeholder="eg: Red|Green|Blue or Small|Medium|Large"
        />
        <small>{{ __('Separate value with | (pipe) symbol.') }}</small>
        @error('options[{{ $index }}][values]')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
