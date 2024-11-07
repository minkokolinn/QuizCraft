@props(['types', 'quizTotalCount', 'paperCount', 'latest8papers'])
<x-layout>
    <x-slot name="title">
        <title>Dashboard - QuizCraft</title>
    </x-slot>
    @php
        $breadcrumb = ['Monitoring and Management'];
    @endphp
    <x-main title="Dashboard" :breadcrumb="$breadcrumb">
        <section class="section dashboard">
            <div class="row">
                <div class="col-lg-8">
                    <div class="row">
                        <div class="col-xxl-4 col-xl-4 col-md-6">
                            <a href="/quiztype">
                                <x-dashboard-card type='Quiz Type' icon="bi bi-list-columns" caption="Total Quiz Type"
                                    count="{{ $types->count() }}" class="bg-success"></x-dashboard-card>
                            </a>
                        </div>
                        <div class="col-xxl-4 col-xl-4 col-md-6">
                            <a href="/quiz">
                                <x-dashboard-card type='Quizs' icon="bi bi-question-octagon-fill"
                                    caption="Total Quizs" count="{{ $quizTotalCount }}"
                                    class="bg-danger"></x-dashboard-card>
                            </a>
                        </div>
                        <div class="col-xxl-4 col-xl-4 col-md-6">
                            <a href="/paper">
                                <x-dashboard-card type='Paper' icon="bi bi-envelope-paper-fill" caption="Total Paper"
                                    count="{{ $paperCount }}" class="bg-primary"></x-dashboard-card>
                            </a>
                        </div>
                        <hr class="mb-4">
                        @foreach ($types as $type)
                            <div class="col-xxl-4 col-xl-4 col-md-6">
                                <a href="/quiz?type={{ $type->id }}">
                                    <x-dashboard-card type='{{ $type->name }}' icon="bi bi-database-fill"
                                        caption="worth {{ $type->mark == 1 ? $type->mark . ' mark' : $type->mark . ' marks' }}"
                                        count="{{ $type->quizzes->count() }}" class="bg-dark"></x-dashboard-card>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div><!-- End Left side columns -->

                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Recent Papers</h5>

                            <div>
                                @if ($latest8papers)
                                    @foreach ($latest8papers as $paper)
                                        <div class="row">
                                            <div class="col-7">
                                                <a href="/paper/{{ $paper->id }}/configure"
                                                    class="fw-bold text-dark">{{ $paper->name ? $paper->name : 'Untitled Paper' }}</a>
                                            </div>
                                            <div class="col-5">
                                                <small>{{ $paper->updated_at->diffForHumans() }}</small>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-7">
                                                <span class="badge bg-dark">Grade - {{ $paper->grade }}</span>
                                                <br>
                                                <span class="badge bg-dark">Time Allowed -
                                                    {{ $paper->time_allowed }}</span>
                                            </div>
                                            <div class="col-5">
                                                @if (sizeof($latest8papers) != $loop->iteration)
                                                    <div style="border-left: 5px solid #007bff; height: 80px;"></div>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>
    </x-main>
</x-layout>
