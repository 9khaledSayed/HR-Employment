@extends('layouts.dashboard')
@section('content')
    <!-- begin:: Content Head -->
    <div class="kt-subheader   kt-grid__item" id="kt_subheader">
        <div class="kt-container  kt-container--fluid ">
            <div class="kt-subheader__main">
                <h3 class="kt-subheader__title">
                    {{__('Customers')}}
                </h3>
                <span class="kt-subheader__separator kt-subheader__separator--v"></span>
            </div>
            <div class="kt-subheader__toolbar">
                <a href="#" class="">
                </a>
                <a href="{{route('dashboard.customers.index')}}" class="btn btn-secondary">
                    {{__('Back')}}
                </a>
            </div>
        </div>
    </div>
    <!-- end:: Content Head -->
    <!--begin::Portlet-->
    <div class="kt-portlet">
        <div class="kt-portlet__head">
            <div class="kt-portlet__head-label">
                <h3 class="kt-portlet__head-title">
                    {{__('New Customer')}}
                </h3>
            </div>
        </div>
        @include('layouts.dashboard.parts.errorSection')
        <!--begin::Form-->
        <form class="kt-form kt-form--label-right" method="POST" action="{{route('dashboard.customers.store')}}">
            @csrf
            <div class="kt-portlet__body">

                <div class="form-group row ">
                    <label for="name" class="col-form-label col-lg-3 col-sm-12">{{__('Name')}}</label>
                    <div class="col-lg-6 col-md-9 col-sm-12">
                        <input
                            class="form-control @error('name') is-invalid @enderror"
                            type="text"
                            name="name"
                            id="name"
                            placeholder="{{__('Enter name')}}"
                            value="{{old('name')}}">
                    </div>
                </div>

                <div class="form-group row ">
                    <label for="email" class="col-form-label col-lg-3 col-sm-12">{{__('Email')}}</label>
                    <div class="col-lg-6 col-md-9 col-sm-12">
                        <input
                            class="form-control @error('email') is-invalid @enderror"
                            type="email"
                            name="email"
                            id="email"
                            placeholder="{{__('Enter email')}}"
                            value="{{old('email')}}"
                            required autocomplete="email">
                    </div>
                </div>
                <div class="form-group row ">
                    <label for="role_id" class="col-form-label col-lg-3 col-sm-12">{{__('Role')}}</label>
                    <div class="col-lg-6 col-md-9 col-sm-12">
                        <select class="form-control @error('role_id') is-invalid @enderror kt-selectpicker"
                                id="role_id"
                                data-size="7"
                                data-live-search="true"
                                data-show-subtext="true" name="role_id" title="{{__('Select')}}">
                            @forelse($roles as $role)
                                <option
                                    value="{{$role->id}}"
                                    @if($role->id == old('role_id')) selected @endif
                                >{{$role->name()}}</option>
                            @empty
                                <option disabled>{{__('There is no roles')}}</option>
                            @endforelse
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="password" class="col-form-label col-lg-3 col-sm-12">{{__('Password')}}</label>
                    <div class="col-lg-6 col-md-9 col-sm-12">
                        <input
                            class="form-control @error('password')is-invalid @enderror"
                            type="password"
                            name="password"
                            id="password"
                            placeholder="{{__('Enter password')}}"
                            value=""
                            autocomplete="new-password">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="password_confirmation" class="col-form-label col-lg-3 col-sm-12">{{__('Confirm Password')}}</label>
                    <div class="col-lg-6 col-md-9 col-sm-12">
                        <input
                            class="form-control @error('password_confirmation') is-invalid @enderror"
                            type="password"
                            name="password_confirmation"
                            id="password_confirmation"
                            placeholder="{{__('Enter password')}}"
                            value="{{old('password_confirmation')}}">
                    </div>
                </div>

            </div>
            <div class="kt-portlet__foot" style="text-align: center">
                <div class="kt-form__actions">
                    <div class="row">
                        <div class="col-lg-12">
                            <button type="submit" class="btn btn-primary">{{__('confirm')}}</button>
                            <a href="{{route('dashboard.customers.index')}}" class="btn btn-secondary">{{__('back')}}</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <!--end::Form-->
    </div>

    <!--end::Portlet-->
@endsection

@push('scripts')
    <script>
        $(function (){
            $(".kt-selectpicker").selectpicker();
        });
    </script>
@endpush
