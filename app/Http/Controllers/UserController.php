<?php

namespace App\Http\Controllers;

use App\Enums\LogActionEnum;
use App\Exceptions\CustomValidationException;
use App\Models\User;
use App\Services\AWS\EmailSenderService;
use App\Services\System\LogService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function __construct(User $model, Request $request) {
        $this->model = $model;
        $this->request = $request;
    }

    public function store(Request $request) {
        $data = $request->validate($this->model::rules());

        $user = DB::transaction(function () use ($data) {
            $user = User::create($data);

            if (isset($data['adresses'])) {
                foreach ($data['phones'] as $phone) {
                    $user->phones()->create($phone);
                }
            }
            
            if (isset($data['adresses'])) {
                foreach ($data['adresses'] as $address) {
                    $user->adresses()->create($address);
                }
            }

            if (isset($data['payment_methods'])) {
                foreach ($data['payment_methods'] as $paymentMethod) {
                    $user->payment_methods()->create($paymentMethod);
                }
            }

            if (isset($data['provider'])) {
                $user->provider()->create($data['provider']);
            }

            if (isset($data['patient'])) {
                $user->patient()->create($data['patient']);
            }

            LogService::log('Cadastro de usuário (ID '.$user->id.')', LogActionEnum::Create);

            return $user;
        });

        $data = $this->model::find($user->id);

        return response()->json($data, 201);
    }

    public function reset_password(Request $request) {
        $data = $request->validate([
            'email' => 'required|email|max:255'
        ]);

        $user = User::where('email', $data['email'])->limit(1)->get();
        
        if (!$user || !count($user)) {
            throw new CustomValidationException('Infelizmente não encontramos seu e-mail em nossa base. Confira se foi digitado corretamente e tente novamente.');
        }

        $user = $user[0];
        $password = Str::random(16);

        $user->update([
            'password' => $password
        ]);

        $body = view('mails.reset-password', [
            'user' => $user, 
            'newPassword' => $password
        ])->render();

        $emailSender = new EmailSenderService();
        $emailSender->sendEmail($user->email, 'Redefinição de senha - Fit Motive', $body);

        LogService::log('Reset de senha (ID '.$user->id.')', LogActionEnum::Other);

        return response()->json(['message' => 'Senha redefinida!'], 200);
    }
}
