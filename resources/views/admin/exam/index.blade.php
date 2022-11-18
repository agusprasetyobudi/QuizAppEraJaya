<x-custom-layout.app-layout>
    <x-slot name='css'>
        <!-- DataTables -->
        <link rel="stylesheet" href="{{asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
        <link rel="stylesheet" href="{{asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
        <link rel="stylesheet" href="{{asset('assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
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
                            <li class="breadcrumb-item"><a href="{{route('Admin.Dashboard')}}">Home</a></li>
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
                                <div class="row">
                                    <div class="col-md-10">

                                    </div>
                                    <div class="col-md-2">
                                        <a href="{{route('Admin.quiz.create')}}" class="btn btn-primary btn-outline float-right"><i class="fas fa-plus"></i> Add Exam</a>
                                    </div>
                                </div>
                                {{-- <h5 class="card-title">Card title</h5> --}}
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered table-hover" id="table-exam" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th class="text-center">Exam Name</th>
                                            <th class="text-center">Exam Duration</th>
                                            <th class="text-center">Exam Start</th>
                                            <th class="text-center">Exam End</th>
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
    </x-slot>
    <x-slot name='js'>

        <!-- DataTables  & Plugins -->
        <script src="{{asset('assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>
        <script src="{{asset('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
        <script src="{{asset('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
        <script src="{{asset('assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
        <script src="{{asset('assets/plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
        <script src="{{asset('assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js')}}"></script>
        <script src="{{asset('assets/plugins/jszip/jszip.min.js')}}"></script>
        <script src="{{asset('assets/plugins/pdfmake/pdfmake.min.js')}}"></script>
        <script src="{{asset('assets/plugins/pdfmake/vfs_fonts.js')}}"></script>
        <script src="{{asset('assets/plugins/datatables-buttons/js/buttons.html5.min.js')}}"></script>
        <script src="{{asset('assets/plugins/datatables-buttons/js/buttons.print.min.js')}}"></script>
        <script src="{{asset('assets/plugins/datatables-buttons/js/buttons.colVis.min.js')}}"></script>
        <script>
            $(document).ready(function(){
                let table = $('#table-exam').DataTable({
                    ajax: "{{route('Admin.quiz.index')}}",
                    columnDefs:[
                        {className: 'text-center',targets:'_all'}
                    ],
                    columns:[
                        {data:'DT_RowIndex',name: 'DT_RowIndex'},
                        {data:'name',name:'name'},
                        {data:'duration',name:'duration'},
                        {data:'exam_start',name:'exam_start'},
                        {data:'exam_end',name:'exam_end'},
                        {data:'action', name:'action'}
                    ]
                })
                $('#table-exam tbody').on('click','.delete',table,function(){
                    Swal.fire({
                        title: 'Are you sure delete ?',
                        icon: 'warning',
                        showCancelButton: true,
                        confrimButtonText: 'Delete !!'
                    }).then((result)=>{
                        if(result.isConfirmed){
                            let urlDelete = "{{route('Admin.quiz.destroy',':id')}}"
                                urlDelete = urlDelete.replace(':id',$(this).data('id'))
                            waitProcess()
                            $.ajax({
                                url:urlDelete,
                                headers:{
                                    'X-CSRF-TOKEN': "{{csrf_token()}}"
                                },
                                type: 'delete',
                                success: function(params){
                                    Swal.close()
                                    Swal.fire({
                                        title: params.message,
                                        icon: 'success',
                                    })
                                    table.ajax.reload()
                                },error:function(xhr, thr, err){
                                    Swal.close()
                                    Swal.fire({
                                        title: xhr.responseJSON.message,
                                        icon: 'error',
                                    })
                                    table.ajax.reload()
                                }
                            })
                        }
                    })
                })
            })
        </script>
    </x-slot>
</x-custom-layout.app-layout>
