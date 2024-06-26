<?php

namespace App\Repositories;

use App\DataTable\UserDataTable;
use App\Models\Appointment;
use App\Models\Country;
use App\Models\Doctor;
use App\Models\DoctorSession;
use App\Models\Patient;
use App\Models\Qualification;
use App\Models\Specialization;
use App\Models\User;
use Arr;
use Carbon\Carbon;
use Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Session;
use App\Models\Setting;

/**
 * Class UserRepository
 */
class UserRepository extends BaseRepository
{
    public $fieldSearchable = [
        'first_name',
        'last_name',
        'email',
        'contact',
        'dob',
        'specialization',
        'experience',
        'gender',
        'status',
        'password',

    ];

    /**
     * {@inheritDoc}
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * {@inheritDoc}
     */
    public function model()
    {
        return User::class;
    }

    public function getData(): array
    {
        $data['patientUniqueId'] = mb_strtoupper(Patient::generatePatientUniqueId());
        $data['countries'] = Country::toBase()->pluck('name', 'id');
        $data['bloodGroupList'] = Patient::BLOOD_GROUP_ARRAY;

        return $data;
    }

    /**
     * @return mixed
     */
    public function store(array $input)
    {
        $addressInputArray = Arr::only($input,
            ['address1', 'address2', 'country_id', 'city_id', 'state_id', 'postal_code']);
        $doctorArray = Arr::only($input, ['experience', 'twitter_url', 'linkedin_url', 'instagram_url']);
        $specialization = $input['specializations'];
        try {
            DB::beginTransaction();
            $input['email'] = setEmailLowerCase($input['email']);
            $input['status'] = (isset($input['status'])) ? 1 : 0;
            $input['password'] = Hash::make($input['password']);
            $input['type'] = User::DOCTOR;
            $input['language'] = Setting::where('key','language')->get()->toArray()[0]['value'];
            $doctor = User::create($input);
            $doctor->assignRole('doctor');
            $doctor->address()->create($addressInputArray);
       
            $createDoctor = Doctor::create([
                [
                'availability'=>json_encode($input['availability']),
                'services'=>json_encode($input['services']),
                'sub_urgent_care'=>json_encode($input['sub_urgent_care']),
                'sub_preventive_health'=>json_encode($input['sub_preventive_health']),
                'can_start'=>$input['can_start'],
                'child_care'=>$input['child_care'],
                'chronic_care'=>$input['chronic_care'],
                'education'=>$input['education'],
                'experience'=>$input['experience'],
                'instagram_url'=>$input['instagram_url'],
                'linkedin_url'=>$input['linkedin_url'],
                'mental_health'=>$input['mental_health'],
                'prefix'=>$input['prefix'],
                'preventive_health'=>$input['preventive_health'],
                'services_can_be_performed_online'=>$input['services_can_be_performed_online'],
                'sexual_health'=>$input['sexual_health'],
                'skin_and_hair'=>$input['skin_and_hair'],
                'start_date'=>$input['start_date'],
                'twitter_url'=>$input['twitter_url'],
                'urgent_care'=>$input['urgent_care'],
                'user_id'=>$doctor->id,]
        ]);
            $createDoctor->specializations()->sync($specialization);
            if (isset($input['profile']) && ! empty('profile')) {
                $doctor->addMedia($input['profile'])->toMediaCollection(User::PROFILE, config('app.media_disc'));
            }
            // $doctor->sendEmailVerificationNotification();

            DB::commit();

            return $doctor;
        } catch (\Exception $e) {
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }

    public function update($input, $doctor)
    {
        $addressInputArray = Arr::only($input,
            ['address1', 'address2', 'city_id', 'state_id', 'country_id', 'postal_code']);
        $doctorArray = Arr::only($input, ['experience', 'twitter_url', 'linkedin_url', 'instagram_url']);
        $qualificationArray = json_decode($input['qualifications'], true);
        $specialization = $input['specializations'];
        try {
            DB::beginTransaction();
            $input['email'] = setEmailLowerCase($input['email']);
            $input['status'] = (isset($input['status'])) ? 1 : 0;
            $input['type'] = User::DOCTOR;
            $doctor->user->update($input);
            $doctor->user->address()->update($addressInputArray);
            $doctor = Doctor::update([
                'availability'=>json_encode($input['availability']),
                'services'=>json_encode($input['services']),
                'sub_urgent_care'=>json_encode($input['sub_urgent_care']),
                'sub_preventive_health'=>json_encode($input['sub_preventive_health']),
                'can_start'=>$input['can_start'],
                'child_care'=>$input['child_care'],
                'chronic_care'=>$input['chronic_care'],
                'education'=>$input['education'],
                'experience'=>$input['experience'],
                'instagram_url'=>$input['instagram_url'],
                'linkedin_url'=>$input['linkedin_url'],
                'mental_health'=>$input['mental_health'],
                'prefix'=>$input['prefix'],
                'preventive_health'=>$input['preventive_health'],
                'services_can_be_performed_online'=>$input['services_can_be_performed_online'],
                'sexual_health'=>$input['sexual_health'],
                'skin_and_hair'=>$input['skin_and_hair'],
                'start_date'=>$input['start_date'],
                'twitter_url'=>$input['twitter_url'],
                'urgent_care'=>$input['urgent_care'],

        ]);
            $doctor->specializations()->sync($specialization);

            if (count($qualificationArray) >= 0) {
                if (isset($input['deletedQualifications'])) {
                    Qualification::whereIn('id', explode(',', $input['deletedQualifications']))->delete();
                }

                foreach ($qualificationArray as $qualifications) {
                    if ($qualifications == null) {
                        continue;
                    }
                    if (isset($qualifications['id'])) {
                        $doctor->user->qualifications()->where('id', $qualifications['id'])->update($qualifications);
                    } else {
                        unset($qualifications['id']);
                        $doctor->user->qualifications()->create($qualifications);
                    }
                }
            }

            if (isset($input['profile']) && ! empty('profile')) {
                $doctor->user->clearMediaCollection(User::PROFILE);
                $doctor->user->media()->delete();
                $doctor->user->addMedia($input['profile'])->toMediaCollection(User::PROFILE, config('app.media_disc'));
            }
            DB::commit();

            return $doctor;
        } catch (\Exception $e) {
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }

    public function updateProfile(array $userInput): bool
    {
        try {
          
            DB::beginTransaction();

            $user = Auth::user();
            if(auth()->user()->role_name=='Patient'){
                $patient =  Patient::where('user_id',$user->id)->first();
    
    
                $addressInputArray = Arr::only($userInput,
                    ['address1', 'address2', 'city_id', 'state_id', 'country_id', 'postal_code']);
                $userInput['type'] = User::PATIENT;
                $userInput['email'] = setEmailLowerCase($userInput['email']);
                /** @var Patient $patient */
                
                $patient->user()->update(Arr::except($userInput, [
                    'address1', 'address2', 'city_id', 'state_id', 'country_id', 'postal_code', 'patient_unique_id',
                    'avatar_remove',
                    'profile', 'is_edit', 'edit_patient_country_id', 'edit_patient_state_id', 'edit_patient_city_id',
                    'backgroundImg',
                ]));
                
    
                if(isset($patient->address)){
                    $patient->address()->update($addressInputArray);
                }else{
                    $patient->address()->create($addressInputArray);
                }
    
                if ((getLogInUser()->hasRole('patient'))) {
                    if (! empty($userInput['image'])) {
                        $user->clearMediaCollection(Patient::PROFILE);
                        $user->patient->media()->delete();
                        $user->patient->addMedia($userInput['image'])->toMediaCollection(Patient::PROFILE,
                            config('app.media_disc'));
                    }
                } else {
                    if ((! empty($userInput['image']))) {
                        $user->clearMediaCollection(User::PROFILE);
                        $user->media()->delete();
                        $user->addMedia($userInput['image'])->toMediaCollection(User::PROFILE, config('app.media_disc'));
                    }
                }
            }else if(auth()->user()->role_name=='Doctor'){
       

                $doctor =  Doctor::where('user_id',$user->id)->first();
    
    
                $addressInputArray = Arr::only($userInput,
                    ['address1', 'address2', 'city_id', 'state_id', 'country_id', 'postal_code']);
                $userInput['type'] = User::DOCTOR;
                $userInput['email'] = setEmailLowerCase($userInput['email']);
                /** @var Doctor $doctor */
                
                $doctor->user()->update(Arr::except($userInput, [
                    'address1', 'address2', 'city_id', 'state_id', 'country_id', 'postal_code', 'doctor_unique_id',
                    'avatar_remove',
                    'profile', 'is_edit', 'edit_doctor_country_id', 'edit_doctor_state_id', 'edit_doctor_city_id',
                    'backgroundImg',
                ]));

                $doctor = Doctor::update([
                    'availability'=>json_encode($userInput['availability']),
                    'services'=>json_encode($userInput['services']),
                    'sub_urgent_care'=>json_encode($userInput['sub_urgent_care']),
                    'sub_preventive_health'=>json_encode($userInput['sub_preventive_health']),
                    'can_start'=>$userInput['can_start'],
                    'child_care'=>$userInput['child_care'],
                    'chronic_care'=>$userInput['chronic_care'],
                    'education'=>$userInput['education'],
                    'experience'=>$userInput['experience'],
                    'instagram_url'=>$userInput['instagram_url'],
                    'linkedin_url'=>$userInput['linkedin_url'],
                    'mental_health'=>$userInput['mental_health'],
                    'prefix'=>$userInput['prefix'],
                    'preventive_health'=>$userInput['preventive_health'],
                    'services_can_be_performed_online'=>$userInput['services_can_be_performed_online'],
                    'sexual_health'=>$userInput['sexual_health'],
                    'skin_and_hair'=>$userInput['skin_and_hair'],
                    'start_date'=>$userInput['start_date'],
                    'twitter_url'=>$userInput['twitter_url'],
                    'urgent_care'=>$userInput['urgent_care'],
    
            ]);
                
    
                if(isset($doctor->address)){
                    $doctor->address()->update($addressInputArray);
                }else{
                    $doctor->address()->create($addressInputArray);
                }
    
                if ((getLogInUser()->hasRole('doctor'))) {
                    if (! empty($userInput['image'])) {
                        $user->clearMediaCollection(Doctor::PROFILE);
                        $user->doctor->media()->delete();
                        $user->doctor->addMedia($userInput['image'])->toMediaCollection(Doctor::PROFILE,
                            config('app.media_disc'));
                    }
                } else {
                    if ((! empty($userInput['image']))) {
                        $user->clearMediaCollection(User::PROFILE);
                        $user->media()->delete();
                        $user->addMedia($userInput['image'])->toMediaCollection(User::PROFILE, config('app.media_disc'));
                    }
                }
            }

            DB::commit();

            return true;
        } catch (\Exception $e) {
            DB::rollBack();

            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }

    /**
     * @return mixed
     */
    public function getSpecializationsData($doctor)
    {
        $data['specializations'] = Specialization::pluck('name', 'id')->toArray();
        $data['doctorSpecializations'] = $doctor->specializations()->pluck('specialization_id')->toArray();
        $data['countryId'] = $doctor->user->address()->pluck('country_id');
        $data['stateId'] = $doctor->user->address()->pluck('state_id');

        return $data;
    }

    /**
     * @return mixed
     */
    public function getCountries()
    {
        $countries = Country::pluck('name', 'id');

        return $countries;
    }

    public function addQualification($input)
    {
        $input['user_id'] = $input['id'];
        $qualification = Qualification::create($input);

        return $qualification;
    }

    /**
     * @throws \Exception
     */
    public function doctorDetail($input): array
    {
        $todayDate = Carbon::now()->format('Y-m-d');
        $doctor['data'] = Doctor::with(['user.address', 'specializations', 'appointments.patient.user'])->whereId($input->id)->first();
        $doctor['doctorSession'] = DoctorSession::whereDoctorId($input->id)->get();
        //        $doctor['appointments'] = DataTables::of((new UserDataTable())->getAppointment($input->id))->make(true);
        $doctor['appointmentStatus'] = Appointment::ALL_STATUS;
        $doctor['totalAppointmentCount'] = Appointment::whereDoctorId($input->id)->count();
        $doctor['todayAppointmentCount'] = Appointment::whereDoctorId($input->id)->where('date', '=',
            $todayDate)->count();
        $doctor['upcomingAppointmentCount'] = Appointment::whereDoctorId($input->id)->where('date', '>',
            $todayDate)->count();

        return $doctor;
    }
}
