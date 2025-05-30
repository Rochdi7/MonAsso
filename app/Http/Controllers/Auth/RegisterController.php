<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Association;
use App\Models\Membre;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'association_name' => ['required', 'string', 'max:255'],
            'association_address' => ['required', 'string'],
            'association_email' => ['required', 'email', 'unique:associations,email'],

            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:20', 'unique:members,phone'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    protected function create(array $data)
    {
        return DB::transaction(function () use ($data) {
            $association = Association::create([
                'id' => Str::uuid(),
                'name' => $data['association_name'],
                'address' => $data['association_address'],
                'email' => $data['association_email'],
                'creation_date' => now(),
                'is_validated' => false,
            ]);

            return Membre::create([
                'id' => Str::uuid(),
                'name' => $data['name'],
                'phone' => $data['phone'],
                'password' => Hash::make($data['password']),
                'role' => 'admin',
                'is_admin' => true,
                'is_active' => true,
                'association_id' => $association->id,
            ]);
        });
    }

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        $member = $this->create($request->all());

        Auth::login($member);

        return redirect($this->redirectPath());
    }
}
