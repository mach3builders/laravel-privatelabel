@extends(config('private-label.extend_layout', null))

@section('header')
    <div class="ui-heading">{{ __('privatelabel::private-label.private-label') }}</div>
@endsection

@section('body')
    <div class="ui-section-view-main-body">
        <div class="alert alert-primary">
            {!! __('privatelabel::private-label.info') !!}
        </div>

        <form action="{{ route('private-label.update', $owner) }}" method="post" enctype="multipart/form-data">
            @method('PATCH')
            @csrf

            <h2 class="ui-heading mt-4">{{ __('privatelabel::private-label.domain') }}</h2>

            @if ($private_label->exists)
                @if (! $private_label->completedStatus('site_installed'))
                    <span class="private-label-poller"
                            data-poll-url="{{ route('private-label.check-status', $private_label->owner) }}"
                            data-poll-status="{{ $private_label->completedStatus('site_installed') ? 'done' : 'running'  }}"
                            data-poll-timer="5000">
                    </span>
                @endif

                <ul id="private-label" class="list-group mt-3 mb-0">
                    <li class="list-group-item">
                        <div class="ui-icon-text">
                            <i class="far fa-spinner fa-spin {{ !$private_label->completedStatus('dns_validated') ?: 'd-none' }}" id="dns_validating"></i>
                            <i class="far fa-check text-success {{ $private_label->completedStatus('dns_validated') ?: 'd-none' }}" id="dns_validated"></i>

                            <div>
                                {{ __('privatelabel::private-label.checking_dns') }}
                                <div style="opacity:.65">{{ __('privatelabel::private-label.checking_dns_info', ['domain' => $private_label->domain]) }}</div>
                            </div>
                        </div>
                    </li>

                    <li class="list-group-item">
                        <div class="ui-icon-text">
                            <i class="far fa-spinner fa-spin {{ !$private_label->completedStatus('site_installed') ?: 'd-none' }}" id="site_installing"></i>
                            <i class="far fa-check text-success {{ $private_label->completedStatus('site_installed') ?: 'd-none' }}" id="site_installed"></i>

                            <div>
                                {{ __('privatelabel::private-label.activating_ssl') }}
                            </div>
                        </div>
                    </li>
                </ul>
            @endif

            <div class="card mt-3">
                <div class="card-body">
                    <div class="form-group row ui-required">
                        <label for="domain" class="col-md-4 col-form-label">{{ __('privatelabel::private-label.domain') }}</label>
                        <div class="col-md-8">
                            <input {{ $private_label->domain ? 'disabled' : '' }} type="text" name="domain" value="{{ old('domain', $private_label->domain) }}" id="domain" placeholder="www.domein.nl" class="form-control @error('domain') is-invalid @enderror">
                            @error('domain')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">{{ __('privatelabel::private-label.domain_form_text') }}</small>
                        </div>
                    </div>

                    <div class="form-group row ui-required">
                        <label for="name" class="col-md-4 col-form-label">{{ __('privatelabel::private-label.name') }}</label>
                        <div class="col-md-8">
                            <input type="text" name="name" value="{{ old('name', $private_label->name) }}" id="name" class="form-control @error('name') is-invalid @enderror">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">{{ __('privatelabel::private-label.name_form_text') }}</small>
                        </div>
                    </div>

                    <div class="form-group row ui-required">
                        <label for="email" class="col-md-4 col-form-label">{{ __('privatelabel::private-label.email') }}</label>
                        <div class="col-md-8">
                            <input type="text" name="email" value="{{ old('email', $private_label->email) }}" id="email" class="form-control @error('email') is-invalid @enderror">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">{{ __('privatelabel::private-label.email_form_text') }}</small>
                        </div>
                    </div>
                </div>
            </div>

            <h2 class="ui-heading mt-4">{{ __('privatelabel::private-label.images') }}</h2>

            <div class="card mt-3">
                <div class="card-body">
                    <div class="form-group row">
                        <label for="logo_light" class="col-md-4 col-form-label">{{ __('privatelabel::private-label.logo_light') }}</label>

                        <div class="col-md-8">
                            @if ($private_label->hasMedia('logo_light'))
                                <div class="mb-1 form-control d-flex justify-content-between" style="background-color: #2d3748">
                                    <div class="mr-5 flex-grow-1">
                                        <img src="{{ $private_label->getFirstMediaUrl('logo_light') }}" class="align-self-center img-fluid w-max-content">
                                    </div>

                                    <a href="{{ route('private-label.delete-media', ['owner_id' => $owner, 'media' => $private_label->getFirstMedia('logo_light')]) }}" class="align-self-start btn btn-sm ui-btn-icon text-white border-white">
                                        <i class="far fa-trash"></i>
                                    </a>
                                </div>
                            @endif

                            <div class="custom-file">
                                <input type="file" name="logo_light" id="logo_light" class="custom-file-input {{ $errors->has('logo_light') ? 'is-invalid' : '' }}">

                                <label class="custom-file-label">
                                    {{ __('privatelabel::private-label.choose_file') }}
                                </label>

                                @error('logo_light')
                                    <p class="invalid-feedback">{{ $message }}</p>
                                @enderror

                                <small class="form-text text-muted">{{ __('privatelabel::private-label.logo_light_form_text') }}</small>
                            </div>
                        </div>
                    </div>

                    @if ($private_label->hasMedia('logo_light'))
                        <div class="form-group row">
                            <label for="logo_app_height" class="col-md-4 col-form-label">{{ __('privatelabel::private-label.logo_app_height') }}</label>

                            <div class="col-md-8">
                                <input id="logo_app_height" name="logo_app_height" type="number" value="{{ old('logo_app_height', $private_label->logo_app_height) }}"  min="1" max="100" class="form-control  {{ $errors->has('logo_dark') ? 'is-invalid' : '' }}">
                            </div>
                        </div>
                    @endif

                    <hr>

                    <div class="form-group row">
                        <label for="logo_dark" class="col-md-4 col-form-label">{{ __('privatelabel::private-label.logo_dark') }}</label>

                        <div class="col-md-8">
                            @if ($private_label->hasMedia('logo_dark'))
                                <div class="mb-1 form-control d-flex justify-content-between">
                                    <div class="mr-5 flex-grow-1">
                                        <img src="{{ $private_label->getFirstMediaUrl('logo_dark') }}" class="align-self-center img-fluid w-max-content">
                                    </div>

                                    <a href="{{ route('private-label.delete-media', ['owner_id' => $owner, 'media' => $private_label->getFirstMedia('logo_dark')]) }}" class="align-self-start btn btn-sm ui-btn-icon btn-outline-light">
                                        <i class="far fa-trash"></i>
                                    </a>
                                </div>
                            @endif

                            <div class="custom-file">
                                <input type="file" name="logo_dark" id="logo_dark" class="custom-file-input {{ $errors->has('logo_dark') ? 'is-invalid' : '' }}">

                                <label class="custom-file-label">
                                    {{ __('privatelabel::private-label.choose_file') }}
                                </label>

                                @error('logo_dark')
                                    <p class="invalid-feedback">{{ $message }}</p>
                                @enderror

                                <small class="form-text text-muted">{{ __('privatelabel::private-label.logo_dark_form_text') }}</small>
                            </div>
                        </div>
                    </div>

                    @if ($private_label->hasMedia('logo_dark'))
                        <div class="form-group row">
                            <label for="logo_app_height" class="col-md-4 col-form-label">{{ __('privatelabel::private-label.logo_login_height') }}</label>

                            <div class="col-md-8">
                                <input id="logo_login_height" name="logo_login_height" type="number" value="{{ old('logo_login_height', $private_label->logo_login_height) }}"  min="1" max="100" class="form-control  {{ $errors->has('logo_dark') ? 'is-invalid' : '' }}">
                            </div>
                        </div>
                    @endif

                    <hr>

                    <div class="form-group row">
                        <label for="favicon" class="col-md-4 col-form-label">{{ __('privatelabel::private-label.favicon') }}</label>

                        <div class="col-md-8">
                            @if ($private_label->hasMedia('favicon'))
                                <div class="mb-1 form-control d-flex justify-content-between">
                                    <div class="mr-5 flex-grow-1">
                                        <img src="{{ $private_label->getFirstMediaUrl('favicon') }}" class="align-self-center img-fluid w-max-content">
                                    </div>

                                    <a href="{{ route('private-label.delete-media', ['owner_id' => $owner, 'media' => $private_label->getFirstMedia('favicon')]) }}" class="align-self-start btn btn-sm ui-btn-icon btn-outline-light">
                                        <i class="far fa-trash"></i>
                                    </a>
                                </div>
                            @endif

                            <div class="custom-file">
                                <input type="file" name="favicon" id="favicon" class="custom-file-input {{ $errors->has('favicon') ? 'is-invalid' : '' }}">

                                <label class="custom-file-label">
                                    {{ __('privatelabel::private-label.choose_file') }}
                                </label>

                                @error('favicon')
                                    <p class="invalid-feedback">{{ $message }}</p>
                                @enderror

                                <small class="form-text text-muted">{{ __('privatelabel::private-label.favicon_form_text') }}</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="ui-btns">
                <button type="submit" class="btn btn-success">{{ __('privatelabel::private-label.save') }}</button>
            </div>
        </form>
    </div>
@endsection
