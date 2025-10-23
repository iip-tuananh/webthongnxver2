@extends('layouts.main')

@section('css')
@endsection

@section('page_title')
Quản lý hoa hồng
@endsection

@section('title')
    Quản lý hoa hồng
@endsection

@section('buttons')
@endsection
@section('content')
<div ng-cloak>
    <div class="row" ng-controller="Orders">
        <div class="col-12">
            <div class="card">
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="table-list">
                    </table>
                </div>
            </div>
        </div>



    </div>



</div>
@endsection

@section('script')
{{--@include('admin.orders.Order')--}}
<script>
    let datatable = new DATATABLE('table-list', {
        ajax: {
            url: '/admin/commissions/searchData',
            data: function (d, context) {
                DATATABLE.mergeSearch(d, context);
            }
        },
        columns: [
            {data: 'DT_RowIndex', orderable: false, title: "STT", className: "text-center"},
            {data: 'code', title: 'Mã đối soát'},
            {
                data: 'order',
                title: 'Đơn hàng',
                render: (order) => {
                    // order có thể là {id, code} hoặc chỉ id
                    if (!order) return '';
                    const id = order.id ?? order;
                    const code = order.code ?? `#${id}`;
                    return `<a href="/admin/orders/${id}/show" class="link-order">${code}</a>`;
                },
                className: 'dt-body-left',
                width: '14%',
                responsivePriority: 1
            },
            {data: 'nguoi_duoc_gioi_thieu_id', title: 'Người nhận hoa hồng'},
            {data: 'nguoi_gioi_thieu_id', title: 'Người giới thiệu'},
            {data: 'base_amount', title: 'Giá trị đơn hàng'},
            {data: 'percent', title: 'Tỷ  lệ(%)'},
            {data: 'amount_commissions', title: 'Hoa hồng được hưởng'},
            {
                data: 'status',
                title: "Trạng thái",
                render: function (data) {
                    return getStatus(data, @json(\App\Model\Admin\Commission::STATUSES));
                },
                className: "text-center"
            },
            {data: 'created_at', title: 'Ngày tạo'},
            {data: 'updated_at', title: 'Ngày cập nhật'},
            {data: 'action', orderable: false, title: "Hành động"}
        ],
        search_columns: [
            {data: 'code', search_type: "text", placeholder: "Mã đối soát"},
            {data: 'order_code', search_type: "text", placeholder: "Mã đơn hàng"},
        ],
    }).datatable;

    createReviewCallback = (response) => {
        datatable.ajax.reload();
    }

    app.controller('Orders', function ($rootScope, $scope, $http) {
        $scope.loading = {};
        $scope.statues = @json(\App\Model\Admin\Order::STATUSES);
        $scope.form = {}

        $('#table-list').on('click', '.update-status', function () {
            event.preventDefault();
            $scope.data = datatable.row($(this).parents('tr')).data();
            console.log($scope.data);
            $scope.form.status = $scope.data.status;
            $scope.$apply();
            $('#update-status').modal('show');
        });

        $scope.submit = function () {
            $.ajax({
                type: 'POST',
                url: "{{route('orders.update.status')}}",
                headers: {
                    'X-CSRF-TOKEN': "{{csrf_token()}}"
                },
                data: {
                    order_id: $scope.data.id,
                    status:  $scope.form.status
                },
                success: function(response) {
                    if (response.success) {
                        toastr.success(response.message);
                    } else {
                        toastr.warning(response.message);
                    }
                },
                error: function(e) {
                    toastr.error('Đã có lỗi xảy ra');
                },
                complete: function() {
                    $('#update-status').modal('hide');
                    datatable.ajax.reload();
                    $scope.loading.submit = false;
                    $scope.$applyAsync();
                }
            });
        }
    })


</script>
@include('partial.confirm')
@endsection
