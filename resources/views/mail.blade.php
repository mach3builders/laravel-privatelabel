@extends(config('private-label.extend_layout', null))

@section('body')
    <div class="ui-section-view-main-body">
        <div class="alert alert-primary">
            {!! __('privatelabel::private-label.email_info') !!}
        </div>

        @if ($private_label->email_domain && $private_label->email_verified)
            <div class="alert alert-success">
                {{ __('privatelabel::private-label.info_email_verified') }}
            </div>
        @endif

        @include('privatelabel::tabs')

        @if (session()->has('dns_records'))
            <div class="alert alert-primary">
                {{ __('privatelabel::private-label.info_email') }}<strong>{{ $private_label->email_domain }}</strong>
            </div>

            <table class="table">
                <thead>
                    <th>Type</th>
                    <th>{{ __('privatelabel::private-label.name') }}</th>
                    <th>{{ __('privatelabel::private-label.priority') }}</th>
                    <th>{{ __('privatelabel::private-label.value') }}</th>
                </thead>
                <tbody>
                    @foreach (session()->pull('dns_records') as $record)
                        <tr>
                            <td>{{ $record['record_type'] }}</td>
                            <td>{{ $record['name'] ?? '' }}</td>
                            <td>{{ $record['priority'] ?? '' }}</td>
                            <td style="overflow-wrap: anywhere;">{{ $record['value'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

        <form action="{{ route('private-label.mail.update', $owner) }}" method="post" id="form-email">
            @method('PATCH')
            @csrf

            <div class="card mt-3">
                <div class="card-body">
                    <div class="form-group row ui-required">
                        <label for="email" class="col-md-4 col-form-label">{{ __('privatelabel::private-label.email') }}</label>

                        <div class="col-md-8">
                            <input type="email" {{ $private_label->email_verified ? 'disabled' : '' }} name="email" value="{{ old('email', $private_label->email) }}" id="email" placeholder="info@example.nl" class="form-control @error('email') is-invalid @enderror">

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
            @if ($private_label->email_domain)
                <form action="{{ route('private-label.mail.verify', $owner) }}" method="post">
                    @csrf
                    <button type="submit"
                        onclick="$('#spinner').show()"
                        {{ $private_label->email_verified ? 'disabled' : '' }}
                        class="btn btn-primary mr-3">
                        {{ __('privatelabel::private-label.verify') }}
                        <i class="far fa-spinner-third fa-spin" style="display: none;" id="spinner"></i>
                    </button>
                </form>
            @endif

            @if (! $private_label->email_verified)
                <button form="form-email" type="submit" class="btn btn-success">{{ __('privatelabel::private-label.save') }}</button>
            @endif
        </div>
    </div>
@endsection
