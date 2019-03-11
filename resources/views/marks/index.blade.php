@extends('layout.logined')

@php($user = Auth::user())

@section('title')
    {{ __("marks.title") }}
@endsection

@section('content')
    <div class="container container-points">
        @if ($has_login)
            <table class="table table-sm">
                <tbody>
                    <tr>
                        <td>
                            <strong>Предмет</strong>
                        </td>
                        <td>
                            <strong>Количество</strong>
                            <span id="mark_text">5</span>
                                <input type="text" id="mark" class="dis-none mark-change"></input>
                            <strong>до</strong>
                            <span id="mid_text">4.50</span>
                                <input type="text" id="mid" class="dis-none mid-change">
                            <!--<div class="help-block">
                                <div class="help">?</div>
                                <span class="tip">
                                    Кликни 2 раза на оценку и средний балл
                                </span>
                            </div>-->
                        </td>
                        <td colspan="100">
                            <strong>Оценки</strong>
                        </td>
                    </tr>
                    @foreach ($lessons as $lesson)
                        <tr class="marks_row">
                            <td class="w-40">{{ $lesson["name"] }}</td>
                            <td class="need_marks">0</td>
                            @foreach ($lesson["marks"] as $mark)
                                <td class="one-mark">{{ $mark }}</td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            Сорри, у тебя нет логина еду татар
        @endif
    </div>

    @push('scripts')
        <script>
            (function() {
                let mid_text = $("#mid_text").html();
                $("#mid").val(mid_text);

                let mark_text = $("#mark_text").html();
                $("#mark").val(mark_text);
            })();

            $("#mid_text").dblclick(function () {
                let mid_text = $("#mid_text").html();
                $("#mid").val(mid_text);
                $("#mid_text").hide();
                $("#mid").show();
                $("#mid").focus();
            });
            $("#mid").focusout(function () {
                $("#mid").hide();
                let mid_text = $("#mid").val();
                $("#mid_text").html(mid_text);
                $("#mid_text").show();
            });
            $("#mark_text").dblclick(function () {
                let mid_text = $("#mark_text").html();
                $("#mark").val(mid_text);
                $("#mark_text").hide();
                $("#mark").show();
                $("#mark").focus();
            });
            $("#mark").focusout(function () {
                $("#mark").hide();
                let mid_text = $("#mark").val();
                $("#mark_text").html(mid_text);
                $("#mark_text").show();
            });

            const get_need_marks = function(mark, need, marks) {
                console.log({mark, need});

                let sum = marks.reduce((a,b) => a+b);
                let mean = sum / marks.length;

                if (mean >= need)
                    return 0;

                if (mark < need)
                    return Infinity;

                let count = 0;
                while (true) {
                    count++;

                    if ((marks.length * mean + 5 * count) / (count + marks.length) >= need)
                        break;

                    if (count > 50) {
                        count = Infinity;
                        break;
                    }
                }

                return count;
            };

            const recount = function() {
                let mark = parseFloat($("#mark").val());
                let points = parseFloat($("#mid").val());

                if (isNaN(mark) || isNaN(points))
                    return;

                $(".marks_row").each(function(a) {
                    let marks = $(this).find(".one-mark").map(function() {
                        return parseFloat($(this).html());
                    }).toArray();

                    $(this).find(".need_marks").html(get_need_marks(mark, points, marks));
                });
            };

            recount();
            $("#mark, #mid").keyup(recount);

        </script>
    @endpush
@endsection
