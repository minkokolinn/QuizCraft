@props(['quiz', 'grades', 'chapters'])
<x-layout>
    <x-slot name="title">
        <title>Quiz - QuizCraft</title>
    </x-slot>
    <x-blank-main>
        <x-bg-card>
            <h5 class="card-title">
                <a href="/quiz?type={{ $quiz->type->id }}" class="px-2"><i class="bi bi-caret-left-fill"
                        style="font-size: 16px;"></i></a>
                {{ $quiz->type->name }} Edit Form
            </h5>
            @if (session('success'))
                <x-alert-success>{{ session('success') }}</x-alert-success>
            @endif
            @if (session('error'))
                <x-alert-danger>{{ session('error') }}</x-alert-danger>
            @endif

            <form class="row" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="col-md-6">
                    <label for="gradeInput" class="form-label"><b>Grade</b></label>
                    <select name="grade" class="form-select" id="gradeInput" aria-label="Default select example">
                        <option>Open this select menu</option>
                        @foreach ($grades as $grade)
                            <option value="{{ $grade }}" {{ $quiz->grade == $grade ? 'selected' : '' }}>
                                Grade
                                {{ $grade }}</option>
                        @endforeach
                    </select>
                    <x-error name="grade"></x-error>
                </div>
                <div class="col-md-6">
                    <label for="chapterInput" class="form-label"><b>Chapter</b></label>
                    <select name="chapter" class="form-select" id="chapterInput" aria-label="Default select example">
                        <option>Open this select menu</option>
                        @foreach ($chapters as $chapter)
                            <option value="{{ $chapter }}" {{ $quiz->chapter == $chapter ? 'selected' : '' }}>
                                Chapter
                                {{ $chapter }}</option>
                        @endforeach
                    </select>
                    <x-error name="chapter"></x-error>
                </div>

                {{-- For Multiple Choice / Single Entry --}}
                @if ($quiz->type->id == 3)
                    @php
                        $mcq = json_decode($quiz->body, true);
                    @endphp
                    <div class="col-12 my-2">
                        <label for="bodyInput" class="form-label"><b>Body</b> <small class="form-text"> ( Enter the
                                question ) </small></label>
                        <textarea name="body" class="editor" id="bodyInput">
                        {{ $mcq['body'] }}
                    </textarea>
                        <x-error name="body"></x-error>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="AInput">A.</span>
                            <input name="A" type="text" class="form-control" placeholder="Enter Option A"
                                autocomplete="off" value="{{ $mcq['A'] }}">
                        </div>
                        <x-error name="A"></x-error>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="BInput">B.</span>
                            <input name="B" type="text" class="form-control" placeholder="Enter Option B"
                                autocomplete="off" value="{{ $mcq['B'] }}">
                        </div>
                        <x-error name="B"></x-error>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="CInput">C.</span>
                            <input name="C" type="text" class="form-control" placeholder="Enter Option C"
                                autocomplete="off" value="{{ $mcq['C'] }}">
                        </div>
                        <x-error name="C"></x-error>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="DInput">D.</span>
                            <input name="D" type="text" class="form-control" placeholder="Enter Option D"
                                autocomplete="off" value="{{ $mcq['D'] }}">
                        </div>
                        <x-error name="D"></x-error>
                    </div>
                @else
                    <div class="col-12 my-2">
                        <label for="bodyInput" class="form-label"><b>Body</b> <small class="form-text"> ( Enter the
                                question ) </small></label>
                        <textarea name="body" class="editor" id="bodyInput">
                        {{ $quiz->body }}
                    </textarea>
                        <x-error name="body"></x-error>
                    </div>
                @endif

                <div class="col-12 mb-2">
                    <label for="headerInput" class="form-label"><b>Image</b></label>
                    <input name="image" type="file" {{ isset($quiz->image) ? 'disabled' : '' }}
                        class="form-control border-dark-subtle">
                    <x-error name="image"></x-error>
                </div>
                @isset($quiz->image)
                    <img src="{{ asset("uploads/$quiz->image") }}" style="width:300px;" class="mb-2">
                    <p>
                        {{ $quiz->image }}
                        <a href="/quiz/{{ $quiz->id }}/edit/remove-img" class="btn btn-danger"><i class="bi bi-trash"></i></a>
                    </p>
                @endisset

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">Edit</button>
                </div>
            </form>
        </x-bg-card>
    </x-blank-main>
</x-layout>
