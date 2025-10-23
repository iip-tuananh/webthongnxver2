@extends('layouts.main')

@section('css')
@endsection

@section('page_title')
    Chi tiết hoa hồng
@endsection

@section('title')
    Chi tiết hoa hồng
@endsection

@section('buttons')
@endsection

@section('content')

    <style>
        .form-label{ font-weight:700; margin-bottom:4px; }
        .form-value{ font-weight:600; color:#111; }
        .fw-700{ font-weight:700; }
        .card-header .btn{ padding:4px 10px; }
        .badge.bg-secondary{ background:#6c757d !important; }
        .badge.bg-success{ background:#16a34a !important; }
        .badge.bg-danger{ background:#dc2626 !important; }
        .badge.bg-primary{ background:#2563eb !important; }
        @media (max-width: 767.98px){
            .card-header h6{ margin-bottom:8px; }
        }

        .bank-box{
            border:1px dashed #e5e7eb; border-radius:8px; padding:12px; background:#fafafa;
        }
        .bank-row{
            display:flex; align-items:center; justify-content:space-between;
            gap:12px; padding:8px 0; border-bottom:1px solid #f1f1f1;
        }
        .bank-row:last-child{ border-bottom:0; }
        .bank-label{ color:#6b7280; font-weight:700; }
        .bank-value{ font-weight:700; color:#111; display:flex; align-items:center; gap:8px; }
        .btn.btn-xs{ padding:0 4px; font-size:12px; line-height:1.4; }

    </style>

<div ng-controller="Order" ng-cloak>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h6 class="mb-0">Hoa hồng đơn hàng #<% form.order.code || form.code %></h6>
                    <a class="btn btn-sm btn-outline-primary"
                       ng-if="form.order_id"
                       ng-href="/admin/orders/<% form.order_id %>/show">
                        Xem đơn hàng
                    </a>
                </div>

                <div class="card-body">
                    <div class="row g-3">

                        <!-- Cột trái -->
                        <div class="col-md-6">
                            <!-- Mã đơn hàng -->
                            <div class="form-group mb-3">
                                <label class="form-label text-muted d-block">Mã đơn hàng</label>
                                <div class="form-value">
                                    #<% form.order.code || form.code %>
                                </div>
                            </div>

                            <!-- Người nhận hoa hồng (referred) -->
                            <div class="form-group mb-3">
                                <label class="form-label text-muted d-block">Người nhận hoa hồng</label>
                                <div class="form-value">
                                    <% form.nguoiduocgioithieu.fullname %>
                                    <span class="text-muted"> – <% form.nguoiduocgioithieu.code %></span>
                                    <a ng-if="form.nguoi_duoc_gioi_thieu_id"
                                       ng-href="/admin/customers/<% form.nguoiduocgioithieu.id %>/show"
                                       class="ms-2 text-primary" title="Xem chi tiết">
                                        <i class="fa fa-user-circle"></i>
                                    </a>
                                </div>
                            </div>


                            <!-- Thông tin ngân hàng (người nhận) -->
                            <div class="form-group mb-3 bank-box">
                                <label class="form-label text-muted d-block">Thông tin ngân hàng (người nhận)</label>

                                <div class="bank-row">
                                    <span class="bank-label">Ngân hàng</span>
                                    <span class="bank-value">
      <% (form.nguoiduocgioithieu && form.nguoiduocgioithieu.bank_name) || '—' %>
    </span>
                                </div>

                                <div class="bank-row">
                                    <span class="bank-label">Số tài khoản</span>
                                    <span class="bank-value">
      <% (form.nguoiduocgioithieu && form.nguoiduocgioithieu.bank_number) || '—' %>
                                        <!-- nút copy (tuỳ chọn) -->
      <button type="button" class="btn btn-xs btn-link ps-2"
              ng-if="form.nguoiduocgioithieu && form.nguoiduocgioithieu.bank_number"
              ng-click="copyToClipboard(form.nguoiduocgioithieu.bank_number)">
        Sao chép
      </button>
    </span>
                                </div>

                                <div class="bank-row">
                                    <span class="bank-label">Chủ tài khoản</span>
                                    <span class="bank-value">
      <% (form.nguoiduocgioithieu && form.nguoiduocgioithieu.user_bank_name) || '—' %>
    </span>
                                </div>


                            </div>




                            <!-- Người giới thiệu (referrer) -->
                            <div class="form-group mb-3">
                                <label class="form-label text-muted d-block">Người giới thiệu</label>
                                <div class="form-value">
                                    <% form.nguoigioithieu.fullname %>
                                    <span class="text-muted"> – <% form.nguoigioithieu.code %></span>
                                    <a ng-if="form.nguoi_gioi_thieu_id"
                                       ng-href="/admin/customers/<% form.nguoigioithieu.id %>/show"
                                       class="ms-2 text-primary" title="Xem chi tiết">
                                        <i class="fa fa-user-circle"></i>
                                    </a>
                                </div>
                            </div>

                            <!-- Ngày tạo -->
                            <div class="form-group mb-3">
                                <label class="form-label text-muted d-block">Ngày tạo</label>
                                <div class="form-value">
                                    <% form.created_at | date:'dd/MM/yyyy HH:mm' %>
                                </div>
                            </div>
                        </div>

                        <!-- Cột phải -->
                        <div class="col-md-6">
                            <!-- Giá trị tính hoa hồng -->
                            <div class="form-group mb-3">
                                <label class="form-label text-muted d-block">Giá trị tính hoa hồng</label>
                                <div class="form-value fw-700">
                                    <% (form.base_amount) | number %>₫
                                </div>
                            </div>

                            <!-- % hoa hồng -->
                            <div class="form-group mb-3">
                                <label class="form-label text-muted d-block">Phần trăm tính hoa hồng</label>
                                <div class="form-value">
                                    <% form.percent | number:2 %>%
                                </div>
                            </div>

                            <!-- Tiền hoa hồng -->
                            <div class="form-group mb-3">
                                <label class="form-label text-muted d-block">Số tiền hoa hồng được hưởng</label>
                                <div class="form-value h5 mb-0">
                                    <strong><% form.amount_commissions | number %>₫</strong>
                                </div>
                            </div>

                            <!-- Trạng thái (Admin chọn) -->
                            <div class="form-group mb-1">
                                <label class="form-label text-muted d-block">Trạng thái</label>
                                <select class="form-control form-control-sm w-auto"
                                        ng-model="form.status"
                                        ng-options="s.id as s.name for s in statuses">
                                </select>
                                <!-- Badge trạng thái hiện tại -->
                                <span class="ms-2 badge"
                                      ng-class="{
                    'bg-secondary': form.status==='PENDING' || form.status==10,
                    'bg-success'  : form.status==='APPROVED' || form.status==20,
                    'bg-danger'   : form.status==='REJECTED' || form.status==30,

                  }">
          <% (((statuses | filter:{id:form.status})[0] && (statuses | filter:{id:form.status})[0].name) || form.status) %>
            </span>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>


    <hr>

    <div class="text-right">
        <button type="button" class="btn btn-success btn-cons" ng-click="submit()" ng-disabled="loading.submit">
            <i ng-if="!loading.submit" class="fa fa-save"></i>
            <i ng-if="loading.submit" class="fa fa-spin fa-spinner"></i>
            Lưu
        </button>

        <a href="{{ route('orders.index') }}" class="btn btn-danger btn-cons">
            <i class="fa fa-remove"></i> Quay lại
        </a>
    </div>
</div>
@endsection

@section('script')
    @include('admin.orders.Order')

    <script>
        app.controller('Order', function ($scope, $http) {
            $scope.form = new Order(@json($order), {scope: $scope});
            $scope.statuses = @json(\App\Model\Admin\Commission::STATUSES);
            $scope.$applyAsync();

            $scope.getStatus = function (status) {
                let obj = $scope.statuses.find(val => val.id == status);
                return obj.name;
            }
            $scope.loading = {};
            $scope.submit = function () {
                $scope.loading.submit = true;
                let data = {
                    commission_id: $scope.form.id,
                    status: $scope.form.status,
                };

                $.ajax({
                    type: 'POST',
                    url: "/admin/commissions/update-status",
                    headers: {
                        'X-CSRF-TOKEN': CSRF_TOKEN
                    },
                    data: data,
                    success: function (response) {
                        if (response.success) {
                            toastr.success(response.message);
                            window.location.href = "{{ route('commissions.index') }}";
                        } else {
                            toastr.warning(response.message);
                            $scope.errors = response.errors;
                        }
                    },
                    error: function (e) {
                        toastr.error('Đã có lỗi xảy ra');
                    },
                    complete: function () {
                        $scope.loading.submit = false;
                        $scope.$applyAsync();
                    }
                });
            }

            $scope.copyToClipboard = function (text) {
                if (!text) return;
                if (navigator.clipboard && navigator.clipboard.writeText) {
                    navigator.clipboard.writeText(text);
                } else {
                    const ta = document.createElement('textarea');
                    ta.value = text; document.body.appendChild(ta);
                    ta.select(); document.execCommand('copy'); document.body.removeChild(ta);
                }
            };
        });



    </script>
@endsection
