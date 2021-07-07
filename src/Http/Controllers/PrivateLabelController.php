<?php

namespace Mach3builders\PrivateLabel\Http\Controllers;

use Illuminate\Routing\Controller;
use Mach3builders\PrivateLabel\Jobs\InstallSite;
use Mach3builders\PrivateLabel\PrivateLabelFacade;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Mach3builders\PrivateLabel\Http\Requests\UpdatePrivateLabelRequest;

class PrivateLabelController extends Controller
{
    public function index(int $owner_id)
    {
        $owner = PrivateLabelFacade::findOwnerById($owner_id);

        $private_label = $owner->privateLabel()->firstOrNew();

        return view('privatelabel::index', compact('private_label', 'owner'));
    }

    public function update(UpdatePrivateLabelRequest $request, int $owner_id)
    {
        $private_label = PrivateLabelFacade::findOwnerById($owner_id)->privateLabel()->updateOrCreate(
            [],
            $request->validated()
        );

        if ($request->file('logo_light')) {
            $private_label->addMedia($request->file('logo_light'))->toMediaCollection('logo_light');
        }

        if ($request->file('logo_dark')) {
            $private_label->addMedia($request->file('logo_dark'))->toMediaCollection('logo_dark');
        }

        if ($request->file('favicon')) {
            $private_label->addMedia($request->file('favicon'))->toMediaCollection('favicon');
        }

        if ($private_label->wasRecentlyCreated) {
            $private_label->update([
                'status' => 'dns_validating'
            ]);

            InstallSite::dispatch($private_label);
        }

        return back();
    }

    public function deleteMedia(int $owner_id, int $media)
    {
        $owner = PrivateLabelFacade::findOwnerById($owner_id);
        $media = Media::findOrFail($media);

        abort_unless($media->model->owner->is($owner), 403);

        $media->delete();

        return back();
    }

    public function poll(int $owner_id)
    {
        $owner = PrivateLabelFacade::findOwnerById($owner_id);

        $private_label = $owner->privatelabel;
        $status_of_polling = $private_label->completedStatus('site_installed')
                                ? 'done'
                                : 'running';

        return response()->json([
            'status' => $status_of_polling,
            'current_status' => $private_label->status,
        ]);
    }
}
