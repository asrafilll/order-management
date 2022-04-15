@foreach ($variants as $i => $variant)
    <div>
        <p class="text-bold">#{{ $i + 1 }} {{ $variant }}</p>
        <div class="row">
            <div class="col-lg form-group">
                <label for="variant[{{ $i }}]_price">
                    <span>{{ __('Price') }}</span>
                    <span class="text-danger">*</span>
                </label>
                <input
                    type="number"
                    id="variant[{{ $i }}]_price"
                    name="variant[{{ $i }}]_price"
                    class="form-control"
                />
            </div>
            <div class="col-lg form-group">
                <label for="variant[{{ $i }}]_weight">
                    <span>{{ __('Weight') }}</span>
                    <span class="text-danger">*</span>
                </label>
                <input
                    type="number"
                    id="variant[{{ $i }}]_weight"
                    name="variant[{{ $i }}]_weight"
                    class="form-control"
                />
            </div>
        </div>
        <div class="row">
            <div class="col-lg form-group">
                <label for="variant[{{ $i }}]_width">
                    <span>{{ __('Width') }}</span>
                    <span class="text-danger">*</span>
                </label>
                <input
                    type="number"
                    id="variant[{{ $i }}]_width"
                    name="variant[{{ $i }}]_width"
                    class="form-control"
                />
            </div>
            <div class="col-lg form-group">
                <label for="variant[{{ $i }}]_height">
                    <span>{{ __('Height') }}</span>
                    <span class="text-danger">*</span>
                </label>
                <input
                    type="number"
                    id="variant[{{ $i }}]_height"
                    name="variant[{{ $i }}]_height"
                    class="form-control"
                />
            </div>
            <div class="col-lg form-group">
                <label for="variant[{{ $i }}]_length">
                    <span>{{ __('Length') }}</span>
                    <span class="text-danger">*</span>
                </label>
                <input
                    type="number"
                    id="variant[{{ $i }}]_length"
                    name="variant[{{ $i }}]_length"
                    class="form-control"
                />
            </div>
        </div>
    </div>
@endforeach
