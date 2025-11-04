<div class="row">
    <div class="col-md-2">

    </div>
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h6>Thông tin</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Tên</label>
                            <span class="text-danger">(*)</span>
                            <input class="form-control" type="text" ng-model="form.name">
                            <span class="invalid-feedback d-block" role="alert">
								<strong><% errors.name[0] %></strong>
							</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Email</label>
                            <span class="text-danger">(*)</span>
                            <input class="form-control" type="text" ng-model="form.email">
                            <span class="invalid-feedback d-block" role="alert">
								<strong><% errors.email[0] %></strong>
							</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Tên đăng nhập</label>
                            <span class="text-danger">(*)</span>
                            <input class="form-control" type="text" ng-model="form.account_name" disabled>
                            <span class="invalid-feedback d-block" role="alert">
								<strong><% errors.account_name[0] %></strong>
							</span>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">SĐT</label>
                            <input class="form-control" type="text" ng-model="form.phone_number">
                        </div>
                    </div>


                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Mật khẩu</label>
                            <span class="text-danger">(*)</span>
                            <div class="input-group mb-0">
                                <input class="form-control" type="password" ng-model="form.password">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary show-password" type="button"><i class="fa fa-eye muted"></i></button>
                                </div>
                            </div>
                            <span class="invalid-feedback d-block" role="alert">
								<strong><% errors.password[0] %></strong>
							</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Xác nhận mật khẩu</label>
                            <span class="text-danger">(*)</span>
                            <div class="input-group mb-0">
                                <input class="form-control" type="password" ng-model="form.password_confirm">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary show-password" type="button"><i class="fa fa-eye muted"></i></button>
                                </div>
                            </div>
                            <span class="invalid-feedback d-block" role="alert">
								<strong><% errors.password_confirm[0] %></strong>
							</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="col-md-2">

    </div>
</div>
<hr>
<div class="text-right">
    <button type="submit" class="btn btn-success btn-cons" ng-click="submit()" ng-disabled="loading.submit">
        <i ng-if="!loading.submit" class="fa fa-save"></i>
        <i ng-if="loading.submit" class="fa fa-spin fa-spinner"></i>
        Lưu
    </button>
</div>
