<?php

namespace App\Http\Controllers;

use App\Exceptions\CustomValidationException;
use App\Mail\ResetPasswordMail;
use App\Models\User;
use App\Services\AWS\EmailSenderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
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

            return $user;
        });

        $data = $this->model::find($user->id);

        return response()->json($data, 201);
    }

    public function reset_password(Request $request) {
        $data = $request->validate([
            'email' => 'required|email|max:255'
        ]);

        $user = User::where('email', $data['email'])->limit(1)->get()[0];
        
        if (!$user) {
            throw new CustomValidationException('E-mail não registrado no APP da Fit Motive.');
        }

        $password_reset_token = $user->password_reset_token()->create([
            'email' => $data['email'],
            'token' => Str::random(16)
        ]);

        $body = view('mails.reset-password', [
            'user' => $user, 'resetLink' => 
            "http://localhost:8000/api/reset_password_check?token={$password_reset_token->token}"
        ])->render();

        $emailSender = new EmailSenderService();
        $emailSender->sendEmail($user->email, 'Redefina sua senha - Fit Motive', $body);

        return response()->json(['message' => 'E-mail enviado!'], 200);
    }

    public function reset_password_check(Request $request) {
        $data = $request->validate([
            'token' => 'required|string'
        ]);

        
    }
}
