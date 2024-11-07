@props(['paper', 'setting'])
<x-layout-quizzes>
    <x-slot name="title">
        <title>Adding Quizzes to Paper</title>
    </x-slot>
    <div class="pt-1" style="background-color: #FFFFFF; box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);">
        <div class="stepper-wrapper">
            <div class="stepper-item completed">
                <a href="/paper">
                    <div class="step-counter"><i class="bi bi-house-door"></i></div>
                </a>
                <div class="step-name">Back</div>
            </div>
            <div class="stepper-item completed">
                <a href="/paper/{{ $paper->id }}/configure">
                    <div class="step-counter" id="btn1">1</div>
                </a>
                <div class="step-name">Configure Paper</div>
            </div>
            <div class="stepper-item active">
                <a href="/paper/{{ $paper->id }}/quizzes">
                    <div class="step-counter" id="btn2">2</div>
                </a>
                <div class="step-name">Add Quizzes</div>
            </div>
            <div class="stepper-item">
                <a href="/paper/{{ $paper->id }}/preview">
                    <div class="step-counter" id="btn3">3</div>
                </a>
                <div class="step-name">Preview</div>
            </div>
        </div>
    </div>
    <span class="d-none" id="paperIdHidden">{{ $paper->id }}</span>
    <div class="card m-3">
        <div class="card-body">
            @isset($paper->header_img)
                <center>
                    <img src="/uploads/{{ $paper->header_img }}" alt="" style="width: 200px; height: auto;">
                </center>
            @endisset
            <div class="text-center pt-3">
                @php
                    $headers = explode('|', $paper->header);
                @endphp
                @foreach ($headers as $header)
                    <h5 class="fw-bold">{{ $header }}</h5>
                @endforeach
            </div>
            <hr>
            <div class="row border-bottom">
                <h6 class="col text-start">Grade - {{ $paper->grade }}<span class="d-none"
                        id="gradeHidden">{{ $paper->grade }}</span></h6>
                <h6 class="col text-center">{{ $setting->subject }}</h6>
                <h6 class="col text-end">Time Allowed: {{ $paper->time_allowed }}</h6>
            </div>
            <div id="paperContent">
                
            </div>
        </div>
    </div>
    <x-setupquizzes-modal :paperId="$paper->id" :chapters="$setting->chapter"></x-setupquizzes-modal>
    {{-- toast container --}}
    <div class="position-fixed top-0 end-0 p-3" style="z-index: 5000; margin-top:60px;">
        <div id="toastContainer">

        </div>
    </div>
</x-layout-quizzes>
