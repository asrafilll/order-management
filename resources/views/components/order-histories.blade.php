@props(['order'])

<div class="card">
    <div class="card-header">
        <h3 class="card-title">{{ __('Histories') }}</h3>
    </div>
    <div class="card-body overflow-auto" style="max-height: 300px">
        @foreach ($order->histories as $history)
            <div class="alert alert-light">
                <span>{!! __('Order :type was updated to <b>:to</b> from <b>:from</b> at :created_at.', [
                    'type' => Str::replace('_', ' ', $history->type),
                    'to' => Str::upper($history->to),
                    'from' => Str::upper($history->from),
                    'created_at' => $history->created_at,
                ]) !!}</span>
            </div>
        @endforeach
    </div>
</div>
