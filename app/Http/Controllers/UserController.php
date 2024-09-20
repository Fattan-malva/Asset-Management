<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Customer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\StoreUserRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use League\Flysystem\UrlGeneration\PublicUrlGenerator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $users = User::all();
        return response(view('user.index', ['users' => $users]));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return response(view('user.create'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request): RedirectResponse
    {
        $validatedData = $request->validated();

        $user = new User();
        $user->username = $validatedData['username'];
        $user->password = $validatedData['password'];
        $user->role = $validatedData['role'];
        $user->nama = '';
        $user->nohp = '';
        $user->alamat = '';
        $user->nrp = $request->nrp;
        $user->mapping = $request->mapping;
        $user->save();

        return redirect()->route('user.index')->with('success', 'User created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): Response
    {
        $user = User::findOrFail($id);
        return response(view('user.show', ['user' => $user]));
    }
    public function showLoginForm(): Response
    {
        return response(view('auth.login'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): Response
    {
        $user = User::findOrFail($id);
        return response(view('user.edit', ['user' => $user]));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreUserRequest $request, string $id): RedirectResponse
    {
        $validatedData = $request->validated();

        // Ambil data user yang ada
        $user = User::findOrFail($id);

        // Perbarui hanya kolom yang diperlukan
        $user->username = $validatedData['username'];
        $user->password = $validatedData['password'];
        $user->role = $validatedData['role'];
        $user->nama = '';
        $user->nohp = '';
        $user->alamat = '';
        $user->nrp = $request->nrp;
        $user->mapping = $request->mapping;
        $user->save();

        // Simpan perubahan
        $user->save();

        return redirect()->route('user.index')->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('user.index')->with('success', 'User deleted successfully.');
    }

    /**
     * Handle user login.
     */
    public function login(Request $request): RedirectResponse
    {
        $username = $request->input('username');
        $password = $request->input('password');

        // Cari pengguna berdasarkan username yang persis sama (case-sensitive)
        $customer = Customer::where('username', $username)->first();

        // Periksa apakah pengguna ada dan password cocok secara persis (case-sensitive)
        if (!$customer || $password !== $customer->password) {
            return redirect()->back()->withInput()->with('error', 'Login failed. Username and Password do not match.');
        }

        // Simpan ID pengguna, peran, dan nama dalam sesi
        $request->session()->put('user_id', $customer->id);
        $request->session()->put('user_username', $customer->username);
        $request->session()->put('user_role', $customer->role);
        $request->session()->put('user_name', $customer->name);
        $request->session()->put('user_nrp', $customer->nrp);
        $request->session()->put('user_mapping', $customer->mapping);

        // Alihkan berdasarkan peran pengguna
        if ($customer->role === 'admin') {
            return redirect()->route('dashboard')->with('success', 'Success login.');
        } elseif ($customer->role === 'sales') {
            return redirect()->route('shared.homeSales')->with('success', 'Success login as Sales.');
        } else {
            return redirect()->route('shared.homeUser')->with('success', 'Success login.');
        }
    }





    /**
     * Show the registration form.
     */
    public function register(): Response
    {
        return response(view('auth.register'));
    }

    /**
     * Handle user registration.
     */
    public function storeregister(Request $request): RedirectResponse
    {
        $request->validate([
            'username' => 'required|string|max:50|unique:customer,username',
            'password' => 'required|string|max:50',
            'role' => 'required|string|max:50',
            'nrp' => 'required|string|max:50',
            'name' => 'required|string|max:50',
            'mapping' => 'nullable|string|max:50',
        ]);

        Customer::create([
            'username' => $request->input('username'),
            'password' => $request->input('password'),
            'role' => $request->input('role'),
            'nrp' => $request->input('nrp'),
            'name' => $request->input('name'),
            'mapping' => $request->input('mapping'),
        ]);

        return redirect()->route('login')->with('success', 'Register successfully.');
    }


    /**
     * Handle user logout.
     */
    public function logout(Request $request): RedirectResponse
    {
        $request->session()->forget('user_id');
        return redirect()->route('shared.home')->with('success', 'Logged out successfully.');
    }

}
