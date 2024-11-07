@props(['type','icon','caption','count'])
<div {{ $attributes->merge(['class' => 'card info-card sales-card cardhover']) }}>
    <div class="card-body">
        <h5 class="card-title text-white">{{ $type }}</h5>

        <div class="d-flex align-items-center">
            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                <i class="{{ $icon }}"></i>
            </div>
            <div class="ps-3 d-flex flex-column justify-content-left">
                <h6 class="text-white">{{ $count }}</h6>
                <span class="text-white-50 small pt-2 ps-1">{{ $caption }}</span>
            </div>
        </div>
    </div>
</div>
