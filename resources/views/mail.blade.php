@extends(config('private-label.extend_layout', null))

@section('body')
    <div class="ui-section-view-main-body">
        @include('privatelabel::tabs')

        <form action="{{ route('private-label.mail.update', $owner) }}" method="post" id="form-email">
            @method('PATCH')
            @csrf

            <h2 class="ui-heading mt-4">{{ __('privatelabel::private-label.domain') }}</h2>

            <div class="card mt-3">
                <div class="card-body">
                    <div class="form-group row ui-required">
                        <label for="email" class="col-md-4 col-form-label">{{ __('privatelabel::private-label.email') }}</label>
                        <div class="col-md-8">
                            <input type="email" name="email" value="{{ old('email', $private_label->email) }}" id="email" placeholder="info@example.nl" class="form-control @error('email') is-invalid @enderror">

                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                            <small class="form-text text-muted">{{ __('privatelabel::private-label.email_form_text') }}</small>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <div class="d-flex justify-content-end mt-3">
            <form action="{{ route('private-label.mail.verify', $owner) }}" method="post">
                @csrf
                <button type="submit" class="btn btn-primary mr-3">{{ __('privatelabel::private-label.verify') }}</button>
            </form>

            <button form="form-email" type="submit" class="btn btn-success">{{ __('privatelabel::private-label.save') }}</button>
        </div>
    </div>
@endsection
