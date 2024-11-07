@props(['quizzes', 'selectedType'])
<x-layout>
    <x-slot name="title">
        <title>Quiz - QuizCraft</title>
    </x-slot>
    <x-blank-main>
        <x-bg-card>
            <div class="d-flex justify-content-between">
                <h5 class="card-title">
                    <a href="/" class="px-2"><i class="bi bi-caret-left-fill" style="font-size: 16px;"></i></a>
                    @isset($selectedType)
                        List of {{ $selectedType->name }}
                    @else
                        All Quizzes
                    @endisset
                    <span class="badge bg-secondary text-white d-none">Selected Row : <span id="countTxt"
                            class="text-white fw-bold"></span></span>
                </h5>

                <div class="d-flex align-items-center">
                    <div>
                        <div class="dropdown d-inline">
                            <button class="btn btn-outline-secondary dropdown-toggle" type="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                {{ request("grade") ? "Grade - ".request("grade") : 'Filter By Grade' }}
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="/quiz?{{ request('type') ? '&type=' . request('type') : '' }}{{ request('chapter') ? '&chapter=' . request('chapter') : '' }}">All</a></li>
                                @foreach ($grades as $grade)
                                    <li><a class="dropdown-item"
                                            href="/quiz?grade={{ $grade }}{{ request('type') ? '&type=' . request('type') : '' }}{{ request('chapter') ? '&chapter=' . request('chapter') : '' }}">
                                            Grade - {{ $grade }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="dropdown d-inline">
                            <button class="btn btn-outline-secondary dropdown-toggle" type="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                {{ request("chapter") ? "Chapter - ".request("chapter") : 'Filter By Chapter' }}
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="/quiz?{{ request('type') ? '&type=' . request('type') : '' }}{{ request('grade') ? '&grade=' . request('grade') : '' }}">All</a></li>
                                @foreach ($chapters as $chapter)
                                    <li><a class="dropdown-item"
                                            href="/quiz?chapter={{ $chapter }}{{ request('type') ? '&type=' . request('type') : '' }}{{ request('grade') ? '&grade=' . request('grade') : '' }}">
                                            Chapter - {{ $chapter }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="d-inline mx-2" style="border: 1px solid #000;"></div>
                        @isset($selectedType)
                            <div class="dropdown d-inline">
                                <button class="btn btn-info dropdown-toggle" type="button" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    <i class="bi bi-plus-circle-dotted"></i> New
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="/quiz/create?type={{ $selectedType->id }}">Single</a>
                                    </li>
                                    <li><a class="dropdown-item"
                                            href="/quiz/create?type={{ $selectedType->id }}&multiple=on"">Multiple</a></li>
                                </ul>
                            </div>
                        @endisset
                        <button type="button" class="btn btn-warning" id="btnEdit" onclick="editQuizForm()"
                            disabled><i class="bi bi-pencil-square"></i> Edit</button>
                        <form method="post" class="d-inline" id="deleteForm">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="actionIds" id="actionIds" readonly>
                        </form>
                        <button type="button" class="btn btn-danger" id="btnDelete" data-bs-toggle="modal"
                            data-bs-target="#delete-confirm-modal" disabled><i class="bi bi-trash3"></i>
                            Delete</button>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table datatable table-hover">
                    <thead>
                        <tr>
                            <th class="d-none">Detail</th>
                            <th>No</th>
                            <th>Grade</th>
                            <th>Chapter</th>
                            @unless (request('type'))
                                <th>Type</th>
                            @endunless
                            <th>Quiz</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($quizzes as $quiz)
                            <tr>
                                <td class="d-none">
                                    @php
                                        $dataDetail = collect([
                                            'id' => $quiz->id,
                                            'body' => $quiz->body,
                                            'image' => $quiz->image,
                                            'grade' => $quiz->grade,
                                            'chapter' => $quiz->chapter,
                                            'type_id' => $quiz->type->id,
                                            'type_name' => $quiz->type->name,
                                            'updated' => $quiz->updated_at->format('F j, Y, g:i a'),
                                        ]);
                                        $jsonDetail = $dataDetail->toJson();
                                    @endphp
                                    {{ $jsonDetail }}
                                </td>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $quiz->grade }}</td>
                                <td>{{ $quiz->chapter }}</td>
                                @unless (request('type'))
                                    <td>{{ $quiz->type->name }}</td>
                                @endunless
                                @if ($quiz->type->id == 3)
                                    @php
                                        $mcq = json_decode($quiz->body, true);
                                    @endphp
                                    <td>
                                        {!! Str::limit($mcq['body'], 150, ' ... <a href="">more</a>') !!}
                                        <span class="badge bg-dark">A. {{ $mcq['A'] }}</span>
                                        <span class="badge bg-dark">B. {{ $mcq['B'] }}</span>
                                        <span class="badge bg-dark">C. {{ $mcq['C'] }}</span>
                                        <span class="badge bg-dark">D. {{ $mcq['D'] }}</span>
                                    </td>
                                @else
                                    <td>{!! Str::limit($quiz->body, 150, ' ... <a href="">more</a>') !!}</td>
                                @endif

                                <td class="exclude-select">
                                    <button class="btn btn-dark btn-sm exclude-select" onclick="showQuizDetail(this)">
                                        <i class="bi bi-eye exclude-select"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <x-detail-modal></x-detail-modal>
                <x-delete-modal></x-delete-modal>
            </div>
        </x-bg-card>
    </x-blank-main>
</x-layout>
