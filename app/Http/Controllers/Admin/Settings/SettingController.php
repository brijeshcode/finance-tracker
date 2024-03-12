<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Http\Controllers\Controller;
use App\Models\Admin\Settings\Setting;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SettingController extends Controller
{
    public function index($group)
    {
        if (! isRole('admin')) {
            abort(404);
        }
        $tinyKey = '';
        $settings = Setting::where('group', $group)->get();

        return Inertia::render('Admin/Settings/'.$group, compact('settings', 'group', 'tinyKey'));
    }

    public function save(Request $request, $group)
    {
        collect($request->all())->each(function ($value, $key) use ($group) {
            if (is_array($value)) {
                $imageUrl = [];
                foreach ($value as $arrKey => $arrValue) {

                    if (isset($arrValue['image_url'])) {
                        if (gettype($arrValue['image_url']) == 'object') {
                            $imageUrl[$arrKey]['image_url'] = $this->uploadBanners($arrValue['image_url']);
                        } elseif (gettype($arrValue['image_url']) == 'string') {
                            $imageUrl[$arrKey]['image_url'] = str_replace(Storage::url(''), '', $arrValue['image_url']);
                        }
                    }
                }
                if (! empty($imageUrl)) {
                    $imageData = json_encode($imageUrl);
                    $settings = Setting::updateOrCreate(
                        ['group' => $group, 'key' => $key],
                        ['value' => $imageData]
                    );
                }
            } else {

                $settings = Setting::updateOrCreate(
                    ['group' => $group, 'key' => $key],
                    ['value' => $value]
                );
            }
        });

        return redirect(route('admin.settings.index', $group))->with('type', 'success')->with('message', 'Saved successfully !!');

    }

    public function uploadBanners($image)
    {
        $imgName = time().rand(1, 500).'.'.$image->extension();
        $requestData = [];
        $requestData = $image->storeAs('banners', $imgName);

        return $requestData;
    }
}
