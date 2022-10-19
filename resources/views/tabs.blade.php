<div class="ui-section-view-main-tabs">
    <nav class="ui-tabs">
        <ul>
            <li @class([
                'ui-tabs-item',
                'active' => Route::is('private-label.index'),
            ])>
                <a href="{{ route('private-label.index', $owner) }}" class="ui-tabs-link">{{ __('privatelabel::private-label.general') }}</a>
            </li>

            @if ($private_label->exists)
                <li @class([
                    'ui-tabs-item',
                    'active' => Route::is('private-label.mail.index'),
                ])>
                    <a href="{{ route('private-label.mail.index', $owner) }}" class="ui-tabs-link">{{ __('privatelabel::private-label.mail') }}</a>
                </li>
            @endif
        </ul>
    </nav>
</div>
