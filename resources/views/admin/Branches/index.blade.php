@extends('layouts.admin')

@section('title')
    الفروع
@endsection

@section('contentheader')
    قائمة الضبط
@endsection

@section('contentheaderactivelink')
    <a href="{{ route('finance_calenders.index') }}">الفروع</a>
@endsection

@section('contentheaderactive')
    عرض
@endsection

@section('content')

<div class="col-12">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title card_title_center"> 
                بيانات الفروع 
                <a href=" {{ route('branches.create') }} " class="btn btn-sm btn-success">إضافة جديد</a>
            </h3>
        </div>

        <div class="card-body">
            @if (@isset($data) and !@empty($data))
            <table id="example2" class="table table-bordered table-hover text-center">
                <thead class="custom_thead">
                    <th> كود الفرع </th>
                    <th> اسم الفرع </th>
                    <th> العنوان </th>
                    <th> الهاتف </th>
                    <th> البريد الإلكتروني </th>
                    <th> حالة التفعيل </th>
                    <th> الإضافة بواسطة </th>
                    <th> التحديث بواسطة </th>
                    <th> </th>
                </thead>
                <tbody>
                    @foreach ($data as $info)
                        <tr>
                            <td> {{ $info->id }} </td>
                            <td> {{ $info->name }} </td>
                            <td> {{ $info->address }} </td>
                            <td> {{ $info->phones }} </td>
                            <td> {{ $info->email }} </td>
                            <td @if ($info->active==1) class="bg-success" @else class="bg-danger" @endif > @if ($info->active==1) مفعل @else معطل @endif </td>
          
                            <td> {{ $info->added->name }} </td>
                            <td>
                                @if ($info->updated_by>0)
                                    {{ $info->updatedby->name }}
                                @else
                                    لا يوجد
                                @endif
                            </td>
                            <td>
                                @if ($info->is_open == 0)
                                    @if ($checkdataopen == 0)
                                        <a href="{{ route('finance_calenders.do_open', $info->id) }}" class="btn btn-primary">فتح</a>
                                    @endif
                                    <a href="{{ route('finance_calenders.edit', $info->id) }}" class="btn btn-success">تعديل</a>
                                    <a href="{{ route('finance_calenders.delete', $info->id) }}" class="btn r_u_sure btn-danger">حذف</a>
                                    <button class="btn btn-info show_year_monthes" data-id="{{ $info->id }}">عرض الشهور</button>
                                @else
                                    سنة مالية مفتوحة
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            @else
                <p class="text-danger text-center font-weight-bold">لا توجد بيانات لعرضها</p>
            @endif

        </div>
    </div>
</div>

<!-- .modal -->
<div class="modal fade" id="show_year_monthesModal">
    <div class="modal-dialog modal-xl">
        <div class="modal-content bg-info">
        <div class="modal-header">
            <h4 class="modal-title">عرض الشهور للسنة المالية</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body" id="show_year_monthesModalBody">
            
        </div>
        <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-outline-light">Save changes</button>
        </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->


@endsection

@section('script')
    
    <script>
        
        $(document).ready(function () {
            $(document).on('click', '.show_year_monthes', function () {
                var id = $(this).data('id');
                // alert("Ali")
                jQuery.ajax({
                    url: "{{ route('finance_calenders.show_year_monthes') }}",
                    type: 'post',
                    'dataType': 'html',
                    cache: false,
                    data: { '_token': '{{ csrf_token() }}', 'id': id },
                    success: function (data) {
                        $("#show_year_monthesModalBody").html(data);
                        $("#show_year_monthesModal").modal("show");
                    },
                    error:function () {

                    }
                    
                });
            })
        });

    </script>

@endsection


