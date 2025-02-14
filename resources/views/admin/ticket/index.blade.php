@extends('layouts.master')
@section('title', 'Data Ticket')
@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Ticket</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item active">Ticket</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        {{-- <div class="card-header">
                            @can('ticket_create')
                            <a href="{{ route('tickets.create') }}" class="btn btn-md btn-secondary"> <i class="mdi mdi-plus"></i>  Create
                            </a>
                            @endcan
                        </div> --}}
                        <div class="card-body">
                            {{-- <div class="row">
                                <div class="col-md-3">
                                    <form method="get">
                                        @csrf
                                        <div class="input-group mb-4">
                                            <input type="text" class="form-control border-0 dash-filter-picker shadow"
                                                data-provider="flatpickr" data-range-date="true" data-date-format="d M, Y"
                                                data-deafult-date="01 Jan 2022 to 31 Jan 2022" value=""
                                                id="filter_date_merchant" />
                                            <div class="input-group-text bg-primary border-primary text-white">
                                                <i class="ri-calendar-2-line"></i>
                                            </div>
                                        </div>
                                        <!--end row-->
                                    </form>
                                </div>
                                <div class="col-md-3">
                                    <form method="get">
                                        @csrf
                                        <div class="input-group mb-4">
                                            <select name="kabkot_id" id="kota" class="form-control">
                                                <option value="">-- Filter By City --</option>

                                            </select>
                                        </div>
                                        <!--end row-->
                                    </form>
                                </div>
                                <div class="col-md-3">
                                    <form method="get">
                                        @csrf
                                        <div class="input-group mb-4">
                                            <select name="kabkot_id" id="kota" class="form-control">
                                                <option value="">-- Filter By MCC --</option>

                                            </select>
                                        </div>
                                        <!--end row-->
                                    </form>
                                </div>
                            </div> --}}
                            <div class="table-responsive">
                                <table class="table table-bordered table-sm" id="dataTable">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>{{ __('Branches') }}</th>
                                            <th>{{ __('Cluster') }}</th>
                                            <th>{{ __('Subject') }}</th>
                                            <th>{{ __('Status') }}</th>
                                            <th>{{ __('Update By') }}</th>
                                            <th>{{ __('Created At') }}</th>
                                            <th>{{ __('Updated At') }}</th>
                                            @canany(['ticket_show', 'ticket_update', 'ticket_delete'])
                                            <th>{{ __('Action') }}</th>
                                            @endcanany
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    </div>
@endsection
@push('js')
    <script>
        let base_url = "{{ url('/') }}";

        const action =
            '{{ auth()->user()->can('ticket_update') || auth()->user()->can('ticket_delete')? 'yes yes yes': '' }}'

        let columns = [{
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                orderable: false,
                searchable: false
            }, {
                data: 'branches',
                name: 'branches',
            },
            {
                data: 'cluster',
                name: 'cluster',
            },
            {
                data: 'subject',
                name: 'subject',
            },
            {
                data: 'status',
                name: 'status',
            },
            {
                data: 'user',
                name: 'user',
            },
            {
                data: 'created_at',
                name: 'created_at'
            },
            {
                data: 'updated_at',
                name: 'updated_at'
            }
        ];

        if (action) {
            columns.push({
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            })
        }

        const params = new Proxy(new URLSearchParams(window.location.search), {
            get: (searchParams, prop) => searchParams.get(prop),
        });
        // Get the value of "some_key" in eg "https://example.com/?some_key=some_value"
        let query = params.parsed_data; // "some_value"
        var table = $('#dataTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('tickets.index') }}",
                data: function(s) {
                    s.parsed_data = query
                }
            },
            columns: columns
        });
    </script>
@endpush
