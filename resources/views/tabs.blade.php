<div class="ui-section-view-main-tabs">
    <nav class="ui-tabs">
        <ul>
            <li @class([
                'ui-tabs-item',
                'active' => Route::is('private-label.index'),
            ])>
                <a href="{{ route('private-label.index', $owner) }}" class="ui-tabs-link">{{ __('privatelabel::general') }}</a>
            </li>
            <li @class([
                'ui-tabs-item',
                'active' => Route::is('private-label.mail.index'),
            ])>
                <a href="{{ route('private-label.mail.index', $owner) }}" class="ui-tabs-link">{{ __('privatelabel::mail') }}</a>
            </li>
        </ul>
    </nav>
</div>
