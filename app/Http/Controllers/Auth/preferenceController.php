<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use App\Models\Preference;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class preferenceController extends Controller
{
    public function addPreference(Request $request)
    {
        $request->validate([
            'selected_tags' => 'required|array',
        ]);

        //$idUser = Auth::user();
        $idUser = $request->session()->get('user_id');
        //dd($idUser);

        foreach ($request->selected_tags as $categoryId) {
            Preference::create([
                'category_id' => $categoryId,
                'user_id' => $idUser,
            ]);
        }

        return redirect()->route('preferences.show');
    }

    public function displayCategories()
    {
        $categories = Categories::orderBy('created_at', 'desc')->get();
        return view('Authentication.authentication',compact('categories'));

    }
    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'You have been logged out successfully.');
    }
}
