@extends("admin.layouts.app")
    <head>
        <title>Редактирование меню</title>
    </head>
@section("content")

    <div class="container">

        <div class="widget-body no-padding">
            <div class="alert alert-warning no-margin">
                <button class="close" data-dismiss="alert">
                    ×
                </button>

                <div class="text-center"><i class="fa-fw fa fa-info"></i>Вы можете поменять последовательность страниц, используя стрелки "вниз" и "вверх".</div>
            </div>

            <div class="table-responsive" style="margin-top:70px;">


                <table class="table table-bordered table-condensed table-hover smart-form has-tickbox">
                    <thead>
                    <tr>
                        <th>Последовательность <a class="btn btn-xs btn-default pull-right"></a> </th>
                        <th>Название страницы <a class="btn btn-xs btn-default pull-right"></a> </th>
                        <th>Подвинуть</th>
                        <th>Действие</th>

                    </tr>
                    </thead>
                    <tbody >
                    @foreach($pages as $page)
                        <tr>
                            <td>{{ $page->position }}</td>
                            <td contenteditable="false" class="selected">
                                <a>{{ $page->name }}</a></td>

                            @if($page->position != 1 and $page->position != 5)
                            <td class="action" rel="{{$page->id}}">

                                    <i rel="up" class="fa fa-sort-asc txt-color-green repos" title="Вверх"></i>

                                    <i rel="down"class="fa fa-sort-desc txt-color-red repos" title="Вниз"></i>

                            </td>
                            @else
                            <td></td>
                            @endif

                            <td style="cursor: pointer; font-size:26px">
                                <a href="{{ route("admin.pages.edit", $page->route) }}"><i class="fa fa-pencil txt-color-orange" aria-hidden="true" title="Редактировать" ></i></a>
                            </td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>

            </div>

        </div>
    </div>

    <script>
        $('.repos').on('click', function() {

        let action=$(this).attr('rel'),
            id=$(this).parent().attr('rel'),
            currentTr = $(this).closest('tr'),
            prevId;

        if(action == "up"){

            prevId = currentTr.prev();

            currentTr.insertBefore($(this).closest('tr').prev());

        } if(action == "down") {

            prevId = currentTr.next();

            currentTr.insertAfter($(this).closest('tr').next());
        }

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: "pages",
            dataType : 'json',
            type: 'put',
            data: {
                "action": action,
                "id": id,
                "prevId": prevId.find('[rel]').eq(0).attr('rel')
            }
        });


        });
    </script>

@endsection