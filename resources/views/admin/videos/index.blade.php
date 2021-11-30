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
                                    <th>Title</th>
                                    <th>Slug</th>
                                    <th class="min-w-200">Video</th>
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
            columns: [{
                    data: 'title',
                },
                // {
                //     data: 'id',
                //     render(data, type, full, meta) {
                //         return ('<div class="banner-img"> <img onerror="this.onerror=null;this.src=\'{{ url(config('imagepath.default.category.image')) }}\'" src="' +
                //             full.web_image + '"> </div>');
                //     },
                // },
                {
                    data: 'slug',
                },
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
                            '<div class="custom-control custom-switch custom-switch-success custom-control-inline"> <input autocomplete="off"  type="checkbox" class="custom-control-input web_status"  data-banner_id="' +
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
                }
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
            $(".web_status").click(function() {
                let id = $(this).data('banner_id');
                let val = $(this).filter(':checked').val() == "on" ? 1 : 0;
                confomationDailog($(this), "{{ route('admin.videos.statusUpdate', '') }}", '/' + id,
                    'web_status', val);
            });
            $(".app_status").click(function() {
                let id = $(this).data('banner_id');
                let val = $(this).filter(':checked').val() == "on" ? 1 : 0;
                confomationDailog($(this), "{{ route('admin.videos.statusUpdate', '') }}", '/' + id,
                    'app_status', val);
            });
            $(".deleteTab").click(function() {
                let id = $(this).attr("banner_id");
                confomationDailog($(this), "{{ route('admin.videos.delete', '') }}", '/' + id, '', "", "delete",
                    true);
            });
            $(".editTab").click(function() {
                let id = $(this).attr("banner_id");
                window.location.replace("{{ route('admin.videos.edit', '') }}" + '/' + id);
            });
        }
    </script>
@endsection
