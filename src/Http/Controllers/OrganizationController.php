<?php

namespace Uneca\DisseminationToolkit\Http\Controllers;

use App\Http\Controllers\Controller;
use Uneca\DisseminationToolkit\Models\Organization;
use Illuminate\Http\Request;

class OrganizationController extends Controller
{
    public function edit()
    {
        $organization = Organization::firstOrCreate();
        return view('dissemination::manage.organization.edit', compact('organization'));
    }

    public function update(Organization $organization, Request $request)
    {
        if ($request->file('logo')) {
            $path = $request->file('logo')->storeAs('site', $request->file('logo')->getClientOriginalName(), 'public');
            $request->merge(['logo_path' => "storage/$path"]);
        }
        $result = $organization->update([
            ...$request->only(['name', 'website', 'email', 'logo_path', 'slogan', 'blurb', 'address']),
            ...['social_media' => [
                'twitter' => $request->get('twitter'),
                'facebook' => $request->get('facebook'),
                'instagram' => $request->get('instagram'),
                'linkedin' => $request->get('linkedin'),
            ]]
        ]);
        return redirect()->route('manage.organization.edit')->withMessage('Record updated');
    }
}
