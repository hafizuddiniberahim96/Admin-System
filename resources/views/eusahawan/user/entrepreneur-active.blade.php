@extends('layouts.template.base')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{asset('/app-assets/vendors/css/tables/datatable/datatables.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/app-assets/vendors/css/forms/selects/select2.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/css/filter-style.css')}}">
@endsection

@section('content')
<div class="container-fluid ">
    <div class="fade-in">
        <div class="card">
            <div class="card-body">
                <form id="form-filters" class="form form-horizontal form-bordered">
                    <div class="form-body">
                        <div class="form-group row mx-auto">
                            <label class="col-sm-3 label-control" for="company_registered">Company Registered</label>
                            <div class="col-sm-9">
                                <div class="position-relative">
                                    <input type="text" class = "form-control" id="company_registered" name="company_registered">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row mx-auto">
                            <label class="col-sm-3 label-control" for="sector">Sector</label>
                            <div class="col-sm-9">
                                <div class="position-relative">
                                    <input type="text" class = "form-control" id="sector" name="sector">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row mx-auto">
                            <label class="col-sm-3 label-control" for="region">Region</label>
                            <div class="col-sm-9">
                                <div class="position-relative">
                                    <input type="text" class = "form-control" id="region" name="region">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row mx-auto">
                            <label class="col-sm-3 label-control" for="state">State</label>
                            <div class="col-sm-9">
                                <div class="position-relative">
                                    <input type="text" class = "form-control" id="state" name="state">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 mb-1">
                                <button class="btn mt-1 btn-info float-right" id="filterbtn"
                                        type="button"><i class="la la-filter"></i> Apply
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">List</h4>
            </div>
            <div class="card-body">
                <div class="row">
                <div class="col s12" style="overflow: auto">
                    <table id="table" class="table table-striped table-bordered dataTable no-footer"></table>
                </div>
                </div>  
            </div>
        </div>
        <div class="modal fade" id="assign-mentor" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">   
            <form  method="POST" class="modal_form"  id="modal_form">
                @csrf
                <div class="modal-content">
                
                    <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Assign Mentor Supervision</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="debug-url" data-error="wrong" data-success="right" for="defaultForm-email">Mentor Name</label>
                            <input type="text" name="mentor_name" class="form-control mentor_name" disabled >
                        </div> 
                        <div class="form-group">
                            <label class="debug-url" data-error="wrong" data-success="right" for="defaultForm-email">Student Name</label>
                            <input type="text" name="name" class="form-control name" disabled >
                        </div> 
                        <div class="form-group">
                        <label  data-success="right" for="defaultForm-email">Mentor</label>
                            <select class="form-control custom-select" name="mentor_id" id="mentor" required>
                                <option value=""></option>
                                @foreach ($mentors as $mentor)
                                    <option value="{{ $mentor->_id }}">{{ ucfirst($mentor->details->fullName)}}</option>
                                @endforeach                       
                            </select>
                    </div>                  
                    </div>
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <button type="submit" form="modal_form" class="btn btn-success btn-ok text-white">Confirm</button>
                    </div>
                </div>
            </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('javascript')
    <script type="text/javascript" src="{{asset('js/admire/components.js')}}"></script>
    <script src="{{asset('/app-assets/vendors/js/tables/datatable/datatables.min.js')}}"></script>
    <script src="{{asset('/app-assets/vendors/js/extensions/dropzone.min.js')}}"></script>
    <script src="{{asset('/app-assets/vendors/js/jquery-toast/jquery.toast.min.js')}}"></script>
    <script src="{{asset('/app-assets/vendors/js/forms/select/select2.full.min.js')}}"></script>

    
    <script>
        $(".select2").select2({
            closeOnSelect: false
        });

        $(document).ready(function() {
            $('#assign-mentor').on('show.bs.modal', function(e) {
                var name = $(e.relatedTarget).data('value');
                var mentor_name = $(e.relatedTarget).data('mentor');
                $('.name').val(name);
                $('.mentor_name').val(mentor_name);
                
                $(this).find('#modal_form').attr('action', $(e.relatedTarget).data('href'));
            });

            $('#filterbtn').click(function(){
                const filter = [
                    $('#company_registered').val(),
                    $('#sector').val(),
                    $('#region').val(),
                    $("#state").val()
                ];
                console.log(filter);
                var table = $('.table').DataTable();
                for (let i = 0; i < filter.length; i++){
                    // if(filter[i] != "") 
                        table.column(i+2).search(filter[i]).draw();
                }
 
        });

        });
         
        $(function () {
            var table = $('.table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('myeusahawan.user.list-users',['entrepreneur']) }}",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', title: "#", searchable: false, orderable: false},
                    {data: 'fullName', name: 'fullName', title: "Name"},
                    {data: 'company', name: 'company', title: "Company"},
                    {data: 'sector', name: 'sector', title: "Sector"},            
                    {data: 'region_company', name: 'region_company', title: "Region"},
                    {data: 'state_company', name: 'state_company', title: "State"},
                    {data: 'created_at', name: 'year', title: "Year Establish"},
                    {data: 'action', name: 'action', title: "Action"}
                ]
                    });
        });        
    </script>

@endsection