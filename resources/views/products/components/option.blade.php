@php
$index = $index ?? 0;
@endphp

<div class="option-wrapper px-3 py-2 border">
    <div class="form-group row align-items-end">
        <div class="col">
            <label for="options-{{ $index }}-name">
                <span>{{ __('Option Name') }}</span>
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
        <div class="col-auto">
            <button
                type="button"
                class="btn btn-default btn-delete-option"
                tabindex="-1"
                @if ($index < 1) disabled @endif
            >
                <i class="fas fa-trash-alt"></i>
            </button>
        </div>
    </div>
    <div class="form-group">
        <label>
            <span>{{ __('Values') }}</span>
            <span class="text-danger">*</span>
        </label>
        <div class="option-values-wrapper">
            <div class="row option-value-wrapper mb-1">
                <div class="col">
                    <input
                        type="text"
                        name="options[{{ $index }}][values]"
                        class="form-control option-value"
                        placeholder="{{ __('Add another value') }}"
                    />
                </div>
                <div class="col-auto">
                    <button
                        type="button"
                        class="btn btn-default btn-delete-option-value"
                        tabindex="-1"
                        disabled
                    >
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
