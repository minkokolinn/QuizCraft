@props(['paper', 'grades', 'img_list', 'types'])
<x-layout-configure>
    <x-slot name="title">
        <title>Question Paper Configuration</title>
    </x-slot>
    <div class="pt-1" style="background-color: #FFFFFF; box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);">
        <div class="stepper-wrapper">
            <div class="stepper-item completed">
                <a href="/paper">
                    <div class="step-counter"><i class="bi bi-house-door"></i></div>
                </a>
                <div class="step-name">Back</div>
            </div>
            <div class="stepper-item active">
                <a href="/paper/{{ $paper->id }}/configure">
                    <div class="step-counter" id="btn1">1</div>
                </a>
                <div class="step-name">Configure Paper</div>
            </div>
            <div class="stepper-item">
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

    <div class="card m-3">
        <div class="card-body">
            <div class="text-center">
                <h5 class="card-title">Configuration</h5>
            </div>
            <form class="text-end col-md-10 mx-auto">
                @csrf
                <div class="row mb-3">
                    <label for="name" class="col-sm-2 col-form-label"><b>Question Name</b></label>
                    <div class="col-sm-10 text-start">
                        <input type="text" class="form-control border-dark-subtle" id="name" autocomplete="off"
                            value="{{ isset($paper) ? $paper->name : '' }}">
                        <small class="form-text text-start">This name will not be displayed on question
                            paper.</small>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="grade" class="col-sm-2 col-form-label"><b>Grade</b></label>
                    <div class="col-sm-10 text-start">
                        <select class="form-select border-dark-subtle" id="grade"
                            aria-label="Default select example">
                            <option value="">Open this select menu</option>
                            @isset($paper)
                                @foreach ($grades as $grade)
                                    <option value="{{ $grade }}" {{ $paper->grade == $grade ? 'selected' : '' }}>
                                        Grade
                                        {{ $grade }}</option>
                                @endforeach
                            @else
                                @foreach ($grades as $grade)
                                    <option value="{{ $grade }}">
                                        Grade
                                        {{ $grade }}</option>
                                @endforeach
                            @endisset
                        </select>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="header_img" class="col-sm-2 col-form-label"><b>Header Image</b></label>
                    <div class="col-sm-10 text-start">
                        <select class="form-select border-dark-subtle" id="header_img"
                            aria-label="Default select example">
                            <option value="">Open this select menu</option>
                            @isset($img_list)
                                @isset($paper)
                                    @foreach ($img_list as $img)
                                        <option value="{{ $img }}" {{ $paper->header_img == $img ? 'selected' : '' }}>
                                            {{ $img }}</option>
                                    @endforeach
                                @else
                                    @foreach ($img_list as $img)
                                        <option value="{{ $img }}">
                                            {{ $img }}</option>
                                    @endforeach
                                @endisset
                            @endisset
                        </select>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="header" class="col-sm-2 col-form-label"><b>Header</b></label>
                    <div class="col-sm-10 text-start" id="inputContainer">
                        @isset($paper)
                            @php
                                $headersArr = explode('|', $paper->header);
                            @endphp
                            <div class="input-group mb-2">
                                <input type="text" class="form-control headers" id="header" placeholder="Header 1"
                                    value="{{ $headersArr[0] }}">
                                <button class="btn btn-primary" type="button" id="btnPlusMinus"><i
                                        class="bi bi-plus-lg"></i></button>
                            </div>
                            @if (count($headersArr) > 1)
                                @php
                                    $count = 0;
                                    foreach ($headersArr as $header) {
                                        if ($count > 0) {
                                            echo "<div class='input-group mb-2'>
                                                <input type='text' class='form-control headers'
                                                    placeholder='Header' value='" .
                                                $header .
                                                "'>
                                                <button class='btn btn-warning minus-btn' type='button'><i
                                                        class='bi bi-dash-lg'></i></button>
                                                </div>";
                                        }
                                        $count++;
                                    }
                                @endphp
                            @endif
                        @else
                            <div class="input-group mb-2">
                                <input type="text" class="form-control headers" id="header" placeholder="Header 1">
                                <button class="btn btn-primary" type="button" id="btnPlusMinus"><i
                                        class="bi bi-plus-lg"></i></button>
                            </div>
                        @endisset
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="time_allowed" class="col-sm-2 col-form-label"><b>Time Allowed</b></label>
                    <div class="col-sm-10 text-start">
                        <input type="text" class="form-control border-dark-subtle" id="time_allowed"
                            value="{{ isset($paper) ? $paper->time_allowed : '' }}">
                    </div>
                </div>
                <div class="text-center">
                    <h5 class="card-title">Format</h5>
                </div>
                @isset($paper)
                    @isset($paper->info)
                        @php
                            $subformatArr = explode(',', $paper->info);
                            $formatted = [];
                            foreach ($subformatArr as $subformat) {
                                $temp = explode('-', $subformat);
                                $formatted[$temp[0]] = [$temp[1], $temp[2]];
                            }
                        @endphp
                        @foreach ($types as $type)
                            <div class="row mb-3 types" id="{{ $type->id }}">
                                <label for="count{{ $type->id }}"
                                    class="col-sm-2 col-form-label"><b>{{ $type->name }}</b></label>
                                <div class="col-6 col-sm-5 text-start">
                                    @if (array_key_exists($type->id, $formatted))
                                        <input type="number" class="form-control border-dark-subtle"
                                            id="count{{ $type->id }}" placeholder="Count"
                                            value="{{ $formatted[$type->id][0] }}">
                                    @else
                                        <input type="number" class="form-control border-dark-subtle"
                                            id="count{{ $type->id }}" placeholder="Count" value="">
                                    @endif
                                </div>
                                <div class="col-6 col-sm-5 text-start">
                                    @if (array_key_exists($type->id, $formatted))
                                        <input type="number" class="form-control border-dark-subtle"
                                            id="mark{{ $type->id }}" placeholder="Mark"
                                            value="{{ $formatted[$type->id][1] }}">
                                    @else
                                        <input type="number" class="form-control border-dark-subtle"
                                            id="mark{{ $type->id }}" placeholder="Mark" value="">
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    @else
                        @foreach ($types as $type)
                            <div class="row mb-3 types" id="{{ $type->id }}">
                                <label for="count{{ $type->id }}"
                                    class="col-sm-2 col-form-label"><b>{{ $type->name }}</b></label>
                                <div class="col-6 col-sm-5 text-start">
                                    <input type="number" class="form-control border-dark-subtle"
                                        id="count{{ $type->id }}" placeholder="Count">
                                </div>
                                <div class="col-6 col-sm-5 text-start">
                                    <input type="number" class="form-control border-dark-subtle"
                                        id="mark{{ $type->id }}" placeholder="Mark">
                                </div>
                            </div>
                        @endforeach
                    @endisset
                @endisset

                <div class="row mt-5 mb-3">
                    <label for="total_mark" class="col-sm-2 col-form-label"><b>Total Mark</b></label>
                    <div class="col-sm-10 text-start">
                        <input type="number" class="form-control border-dark-subtle" id="total_mark"
                            value="{{ isset($paper) ? $paper->total_mark : '' }}">
                    </div>
                </div>
                <div class="text-end">
                    <button type="button" class="btn btn-primary"
                        onclick="updatePaper({{ $paper->id }})">Save</button>
                </div>
            </form><!-- End Horizontal Form -->
        </div>
    </div>


    {{-- toast container --}}
    <div class="position-fixed top-0 end-0 p-3" style="z-index: 11; margin-top:60px;">
        <div id="toastContainer">
            @if (session('warning'))
                <div class="toast bg-warning text-black mb-2" role="alert" id="clickstep2">
                    <div class="d-flex">
                        <div class="toast-body">
                            {{ session('warning') }}
                        </div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                            aria-label="Close"></button>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-layout-configure>
