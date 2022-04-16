@foreach ($variants as $i => $variant)
    <div>
        <p class="text-bold">#{{ $i + 1 }} {{ $variant }}</p>
        <div class="row">
            <div class="col-lg form-group">
                <label for="variants[{{ $i }}][price]">
                    <span>{{ __('Price') }}</span>
                    <span class="text-danger">*</span>
                </label>
                <input
                    type="number"
                    id="variants[{{ $i }}][price]"
                    name="variants[{{ $i }}][price]"
                    class="form-control"
                />
            </div>
            <div class="col-lg form-group">
                <label for="variants[{{ $i }}][weight]">
                    <span>{{ __('Weight') }}</span>
                    <span class="text-danger">*</span>
                </label>
                <input
                    type="number"
                    id="variants[{{ $i }}][weight]"
                    name="variants[{{ $i }}][weight]"
                    class="form-control"
                />
            </div>
        </div>
    </div>
@endforeach
