@props(['paper', 'setting', 'thewholepaper'])
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Question Paper</title>
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/step-progress.css') }}" rel="stylesheet">
    <style>
        @page {
            /* Set A4 size for PDF generation */
            size: A4;
            /* margin: 40px; */
            margin-top: 70px;
            margin-bottom: 40px;
        }

        @media print {
            .print-hide {
                display: none;
            }
        }
        body {
            font-family: Arial, sans-serif;
            /* width: 800px; */
            box-sizing: border-box;
            /* margin-left: 20px;
            margin-right: 20px; */
        }
        h1 {
            text-align: center;
            font-weight: bold;
            font-family: Minion Pro;
            font-size: 25px;
        }
        ul {
            list-style-type: none;
        }
        p {
            display: inline;
            font-family: Minion Pro;
            font-size: 20px;
        }
        td{
            font-family: Minion Pro;
            font-size: 20px;
        }
    </style>
</head>

<body>
    <div class="pt-1 print-hide" style="background-color: #FFFFFF; box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);">
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
            <div class="stepper-item completed">
                <a href="/paper/{{ $paper->id }}/quizzes">
                    <div class="step-counter" id="btn2">2</div>
                </a>
                <div class="step-name">Add Quizzes</div>
            </div>
            <div class="stepper-item active">
                <a href="/paper/{{ $paper->id }}/preview">
                    <div class="step-counter" id="btn3">3</div>
                </a>
                <div class="step-name">Preview</div>
            </div>
        </div>
    </div>
    <button class="btn btn-outline-primary btn-lg rounded-circle print-hide"
        style="position: fixed; bottom:30px; right:30px;" onclick="window.print()">
        <i class="bi bi-printer-fill" style="font-size: 40px;"></i>
    </button>
    @isset($paper->header_img)
        <center>
            <img src="/uploads/{{ $paper->header_img }}" alt="" style="width: 200px; height: auto;">
        </center>
    @endisset
    @php
        $headers = explode('|', $paper->header);
    @endphp
    @foreach ($headers as $header)
        <h1>{{ $header }}</h1>
    @endforeach
    <div class="row">
        <h1 class="col text-start">Grade - {{ $paper->grade }}</h1>
        <h1 class="col text-center">{{ $setting->subject }}</h1>
        <h1 class="col text-end">Time Allowed : {{ $paper->time_allowed }}</h1>
    </div>
    @php
        $romanNumerals = [
            '',
            'i',
            'ii',
            'iii',
            'iv',
            'v',
            'vi',
            'vii',
            'viii',
            'ix',
            'x',
            'xi',
            'xii',
            'xiii',
            'xiv',
            'xv',
            'xvi',
            'xvii',
            'xviii',
            'xix',
            'xx',
            'xxi',
            'xxii',
            'xxiii',
            'xxiv',
            'xxv',
            'xxvi',
            'xxvii',
            'xxviii',
            'xxix',
            'xxx',
            'xxxi',
            'xxxii',
            'xxxiii',
            'xxxiv',
            'xxxv',
            'xxxvi',
            'xxxvii',
            'xxxviii',
            'xxxix',
            'xl',
            'xli',
            'xlii',
            'xliii',
            'xliv',
            'xlv',
            'xlvi',
            'xlvii',
            'xlviii',
            'xlix',
            'l',
            'li',
            'lii',
            'liii',
            'liv',
            'lv',
            'lvi',
            'lvii',
            'lviii',
            'lix',
            'lx',
            'lxi',
            'lxii',
            'lxiii',
            'lxiv',
            'lxv',
            'lxvi',
            'lxvii',
            'lxviii',
            'lxix',
            'lxx',
            'lxxi',
            'lxxii',
            'lxxiii',
            'lxxiv',
            'lxxv',
            'lxxvi',
            'lxxvii',
            'lxxviii',
            'lxxix',
            'lxxx',
            'lxxxi',
            'lxxxii',
            'lxxxiii',
            'lxxxiv',
            'lxxxv',
            'lxxxvi',
            'lxxxvii',
            'lxxxviii',
            'lxxxix',
            'xc',
            'xci',
            'xcii',
            'xciii',
            'xciv',
            'xcv',
            'xcvi',
            'xcvii',
            'xcviii',
            'xcix',
        ];
    @endphp
    @foreach ($thewholepaper as $section)
        <div class="mt-5">
            <p>
                <strong>{{ $loop->iteration }} . {!! $section['type_header'] !!}</strong>
            </p>
        </div>
        <div class="text-end">
            <p>
                <strong>({{ $section['mark'] }}-marks)</strong>
            </p>
        </div>

        <table>
            @foreach ($section['body'] as $quiz)
                <tr>
                    @if ($quiz->type->id == 3)
                        @php
                            $mcq = json_decode($quiz->body, true);
                        @endphp
                        <td class="fw-bold pe-3 d-flex align-items-start justify-content-end pb-2">
                            ({{ $romanNumerals[$quiz->pivot->position] }})
                        </td>
                        <td class="fw-bold pb-2">
                            {!! $mcq['body'] !!}
                            <br>
                            @php
                                $lengths = [];
                                $lengths[] = sizeof(explode(' ', $mcq['A']));
                                $lengths[] = sizeof(explode(' ', $mcq['B']));
                                $lengths[] = sizeof(explode(' ', $mcq['C']));
                                $lengths[] = sizeof(explode(' ', $mcq['D']));
                                $maxLength = max($lengths);
                            @endphp
                            @if ($maxLength < 3)
                                <div class="row">
                                    <div class="col-3">A. {{ $mcq['A'] }}</div>
                                    <div class="col-3">B. {{ $mcq['B'] }}</div>
                                    <div class="col-3">C. {{ $mcq['C'] }}</div>
                                    <div class="col-3">D. {{ $mcq['D'] }}</div>
                                </div>
                            @elseif ($maxLength >= 3 && $maxLength <= 4)
                                <div class="row">
                                    <div class="col-6">A. {{ $mcq['A'] }}</div>
                                    <div class="col-6">B. {{ $mcq['B'] }}</div>
                                    <div class="col-6">C. {{ $mcq['C'] }}</div>
                                    <div class="col-6">D. {{ $mcq['D'] }}</div>
                                </div>
                            @else
                                <div class="row">
                                    <div class="col-12">A. {{ $mcq['A'] }}</div>
                                    <div class="col-12">B. {{ $mcq['B'] }}</div>
                                    <div class="col-12">C. {{ $mcq['C'] }}</div>
                                    <div class="col-12">D. {{ $mcq['D'] }}</div>
                                </div>
                            @endif
                        </td>
                    @else
                        <td class="fw-bold pe-3 d-flex align-items-start justify-content-end pb-2">
                            ({{ $romanNumerals[$quiz->pivot->position] }})
                        </td>
                        <td class="fw-bold pb-2">
                            {!! $quiz->body !!}
                        </td>
                    @endif
                </tr>
            @endforeach
        </table>
    @endforeach

</body>

</html>
