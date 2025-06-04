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

    /**
     * Validation rules for registration
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            // Association info
            'association_name' => ['required', 'string', 'max:255'],
            'association_address' => ['required', 'string'],
            'association_email' => ['required', 'email', 'unique:associations,email'],

            // Admin (membre) info
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:members,email'], // ✅ NEW
            'phone' => ['required', 'string', 'max:20', 'unique:members,phone'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new association and its first admin
     */
    protected function create(array $data)
    {
        return DB::transaction(function () use ($data) {
            // Create association
            $association = Association::create([
                'id' => Str::uuid(),
                'name' => $data['association_name'],
                'address' => $data['association_address'],
                'email' => $data['association_email'],
                'creation_date' => now(),
                'is_validated' => false,
            ]);

            // Create member (admin)
            $member = Membre::create([
                'id' => Str::uuid(),
                'name' => $data['name'],
                'email' => $data['email'], // ✅ NEW
                'phone' => $data['phone'],
                'password' => Hash::make($data['password']),
                'role' => 'admin',
                'is_admin' => true,
                'is_active' => true,
                'association_id' => $association->id,
            ]);

            $member->assignRole('admin');

            return $member;
        });
    }

    /**
     * Handle the registration request
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        $member = $this->create($request->all());

        Auth::login($member);

        return redirect($this->redirectPath());
    }
}
