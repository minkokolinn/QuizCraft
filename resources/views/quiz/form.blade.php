@props(['selectedType', 'grades', 'chapters'])
<x-layout>
    <x-slot name="title">
        <title>Quiz - QuizCraft</title>
    </x-slot>
    <x-blank-main>
        <x-bg-card>
            <h5 class="card-title">
                <a href="/quiz?type={{ $selectedType->id }}" class="px-2"><i class="bi bi-caret-left-fill"
                        style="font-size: 16px;"></i></a>
                {{ $selectedType->name }}
                - {{ request('multiple') ? 'Multiple' : 'Single' }}
                Entry Form
                <input type="checkbox" id="chkMcq" class="d-none" {{ $selectedType->id == 3 ? 'checked' : '' }}>
            </h5>
            @if (session('success'))
                <x-alert-success>{{ session('success') }}</x-alert-success>
            @endif
            @if (session('error'))
                <x-alert-danger>{{ session('error') }}</x-alert-danger>
            @endif

            @if (request('multiple'))
                {{-- Multiple Entry --}}
                <form class="row" method="POST" action="/quiz/create-multiple?type={{ $selectedType->id }}">
                    @csrf
                    <div class="col-md-5">
                        <label for="gradeInput" class="form-label"><b>Grade For All Quizzes</b></label>
                        <select name="grade" class="form-select" id="gradeInput" aria-label="Default select example">
                            <option>Open this select menu</option>
                            @foreach ($grades as $grade)
                                <option value="{{ $grade }}" {{ old('grade') == $grade ? 'selected' : '' }}>Grade
                                    {{ $grade }}</option>
                            @endforeach
                        </select>
                        <x-error name="grade"></x-error>
                    </div>
                    <div class="col-md-5">
                        <label for="chapterInput" class="form-label"><b>Chapter For All Quizzes</b></label>
                        <select name="chapter" class="form-select" id="chapterInput"
                            aria-label="Default select example">
                            <option>Open this select menu</option>
                            @foreach ($chapters as $chapter)
                                <option value="{{ $chapter }}"
                                    {{ old('chapter') == $chapter ? 'selected' : '' }}>Chapter
                                    {{ $chapter }}</option>
                            @endforeach
                        </select>
                        <x-error name="chapter"></x-error>
                    </div>
                    <div class="col-md-2">
                        <label for="separator" class="form-label"><b>Separator</b></label>
                        <input name="separator" type="text" id="separator" class="form-control">
                        <x-error name="separator"></x-error>
                    </div>
                    <div class="col-12 my-2">
                        <label for="importInput" class="form-label"><b>Import All Quizzes in this field *</b></label>
                        <textarea name="import" id="importInput" class="editor" style="height: 200px;">
                            {{ old('import') }}
                        </textarea>
                        <x-error name="import"></x-error>
                    </div>
                    <div class="col-12 my-2" id="separatorPreview"></div>
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">{{ isset($type) ? 'Edit' : 'Save' }}</button>
                    </div>
                </form>
            @else
                {{-- Single Entry --}}
                <form class="row" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="col-md-6">
                        <label for="gradeInput" class="form-label"><b>Grade</b></label>
                        <select name="grade" class="form-select" id="gradeInput" aria-label="Default select example">
                            <option>Open this select menu</option>
                            @foreach ($grades as $grade)
                                <option value="{{ $grade }}" {{ old('grade') == $grade ? 'selected' : '' }}>
                                    Grade
                                    {{ $grade }}</option>
                            @endforeach
                        </select>
                        <x-error name="grade"></x-error>
                    </div>
                    <div class="col-md-6">
                        <label for="chapterInput" class="form-label"><b>Chapter</b></label>
                        <select name="chapter" class="form-select" id="chapterInput"
                            aria-label="Default select example">
                            <option>Open this select menu</option>
                            @foreach ($chapters as $chapter)
                                <option value="{{ $chapter }}"
                                    {{ old('chapter') == $chapter ? 'selected' : '' }}>Chapter
                                    {{ $chapter }}</option>
                            @endforeach
                        </select>
                        <x-error name="chapter"></x-error>
                    </div>
                    <div class="col-12 my-2">
                        <label for="bodyInput" class="form-label"><b>Body</b> <small class="form-text"> ( Enter the
                                question ) </small></label>
                        <textarea name="body" class="editor" id="bodyInput">
                            {{ old('body') }}
                        </textarea>
                        <x-error name="body"></x-error>
                    </div>
                    {{-- For Multiple Choice / Single Entry --}}
                    @if ($selectedType->id == 3)
                        <div class="col-md-6 col-lg-3">
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="AInput">A.</span>
                                <input name="A" type="text" class="form-control" placeholder="Enter Option A"
                                    autocomplete="off" value="{{ old('A') }}">
                            </div>
                            <x-error name="A"></x-error>
                        </div>
                        <div class="col-md-6 col-lg-3">
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="BInput">B.</span>
                                <input name="B" type="text" class="form-control" placeholder="Enter Option B"
                                    autocomplete="off" value="{{ old('B') }}">
                            </div>
                            <x-error name="B"></x-error>
                        </div>
                        <div class="col-md-6 col-lg-3">
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="CInput">C.</span>
                                <input name="C" type="text" class="form-control"
                                    placeholder="Enter Option C" autocomplete="off" value="{{ old('C') }}">
                            </div>
                            <x-error name="C"></x-error>
                        </div>
                        <div class="col-md-6 col-lg-3">
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="DInput">D.</span>
                                <input name="D" type="text" class="form-control"
                                    placeholder="Enter Option D" autocomplete="off" value="{{ old('D') }}">
                            </div>
                            <x-error name="D"></x-error>
                        </div>
                    @endif

                    <div class="col-12 mb-2">
                        <label for="headerInput" class="form-label"><b>Image</b></label>
                        <input name="image" type="file" class="form-control border-dark-subtle">
                        <x-error name="image"></x-error>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">{{ isset($type) ? 'Edit' : 'Save' }}</button>
                    </div>
                </form>
            @endif
        </x-bg-card>
    </x-blank-main>
</x-layout>
