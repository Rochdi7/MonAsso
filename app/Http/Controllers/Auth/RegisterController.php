<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Association;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
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

            // Admin (user) info
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'phone' => ['required', 'string', 'max:20', 'unique:users,phone'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new association and its first admin user
     */
    protected function create(array $data)
    {
        return DB::transaction(function () use ($data) {
            // Create association (auto-incrementing ID)
            $association = Association::create([
                'name' => $data['association_name'],
                'address' => $data['association_address'],
                'email' => $data['association_email'],
                'creation_date' => now(),
                'is_validated' => false,
            ]);

            // Create user (admin)
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'phone' => $data['phone'],
                'password' => Hash::make($data['password']),
                'is_active' => true,
                'association_id' => $association->id,
            ]);

            $user->assignRole('admin');

            return $user;
        });
    }

    /**
     * Handle the registration request
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        $user = $this->create($request->all());

        Auth::login($user);

        return redirect($this->redirectPath());
    }
}
