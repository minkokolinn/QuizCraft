@props(['papers', 'formatArr'])
<x-layout>
    <x-slot name="title">
        <title>Paper - QuizCraft</title>
    </x-slot>
    <x-blank-main>
        <x-bg-card>
            <div class="d-flex justify-content-between">
                <h5 class="card-title">
                    <a href="/" class="px-2"><i class="bi bi-caret-left-fill" style="font-size: 16px;"></i></a>
                    Question Paper
                </h5>
                <div class="d-flex align-items-center">
                    <div class="mx-3">
                        <input type="text" class="form-control" onkeyup="searchPaper(event)" placeholder="Search Question Paper">
                    </div>
                    <div>
                        <form action="/paper/create" method="post">
                            @csrf
                            <button type="submit" class="btn btn-dark"><i class="bi bi-plus-lg"></i> New</button>
                        </form>
                    </div>
                </div>
            </div>
            @if (session('success'))
                <x-alert-success>{{ session('success') }}</x-alert-success>
            @endif
            @if (session('error'))
                <x-alert-danger>{{ session('error') }}</x-alert-danger>
            @endif
            <div class="d-flex flex-wrap flex-row">
                @foreach ($papers as $paper)
                    <div class="card mx-2 mb-3 text-center paper-card">
                        <div class="card-body">
                            <a href="/paper/{{ $paper->id }}/configure">
                                <h6 class="card-title border-bottom">
                                    {{ isset($paper->name) ? $paper->name : 'Untitled Paper' }}</h6>
                                <div class="d-flex justify-content-center mb-2">
                                    <img src="{{ asset('images/paper-icon.png') }}" style="width: 50px; height: auto;"
                                        alt="">
                                </div>
                                <div class="row text-center">
                                    <h6>Grade - <b>{{ isset($paper->grade) ? $paper->grade : '...' }}</b></h6>
                                    <h6>Time Allowed -
                                        <b>{{ isset($paper->time_allowed) ? $paper->time_allowed : '...' }}</b>
                                    </h6>
                                    <h6>Total Marks -
                                        <b>{{ isset($paper->total_mark) ? $paper->total_mark : '...' }}</b>
                                    </h6>
                                </div>
                                <div class="d-flex justify-content-center">
                                    <small class="text-muted">Updated {{ $paper->updated_at->diffForHumans() }}</small>
                                    {{-- <small class="text-primary">In Progress</small> --}}
                                </div>
                                <hr>
                                <div class="mt-1">
                                    @if(!empty($formatArr[$paper->id]))
                                        @foreach ($formatArr[$paper->id] as $key => $val)
                                            <span class="badge bg-secondary">{{ $key }} -
                                                {{ $val }}</span>
                                        @endforeach
                                    @endif
                                </div>
                            </a>
                            <div class="d-flex justify-content-end mt-2">
                                <button type="submit" class="btn btn-sm btn-outline-danger" id="btnDelete"
                                    data-bs-toggle="modal"
                                    data-bs-target="#paper{{ $paper->id }}-delete-confirm-modal">
                                    <i class="bi bi-trash3-fill"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="paper{{ $paper->id }}-delete-confirm-modal"
                        data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                        aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="detailTitle">Confirm Delete</h5>
                                </div>
                                <div class="modal-body" id="detailBody">
                                    Are you sure you want to delete {{ $paper->name }}?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Cancel</button>
                                    <button type="button" class="btn btn-danger"
                                        onclick="directToPaperDelete({{ $paper->id }})">Delete</button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </x-bg-card>
    </x-blank-main>
</x-layout>
