<x-custom-layout.app-layout>
    <x-slot name='css'>
        <!-- daterange picker -->
        <link rel="stylesheet" href="{{ asset('assets/plugins/daterangepicker/daterangepicker.css') }}">
        <!-- DataTables -->
        <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
        <link rel="stylesheet"
            href="{{ asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
    </x-slot>
    <x-slot name="content">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Exam Page</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('Admin.Dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Exam Page</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Exam Head</h5>
                            </div>
                            <div class="card-body">
                                <form action="javascript:void(0)" method="post" id="postExam">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="#name">Exam Name</label>
                                                <input type="text" class="form-control" name="name" id="name"
                                                    class="form-control" value="{{ old('name') ?? $exam->name }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="#duration">Exam Duration</label>
                                                {{-- <input type="text" name="duration" class="form-control" id="duration" value="{{old('duration')}}"> --}}
                                                <div class="input-group mb-3">
                                                    <input type="text" class="form-control" name="duration"
                                                        id="duration" value="{{ old('duration') ?? $exam->duration }}">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text">min</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            {{-- <div class="form-group">
                                                <label for="#start">Exam Start</label>
                                                <input type="text" name="exam_start" class="form-control" id="start"
                                                    >
                                            </div> --}}
                                            <div class="form-group">
                                                <label for="#start">Exam Start</label>
                                                <div class="input-group date" id="reservationdate"
                                                    data-target-input="nearest">
                                                    <input type="text" class="form-control datetimepicker-input"
                                                        id="start" name="exam_start" data-target="#reservationdate"
                                                        value="{{ $exam->exam_start }}">
                                                    <div class="input-group-append" data-target="#reservationdate"
                                                        data-toggle="datetimepicker">
                                                        <div class="input-group-text"><i class="fa fa-calendar"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="#end">Exam End</label>
                                                <div class="input-group date" id="examEnd"
                                                    data-target-input="nearest">
                                                    <input type="text" name="exam_end"
                                                        class="form-control datetimepicker-input" data-target="#examEnd"
                                                        value="{{ $exam->exam_end }}">
                                                    <div class="input-group-append" data-target="#examEnd"
                                                        data-toggle="datetimepicker">
                                                        <div class="input-group-text"><i class="fa fa-calendar"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="card-footer">
                                <button class="btn btn-success btn-sm float-right" id="submit-exam-head">Save
                                    Exam</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h5 class="card-title">Exam Question</h5>
                                    </div>
                                    <div class="col-md-6">
                                        <button class="btn btn-sm btn-primary" id="refresh">refesh</button>
                                        <button class="btn btn-sm btn-success float-right" id="fill-exam-question">Add
                                            Exam Question</button>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered table-hover" id="table-exam" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th class="text-center">Question Exam</th>
                                            <th class="text-center">Answer Exam</th>
                                            <th class="text-center">Answer Exam True</th>
                                            <th class="text-center">Score Exam</th>
                                            <th class="text-center">Exam Action</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- /.col-md-6 -->
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->

        <div class="modal fade" id="exam-question">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Add Exam Question</h4>
                        <button type="button" class="close close-modal" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="javascript:void(0)" id="postQuestion" method="post">
                            <input type="hidden" id="exam-id" name="exam_id" value="{{$id}}">
                            <input type="hidden" id="id" name="id" value="0">
                            <input type="hidden" name="update" value="true" disabled>
                            <div class="row">
                                <div class="card col-md-12">
                                    <div class="card-header">
                                        <h5 class="card-title">Question</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="#question">Question</label>
                                                    <input type="text" class="form-control" name="question">
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="#question">Correct Answer</label>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio"
                                                                    name="answer" value="a">
                                                                <label class="form-check-label">A</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio"
                                                                    name="answer" value="b">
                                                                <label class="form-check-label">B</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio"
                                                                    name="answer" value="c">
                                                                <label class="form-check-label">C</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio"
                                                                    name="answer" value="d">
                                                                <label class="form-check-label">D</label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card col-md-12">
                                    <div class="card-header">
                                        <h5 class="card-title">Answer</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group clearfix">
                                                    <div class="form-group">
                                                        <label for="#question">Answer A</label>
                                                        <input type="text" class="form-control option-a" name="option[a]">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="#question">Answer B</label>
                                                        <input type="text" class="form-control option-b"name="option[b]">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group clearfix">
                                                    <div class="form-group">
                                                        <label for="#question">Answer C</label>
                                                        <input type="text" class="form-control option-c" name="option[c]">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="#question">Answer D</label>
                                                        <input type="text" class="form-control option-d" name="option[d]">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </div>
                        </form>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default close-modal" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" id="save-question">Save Question</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
        </div>
    </x-slot>
    <x-slot name='js'>


        <!-- InputMask -->
        <script src="{{ asset('assets/plugins/moment/moment.min.js') }}"></script>
        <!-- date-range-picker -->
        <script src="{{ asset('assets/plugins/daterangepicker/daterangepicker.js') }}"></script>
        <!-- Tempusdominus Bootstrap 4 -->
        <script src="{{ asset('assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
        <!-- DataTables  & Plugins -->
        <script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
        <script src="{{ asset('assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('assets/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
        <script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('assets/plugins/jszip/jszip.min.js') }}"></script>
        <script src="{{ asset('assets/plugins/pdfmake/pdfmake.min.js') }}"></script>
        <script src="{{ asset('assets/plugins/pdfmake/vfs_fonts.js') }}"></script>
        <script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
        <script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
        <script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
        <!-- bs-custom-file-input -->
        <script src="{{ asset('assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
        <script>
            $(document).ready(function() {
                let url = "{{ route('Admin.question.show', ':id') }}"
                url = url.replace(':id', "{{ $id }}")
                let table = $('#table-exam').DataTable({
                    ajax: url,
                    columnDefs: [{
                        className: 'text-center',
                        targets: '_all'
                    }],
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex'
                        },
                        {
                            data: 'question',
                            name: 'question'
                        },
                        {
                            data: 'option',
                            name: 'option'
                        },
                        {
                            data: 'answer',
                            name: 'answer'
                        },
                        {
                            data: 'score',
                            name: 'score'
                        },
                        {
                            data: 'action',
                            name: 'action'
                        }
                    ]
                })
                $('#refresh').click(function() {
                    table.ajax.reload()
                })
                //Date range picker with time picker
                $('#reservationdate').datetimepicker({
                    format: 'YYYY-MM-D'
                });
                $('#examEnd').datetimepicker({
                    format: 'YYYY-MM-D'
                });
                $('#submit-exam-head').click(function() {
                    Swal.fire({
                        title: 'Wait ...',
                        didOpen() {
                            Swal.showLoading()
                        },
                        willClose() {
                            Swal.hideLoading()
                        },
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        allowEnterKey: false
                    })
                    let urlUpdate = "{{ route('Admin.quiz.update', ':id') }}"
                    urlUpdate = urlUpdate.replace(':id', "{{ $id }}")
                    $.ajax({
                        url: urlUpdate,
                        data: `${$('#postExam').serialize()}&_token={{ csrf_token() }}`,
                        dataType: 'json',
                        type: 'post',
                        success: function(params) {
                            Swal.close()
                            exam_id = params.id
                            $('#exam-id').val(params.id)
                            $("#postExam")[0].reset();
                            $("#postExam :input").prop("disabled", true)
                            $('#submit-exam-head').prop('disabled', true)
                            $('#fill-exam-question').prop('disabled', false)

                            Swal.fire({
                                icon: 'success',
                                title: params.message,
                            })
                        },
                        error: function(xhr, thr, err) {
                            Swal.close()
                            Swal.fire({
                                icon: 'error',
                                title: xhr.responseJSON.message
                            })
                        }
                    })
                })
                $('#fill-exam-question').click(function() {
                    $('#exam-question').modal({backdrop: 'static', keyboard: false})
                    $('.modal-title').text('Add Exam Question')
                    $('input[name=update]').prop('disabled',true)

                })
                $('#save-question').click(function() {
                    waitProcess()
                    $.ajax({
                        url: "{{ route('Admin.question.store') }}",
                        data: `${$('#postQuestion').serialize()}&_token={{ csrf_token() }}`,
                        dataType: 'json',
                        type: 'post',
                        success: function(params) {
                            Swal.close()
                            Swal.fire({
                                icon: 'success',
                                title: params.message,
                            })
                            $('#postQuestion')[0].reset()
                            $('.close-modal').trigger('click')
                            table.ajax.reload()
                        },
                        error: function(xhr, thr, err) {
                            Swal.close()
                            Swal.fire({
                                icon: 'error',
                                title: xhr.responseJSON.message
                            })
                            table.ajax.reload()
                        }
                    })
                })
                $('#table-exam tbody').on('click','.edit',table,function(){
                    $('#fill-exam-question').trigger('click')
                    $('.modal-title').text('Edit Exam Question')
                    waitProcess()
                    let urlUpdate ="{{route('Admin.question.edit',':id')}}"
                        urlUpdate = urlUpdate.replace(':id',$(this).data('id'))
                    $.ajax({
                        url: urlUpdate,
                        success: function(params){
                            $('input[name=id]').val(params.data.id)
                            $('input[name=update]').prop('disabled',false)
                            $('input[name=question]').val(params.data.question)
                            $('input[name=answer][value='+params.data.answer+']').prop('checked',true)
                            $('.option-a').val(params.data.option.a)
                            $('.option-b').val(params.data.option.b)
                            $('.option-c').val(params.data.option.c)
                            $('.option-d').val(params.data.option.d)
                            Swal.close()
                        },error:function(xhr, thr, err){
                        }

                    })

                })
                $('.close-modal').click(function(){
                    $('#postQuestion')[0].reset()
                })

            })
        </script>
    </x-slot>
</x-custom-layout.app-layout>
