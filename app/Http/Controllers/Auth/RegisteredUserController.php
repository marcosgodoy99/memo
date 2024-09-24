<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Mail\RegisterMail;
use Illuminate\Support\Facades\Mail;    



class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        
        // Mail::to($request->email)->send(new RegisterMail($request->name));
        
        
        // $mgClient = new RegisterMail('YOUR_API_KEY');
        // $domain = "sandbox6cf5c48b59874af6a48f8cba33350e5b.mailgun.org";
        
        // $result = $mgClient->sendMessage($domain, array(
        //     'from'	=> 'Excited User <mailgun@sandbox6cf5c48b59874af6a48f8cba33350e5b.mailgun.org>',
        //     'to'	=> $request->email,
        //     'subject' => 'Hello wordl',
        //     'text'	=> 'Testing some Mailgun awesomeness!'
        // ));


        //$role = Role::findByName('client');
        //$permission = Permission::findByName('buy item');

        //$user->assignRole($role);
        //$user->givePermissionTo($permission);

        //event(new Registered($user));

        //Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
