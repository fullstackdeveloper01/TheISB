@extends('backend.layouts.form')
@section('title', $marina->firstname . ' ' . $marina->lastname . ' | Details')
@section('back', route('admin.marinas.index'))
@section('content')
    
    {{--
    @if (!is_null($subscription) && $subscription->status)
        <div class="row g-3 mb-4">
            <div class="col-12 col-lg col-xxl">
                <div class="vironeer-counter-box bg-lg-8 h-100">
                    <h3 class="vironeer-counter-box-title">{{ __('Marinas Spend') }}</h3>
                    <p class="vironeer-counter-box-number">{{ 0 }}</p>
                    <small>{{ __('Taxes and fees included') }}</small>
                    <span class="vironeer-counter-box-icon">
                        <i class="fas fa-dollar-sign"></i>
                    </span>
                </div>
            </div>
            <div class="col-12 col-lg col-xxl">
                <div class="vironeer-counter-box bg-lg-1 h-100">
                    <h3 class="vironeer-counter-box-title">{{ __('Marinas Plan') }}</h3>
                    <p class="vironeer-counter-box-number">{{ $subscription->plan->name }}
                        @if ($subscription->plan->interval == 0)
                            ({{ __('Monthly') }})
                        @elseif($subscription->plan->interval == 1)
                            ({{ __('Yearly') }})
                        @elseif($subscription->plan->interval == 2)
                            ({{ __('Lifetime') }})
                        @endif
                    </p>
                    @if ($subscription->expiry_at)
                        <small>{{ __('Expiry at') . ' : ' . vDate($subscription->expiry_at) }}</small>
                    @endif
                    <span class="vironeer-counter-box-icon">
                        <i class="far fa-gem"></i>
                    </span>
                </div>
            </div>
            <div class="col-12 col-lg col-xxl">
                <div class="vironeer-counter-box bg-lg-4 h-100">
                    <h3 class="vironeer-counter-box-title">{{ __('Marina Transfers') }}</h3>
                    <p class="vironeer-counter-box-number">{{ '0' }}</p>
                    <small>{{ __('Canceled transfers included') }}</small>
                    <span class="vironeer-counter-box-icon">
                        <i class="fas fa-paper-plane"></i>
                    </span>
                </div>
            </div>
        </div>
    @endif
    @if (is_null($subscription))
        <div class="alert alert-primary">
            <strong>{{ $marina->firstname }}</strong> {{ __('is not subscribed') }}
        </div>
    @endif
    @if (!is_null($subscription) && !$subscription->status)
        <div class="alert alert-danger">
            {{ __('User subscription has been canceled') }}
        </div>
    @endif
    --}}
    <div class="row">
        <div class="col-lg-3">
           @include('backend.marinas.sidebar')
        </div>
        <div class="col-lg-9">
            <form id="vironeer-submited-form" action="{{ route('admin.marinas.update', $marina->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="card custom-card mb-3">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-4 my-1">
                                <label class="form-label">{{ __('Account status') }} : </label>
                                <input type="checkbox" name="status" data-toggle="toggle" data-on="{{ __('Active') }}"
                                    data-off="{{ __('Banned') }}" @if ($marina->status) checked @endif>
                            </div>
                            <div class="col-lg-4 my-1">
                                <label class="form-label">{{ __('Email status') }} : </label>
                                <input type="checkbox" name="email_status" data-toggle="toggle"
                                    data-on="{{ __('Verified') }}" data-off="{{ __('Unverified') }}"
                                    @if (!is_null($marina->email_verified_at)) checked @endif>
                            </div>
                            {{--<div class="col-lg-4 my-1">
                                <label class="form-label">{{ __('Two-Factor Authentication') }} : </label>
                                <input id="2faCheckbox" type="checkbox" name="google2fa_status" data-toggle="toggle"
                                    data-on="{{ __('Active') }}" data-off="{{ __('Disabled') }}"
                                    @if ($marina->google2fa_status) checked @endif>
                            </div>--}}
                        </div>
                    </div>
                </div>
                <div class="card custom-card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label class="form-label">{{ __('Marina Name') }} :<span
                                            class="red">*</span></label>
                                    <input type="firstname" name="firstname" class="form-control"
                                        value="{{ $marina->firstname }}" required>
                                </div>
                            </div>
                            <div class="col-lg-6" style="display:none;">
                                <div class="mb-3">
                                    <label class="form-label">{{ __('Marina Lastname') }} :<span
                                            class="red">*</span></label>
                                    <input type="lastname" name="lastname" class="form-control"
                                        value="{{ $marina->lastname }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            {{--<div class="col-lg-4" style="display:none;">
                                <div class="mb-3">
                                    <label class="form-label">{{ __('Username') }} :<span
                                            class="red">*</span></label>
                                    <input type="username" name="username" class="form-control" value="{{ $marina->username }}"
                                        required>
                                </div>
                            </div>--}}
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">{{ __('E-mail Address') }} :<span
                                            class="red">*</span></label>
                                    <div class="input-group mb-3">
                                        <input type="email" name="email" class="form-control" value="{{ $marina->email }}"
                                            required>
                                        {{--<button class="btn btn-dark" type="button" data-bs-toggle="modal"
                                            data-bs-target="#sendMailModal"><i
                                                class="far fa-paper-plane me-2"></i>{{ __('Send Email') }}</button>--}}
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">{{ __('Phone number') }} :<span
                                            class="red">*</span></label>
                                    <input type="mobile" name="mobile" class="form-control" value="{{ $marina->mobile }}"
                                        required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">{{ __('City') }} :<span class="red">*</span></label>
                                    <select name="city_id" class="form-select select2" required>
                                        <option value=""></option>
                                        @foreach ($cityList as $city)
                                            <option value="{{ $city->id }}" {{ ($marina->city_id == $city->id)?'selected':'' }}>{{ $city->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3" style="display: none;">
                            <label class="form-label">{{ __('Address line 1') }} :</label>
                            <input type="text" name="address_1" class="form-control"
                                value="{{ @$marina->address->address_1 }}">
                        </div>
                        <div class="mb-3" style="display: none;">
                            <label class="form-label">{{ __('Address line 2') }} :</label>
                            <input type="text" name="address_2" class="form-control"
                                placeholder="{{ __('Apartment, suite, etc. (optional)') }}"
                                value="{{ @$marina->address->address_2 }}">
                        </div>
                        <div class="row" style="display: none;">
                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label class="form-label">{{ __('City') }} :</label>
                                    <input type="text" name="city" class="form-control"
                                        value="{{ @$marina->address->city }}">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label class="form-label">{{ __('State') }} :</label>
                                    <input type="text" name="state" class="form-control"
                                        value="{{ @$marina->address->state }}">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label class="form-label">{{ __('Postal code') }} :</label>
                                    <input type="text" name="zip" class="form-control"
                                        value="{{ @$marina->address->zip }}">
                                </div>
                            </div>
                        </div>
                        <div class="mb-2" style="display: none;">
                            <label class="form-label">{{ __('Country') }} :</label>
                            <select name="country" class="form-select">
                                <option value="" selected disabled>{{ __('Choose') }}</option>
                                @foreach (countries() as $country)
                                    <option value="{{ $country->id }}"
                                        @if ($country->name == @$marina->address->country) selected @endif>
                                        {{ $country->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="modal fade" id="sendMailModal" tabindex="-1" aria-labelledby="sendMailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="sendMailModalLabel">{{ __('Send Mail to ') }}{{ $marina->email }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.marinas.sendmail', $marina->id) }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">{{ __('Subject') }} : <span
                                            class="red">*</span></label>
                                    <input type="subject" name="subject" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">{{ __('Reply to') }} : <span
                                            class="red">*</span></label>
                                    <input type="email" name="reply_to" class="form-control"
                                        value="{{ adminAuthInfo()->email }}" required>
                                </div>
                            </div>
                        </div>
                        <textarea name="message" id="content-small" rows="10" required></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">{{ __('Send') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
