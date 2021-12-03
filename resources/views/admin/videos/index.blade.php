@extends('admin.layouts.app')
@section('content')
    <div class="content-body">
        <section class="user">
            <div class="row">
                <div class="col-sm-12 col-12">
                    <div class="page-header align-items-center d-flex justify-content-between">
                        <div class="page-tital total">
                            <div class="align-items-center d-flex">
                                <h1>Video<span>0 Total</span></h1>
                            </div>
                        </div>
                        {{-- <div class="page-tital-right ">
                            <div class="d-flex justify-content-between">
                                <div class="filter">
                                    <div>
                                        <a href="{{ route('admin.videos.create') }}" type="button"
                                            class="btn btn-primary btn-print mb-1 mb-md-0 waves-effect waves-light">
                                            <i class="feather icon-plus"></i> Add
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-12">
                    <div class="table-responsive">
                        <table class="table data-list-view category-table" id="category-management">
                            <thead>
                                <tr>
                                    <th class="min-w-200">Video</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
@section('footer-content')
    <script type="text/javascript">
        var table = $('#category-management').DataTable({
            responsive: true,
            // processing: true,
            serverSide: true,
            paging: true,
            ajax: {
                url: "{{ route('admin.videos.index') }}",
                dataSrc: function(json) {
                    $(".total")
                        .find("span")
                        .html(json.recordsFiltered + " Total");
                    return json.data;
                },
            },
            columns: [
                {
                    data: 'video',
                    render(data, type, full, meta) {
                        return ('<video width="160" height="120" controls><source src="' +
                            data + '"></video>');
                    },
                },
                {
                    data: 'status',
                    render(data, type, full, meta) {

                        let iReturn =
                            '<div class="custom-control custom-switch custom-switch-success custom-control-inline"> <input autocomplete="off"  type="checkbox" class="custom-control-input status"  data-video_id="' +
                            full.id +
                            '" id="customSwitch1' +
                            full.id +
                            '"';

                        if (data == 1) {
                            iReturn += " checked ";
                        }
                        iReturn +=
                            '/><label class="custom-control-label"for="customSwitch1' +
                            full.id +
                            '"></label></div>';

                        return iReturn;
                    },
                },
                {
                    data: 'id',
                    render(data, type, full, meta) {
                        return (
                            '<span style="font-size:25px; margin-left: 15px;" video_id="' +
                            data +
                            '"  class="deleteTab action-delete"><i class="fa fa-trash-o" style="color:red" aria-hidden="true"></i></span>'
                        );
                    },
                },
            ],
            columnDefs: [{
                    width: "20%",
                    targets: 1

                },
                {
                    orderable: false,
                    targets: "_all"
                },
            ],
            iDisplayLength: 10,
            drawCallback: function() {
                setToggleEvent();
            }
        });

        function setToggleEvent() {
            $(".status").click(function() {
                let id = $(this).data('video_id');
                let val = $(this).filter(':checked').val() == "on" ? 1 : 0;
                confomationDailog($(this), "{{ route('admin.videos.statusUpdate', '') }}", '/' + id,
                    'status', val);
            });

            $(".deleteTab").click(function() {
                let id = $(this).attr("video_id");
                confomationDailog($(this), "{{ route('admin.videos.delete', '') }}", '/' + id, '', "", "delete",
                    true);
            });
        }
    </script>
@endsection
