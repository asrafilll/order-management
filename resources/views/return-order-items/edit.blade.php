<x-app>
    <x-content-header>
        <h1 class="m-0">{{ __('Edit Return Order Item') }}</h1>
    </x-content-header>

    <section class="content">
        <div class="row">
            <div class="col-lg-6">
                <form
                    action="{{ route('return-order-items.update', $returnOrderItem) }}"
                    method="POST"
                    novalidate
                >
                    @csrf
                    @method('PUT')
                    <div class="card">
                        <div class="card-body">
                            <dl>
                                <dt>{{ __('Order') }}</dt>
                                <dd>{{ "{$returnOrderItem->order_id} ({$returnOrderItem->order->customer_name})" }}</dd>
                                <dt>{{ __('Item') }}</dt>
                                <dd>{{ "{$returnOrderItem->orderItem->product_name} - {$returnOrderItem->orderItem->variant_name}" }}</dd>
                            </dl>
                            <div class="form-group">
                                <label for="quantity">
                                    <span>{{ __('Quantity') }}</span>
                                    <span class="text-danger">*</span>
                                </label>
                                <input
                                    type="text"
                                    id="quantity"
                                    name="quantity"
                                    class="form-control @error('quantity') is-invalid @enderror"
                                    value="{{ old('quantity') ?? $returnOrderItem->quantity ?? '' }}"
                                />
                                @error('quantity')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="reason">
                                    <span>{{ __('Reason') }}</span>
                                </label>
                                <input
                                    type="text"
                                    id="reason"
                                    name="reason"
                                    class="form-control @error('reason') is-invalid @enderror"
                                    value="{{ old('reason') ?? $returnOrderItem->reason ?? '' }}"
                                />
                                @error('reason')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="publish">
                                    <span>{{ __('Publish') }}</span>
                                    <span class="text-danger">*</span>
                                </label>
                                <select
                                    id="publish"
                                    name="publish"
                                    class="form-control @error('publish') is-invalid @enderror"
                                >
                                    <option value="0" @if(!$returnOrderItem->isPublished()) selected @endif>{{ __('No') }}</option>
                                    <option value="1" @if($returnOrderItem->isPublished()) selected @endif>{{ __('Yes') }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button
                                type="submit"
                                class="btn btn-primary"
                            >{{ __('Save') }}</button>
                            <a
                                href="{{ route('return-order-items.index') }}"
                                class="btn btn-default"
                            >{{ __('Back') }}</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
</x-app>
