<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Laracasts\Flash\Flash;
use App\Models\Specialization;
use App\Models\Setting;
use App\Models\UserFile;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        $captchakey = Setting::where('key','googleCaptchaKey')->pluck('value')->first();
        return view('auth.register',compact('captchakey'));
    }

    public function doctorcreate(): View
    {
        $prefixdata=[
                        'Mr' => 'Mr','Mrs' => 'Mrs','Ms' => 'Ms','Mx' => 'Mx','Miss' => 'Miss','Dr' => 'Dr','Prof' => 'Prof'
                    ];
        $educationdata=[
                        'Bachelor' => 'Bachelor',
                        'Diploma' => 'Diploma',
                        "Master's degree" => "Master's degree",
                        'PHD' => 'PHD',
                        'Other' => 'Other',
                        ];

        $specializations=Specialization::pluck('name', 'id')->toArray();
        $experiencedata=['0-3'=>'0 - 3','4-6'=>'4 - 6','7-10'=>'7 - 10','10-15'=>'10 - 15','16+'=>'16+'];



        $captchakey = Setting::where('key','googleCaptchaKey')->pluck('value')->first();
        return view('auth.doctoreregister',compact('captchakey','prefixdata','educationdata','specializations','experiencedata'));
    }

    /**
     * Handle an incoming registration request.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255|regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix|unique:users,email',
            'password' => ['required', 'confirmed', 'min:6'],
            'toc' => 'required',
        ]);

        $datas1 = Setting::where('key','recaptcha')->first();
        if($datas1->value){
            $request->validate([
                'g-recaptcha-response' => 'required',
            ],
            [
                'g-recaptcha-response.required' => __('messages.common.google_captcha_required'),
            ]);
        }

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'type' => User::PATIENT,
            'language' => getSettingValue('language'),
        ]);

        // $user->patient()->create([
        //     'patient_unique_id' => mb_strtoupper(Patient::generatePatientUniqueId()),
        // ]);

        $user->assignRole('doctor');

        $user->sendEmailVerificationNotification();

        Flash::success(__('messages.flash.your_reg_success'));

        return redirect('login');
    }


    public function storeDoctor(Request $request): RedirectResponse
    {
        
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255|regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix|unique:users,email',
            'password' => ['required', 'confirmed', 'min:6'],
            'toc' => 'required',
        ]);

        $datas1 = Setting::where('key','recaptcha')->first();
        if($datas1->value){
            $request->validate([
                'g-recaptcha-response' => 'required',
            ],
            [
                'g-recaptcha-response.required' => __('messages.common.google_captcha_required'),
            ]);
        }

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'type' => User::DOCTOR,
            'language' => getSettingValue('language'),
        ]);
        $doctor=Doctor::create([
            'availability'=>json_encode($request->availability),
            'services'=>json_encode($request->services),
            'sub_urgent_care'=>json_encode($request->sub_urgent_care),
            'sub_preventive_health'=>json_encode($request->sub_preventive_health),
            'can_start'=>$request->can_start,
            'child_care'=>$request->child_care,
            'chronic_care'=>$request->chronic_care,
            'education'=>$request->education,
            'experience'=>$request->experience,
            'instagram_url'=>$request->instagram_url,
            'linkedin_url'=>$request->linkedin_url,
            'mental_health'=>$request->mental_health,
            'prefix'=>$request->prefix,
            'preventive_health'=>$request->preventive_health,
            'services_can_be_performed_online'=>$request->services_can_be_performed_online,
            'sexual_health'=>$request->sexual_health,
            'skin_and_hair'=>$request->skin_and_hair,
            'start_date'=>$request->start_date,
            'twitter_url'=>$request->twitter_url,
            'urgent_care'=>$request->urgent_care,
            'user_id'=>$user->id,
        ]);

        $doctor->specializations()->sync($request->specializations);

        $user->assignRole('doctor');

        if (request()->hasFile('images')) {
            $files = request()->file('images');
            foreach ($files as $file) {
                $data['image'] = $file->store('images');
                $file->move('images', $data['image']);
                UserFile::create(['path' => $data['image'],'user_id'=>$user->id]);
            }
        }   

        // $user->sendEmailVerificationNotification();

        Flash::success(__('messages.flash.your_reg_success'));

        return redirect('login');
    }
}
