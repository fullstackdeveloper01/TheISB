@extends('backend.layouts.form')
@section('title', __('Account Details'))
@section('container', 'container-max-lg')
@section('content')
    <form id="vironeer-submited-form" action="{{ route('admin.account.details.update') }}" method="POST"
        enctype="multipart/form-data">
        @csrf
        <div class="card p-2">
            <div class="card-body">
                <div class="avatar text-center py-4">
                    <img id="filePreview" src="{{ asset(adminAuthInfo()->avatar) }}" alt="{{ adminAuthInfo()->name }}"
                        class="rounded-circle mb-3" width="120px" height="120px">
                    <button id="selectFileBtn" type="button"
                        class="btn btn-secondary d-flex m-auto">{{ __('Choose Image') }}</button>
                    <input id="selectedFileInput" type="file" name="avatar" accept="image/png, image/jpg, image/jpeg"
                        hidden>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label class="form-label">{{ __('First Name') }} : <span
                                    class="red">*</span></label>
                            <input type="firstname" class="form-control form-control-lg" name="firstname"
                                value="{{ adminAuthInfo()->firstname }}" required>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label class="form-label">{{ __('Last Name') }} : <span
                                    class="red">*</span></label>
                            <input type="lastname" class="form-control form-control-lg" name="lastname"
                                value="{{ adminAuthInfo()->lastname }}" required>
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">{{ __('Email Address') }} : <span
                            class="red">*</span></label>
                    <input type="email" class="form-control form-control-lg" name="email"
                        value="{{ adminAuthInfo()->email }}" required>
                </div>
            </div>
        </div>
    </form>
@endsection
