<?php

namespace Illuminate\Foundation\Auth;

use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Student;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
trait RegistersUsers
{
    use RedirectsUsers;

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\View\View
     */
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    
    {
       
        
       $check =  Student::where('StudentID',$request->StudentID)->get();
      
        if(count($check)>=1){
            User::create([
                'Firstname'=>$request->Firstname,
                'Middlename'=>$request->Middlename,
                'Lastname'=>$request->Lastname,
                'Sex'=>$request->Sex,
                'Role'=>2,
                'SectionID'=>$request->Section,
                'BatchID'=>$request->Batch,
                'StudentID'=>$check[0]['id'],
                'printcount'=>3,
                'vrfy'=>0,
                'status'=>0,
                'dstatus'=>0,
                'email'=>$request->email,
                'password'=>Hash::make($request->password),
            ]);
            return redirect()->route('login')->with('success','You are Successfully Registered!');
        }else {
           return redirect()->back()->with('error','Invalid StudentID. It does not Exist');
        }
        // $this->validator($request->all())->validate();

        // event(new Registered($user = $this->create($request->all())));

        // $this->guard()->login($user);

        // if ($response = $this->registered($request, $user)) {
        //     return $response;
        // }

        // return $request->wantsJson()
        //             ? new JsonResponse([], 201)
        //             : redirect($this->redirectPath());
    }

    /**
     * Get the guard to be used during registration.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard();
    }

    /**
     * The user has been registered.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function registered(Request $request, $user)
    {
        //
    }
}
