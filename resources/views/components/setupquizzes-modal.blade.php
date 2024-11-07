@props(['paperId', 'chapters'])
<div class="modal fade" id="setupquizzes-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <div class="w-100 d-flex flex-row justify-content-between align-items-center pt-2">
                    <h5 id="setupquizzesTitle" class="fw-bold"></h5>
                    <h6 class="badge bg-success text-center" style="font-size: 18px;">Left : <span
                            id="left"></span>
                    </h6>
                    <div class="d-flex flex-row">
                        <input type="text" placeholder="Search" onkeyup="searchQuizzes(event)"
                            class="form-control border-secondary mx-3">
                        <select class="form-select border-secondary" onchange="filterByChapter(this)">
                            @php
                                $chapterArr = explode(',', $chapters);
                            @endphp
                            <option value="">Filter By Chapter</option>
                            @foreach ($chapterArr as $chapter)
                                <option value="{{ $chapter }}">Chapter - {{ $chapter }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button class="btn btn-primary mx-5" id="btnSubmitSetupQuizzes"
                        onclick="attachPaperQuizzes({{ $paperId }})">Submit</button>
                </div>
                <button type="button" class="btn-close" onclick="cleanup()" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body" style="height: 450px; overflow-y:scroll;">
                <div id="setupquizzesBody">

                </div>
            </div>
        </div>
    </div>
</div>
