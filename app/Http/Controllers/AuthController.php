<?php

namespace App\Http\Controllers;

use App\Models\Bank_Employee;
use App\Models\Merchant_Employee;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\signup;
use PhpParser\Node\Stmt\TryCatch;

class AuthController extends Controller
{
    /**
     *  this function register bank employees
     */

    public function registerBankEmployee(Request $request)
    {
        $random = $this->generateOtp();  // get random token
        $milliseconds = floor(microtime(true) * 1000) + 600000; // set verification expiry
        $fields = $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'email:rfc,dns|required|string|unique:bank__employees,email',
            'username' => 'required|string|unique:bank__employees,username',
            'password' => 'required',
            'client_permission' => 'required',
            'user_permission' => 'required',
            'bank_id' => 'required',
            'employee_id' => 'required',
            'role' => 'required',
        ]);

        $user = Bank_Employee::create([
            'first_name' => $fields['first_name'],
            'last_name' => $fields['last_name'],
            'email' => strtolower(trim($fields['email'])),
            'password' => bcrypt($fields['password']),
            'username' => strtolower(trim($fields['username'])),
            'client_permission' => $fields['client_permission'],
            'user_permission' => $fields['user_permission'],
            'bank_id' => $fields['bank_id'],
            'employee_id' => $fields['employee_id'],
            'role' => $fields['role'],
            'token' => $random,
            'token_exp' => $milliseconds
        ]);

        $token = $user->createToken('myapptoken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        //send a mail
        //Mail::to("donsoj1st@gmail.com")->send(new signup());
        return response($response, 201);
    }


    /**
     * bank employees login controller
     */
    public function bankLogin(Request $request)
    {
        $fields = $request->validate([
            'email' => 'email:rfc,dns| required|string',
            'password' => 'required|string'
        ]);

        // Check email
        $user = Bank_Employee::where('email', strtolower(trim($fields['email'])))->first();

        // Check password
        if (!$user || !Hash::check($fields['password'], $user->password)) {
            return response([
                'message' => 'Bad creds'
            ], 401);
        }

        $token = $user->createToken('myapptoken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }

    /**
     * forget password route for bank
     */
    public function bankForgotPassword(Request $request)
    {
        $fields = $request->validate([
            'email' => 'email:rfc,dns|required|string',
        ]);

        // Check email
        $user = Bank_Employee::where('email', strtolower(trim($fields['email'])))->first();

        // Check user
        if (!$user) {
            return response([
                'message' => 'no user attarched to the email'
            ], 401);
        }

        $user->update([
            'token' => sha1(time())
        ]);
        info('This is some useful information.');
        // $response = [
        //     'user' => $user,
        //     'token' => $token
        // ];

        //send a mail
        //Mail::to(strtolower(trim($fields['email'])->send(new ForgotPassword());
        return response([
            'message' => 'email sent to the user'
        ], 201);
    }

    /**
     * reset password route for bank
     */
    public function bankResetPassword(Request $request, string $id)
    {
        // validate password
        $fields = $request->validate([
            'password' => 'required|string',
        ]);

        // find the user
        $user = Bank_Employee::where('token', $id)->first();

        // Check user
        if (!$user) {
            return response([
                'message' => 'user not found'
            ], 401);
        }

        $user->update([
            'token' => null,
            'password' => bcrypt($fields['password']),
        ]);


        return response([
            'message' => 'password update successful'
        ], 201);
    }

    /**
     * this method verify the bank employee 
     * 
     */
    public function BankVerify(Request $request, string $id)
    {
        $milliseconds = floor(microtime(true) * 1000);
        $user = Bank_Employee::where('token', $id)->first();
        if (!$user) {
            return response([
                'message' => 'user not found'
            ], 401);
        }
        if ($user->token_exp > floor(microtime(true) * 1000)) {
            $user->update([
                'email_verified_at' => date('Y-m-d H:i:s'),
                'token' => null
            ]);

            return response([
                'message' => 'account verification successful'
            ], 201);
        }
        return response([
            'message' => 'account verification unsuccessful'
        ], 401);
    }

    /**
     * forget password route for merchant
     */
    public function resendOtp(Request $request)
    {
        $fields = $request->validate([
            'email' => 'email:rfc,dns|required|string',
        ]);

        $milliseconds = floor(microtime(true) * 1000) + 600000; // set verification expiry
        // Check email
        $user = Bank_Employee::where('email', strtolower(trim($fields['email'])))->first();

        // Check user
        if (!$user) {
            return response([
                'message' => 'no user attarched to the email'
            ], 401);
        }

        $user->update([
            'token' =>  $this->generateOtp(), // get random token
            'token_exp' => $milliseconds
        ]);

        //send a mail
        //Mail::to(strtolower(trim($fields['email'])->send(new ForgotPassword());
        return response([
            'message' => 'email sent to the user'
        ], 201);
    }





    ///////////////////////////////////////////////////////////////////////////////////////////

    /**
     * this method create the client 
     * 
     */
    public function registerMerchantEmployee(Request $request)
    {
        $random = $this->generateOtp();
        $milliseconds = floor(microtime(true) * 1000) + 600000;
        $fields = $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'email:rfc,dns|required|string|unique:merchant__employees,email',
            'username' => 'required|string|unique:merchant__employees,username',
            'password' => 'required',
            'user_permission' => 'required',
            'employee_id' => "required|string",
            'role' => "required|string",
        ]);

        $user = Merchant_Employee::create([
            'first_name' => $fields['first_name'],
            'last_name' => $fields['last_name'],
            'email' =>  strtolower(trim($fields['email'])),
            'password' => bcrypt($fields['password']),
            'username' => strtolower(trim($fields['username'])),
            'user_permission' => $fields['user_permission'],
            'employee_id' => $fields['employee_id'],
            'role' => $fields['role'],
            'token' => $random,
            'token_exp' => $milliseconds
        ]);

        $token = $user->createToken('myapptoken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        //send a mail
        //Mail::to("donsoj1st@gmail.com")->send(new signup());
        return response($response, 201);
    }

    /**
     * the merchant login route 
     * 
     */
    public function merchantLogin(Request $request)
    {
        $fields = $request->validate([
            'email' => 'email:rfc,dns|required|string',
            'password' => 'required|string'
        ]);

        // Check email
        $user = Merchant_Employee::where('email', strtolower(trim($fields['email'])))->first();

        // Check password
        if (!$user || !Hash::check($fields['password'], $user->password)) {
            return response([
                'message' => 'Bad creds'
            ], 401);
        }

        $token = $user->createToken('myapptoken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }

    /**
     * forget password route for merchant
     */
    public function merchantForgotPassword(Request $request)
    {
        $fields = $request->validate([
            'email' => 'email:rfc,dns|required|string',
        ]);

        // Check email
        $user = Merchant_Employee::where('email', strtolower(trim($fields['email'])))->first();

        // Check user
        if (!$user) {
            return response([
                'message' => 'no user attarched to the email'
            ], 401);
        }

        $user->update([
            'token' => sha1(time())
        ]);
        info('This is some useful information.');
        // $response = [
        //     'user' => $user,
        //     'token' => $token
        // ];

        //send a mail
        //Mail::to(strtolower(trim($fields['email'])->send(new ForgotPassword());
        return response([
            'message' => 'email sent to the user'
        ], 201);
    }

    /**
     * reset password route for merchant
     */
    public function merchantResetPassword(Request $request, string $id)
    {
        // validate password
        $fields = $request->validate([
            'password' => 'required|string',
        ]);

        // find the user
        $user = Merchant_Employee::where('token', $id)->first();

        // Check user
        if (!$user) {
            return response([
                'message' => 'user not found'
            ], 401);
        }

        $user->update([
            'token' => null,
            'password' => bcrypt($fields['password']),
        ]);


        return response([
            'message' => 'password update successful'
        ], 201);
    }

    /**
     * 
     * logout all user from the application 
     */

    public function logout(Request $request)
    {
        request()->user()->currentAccessToken()->delete();

        return [
            'message' => 'Logged out'
        ];
    }

    /**
     * this method verify the merchant employee 
     * 
     */
    public function merchantVerify(Request $request, string $id)
    {
        $milliseconds = floor(microtime(true) * 1000);
        $user = Merchant_Employee::where('token', $id)->first();
        if (!$user) {
            return response([
                'message' => 'user not found'
            ], 401);
        }
        if ($user->token_exp > floor(microtime(true) * 1000)) {
            $user->update([
                'email_verified_at' => date('Y-m-d H:i:s'),
                'token' => null
            ]);

            return response([
                'message' => 'account verification successful'
            ], 201);
        }
        return response([
            'message' => 'account verification unsuccessful'
        ], 401);
    }

    /**
     * resent otp for merchant
     */
    public function resendMerchantOtp(Request $request)
    {
        $fields = $request->validate([
            'email' => 'email:rfc,dns|required|string',
        ]);

        $milliseconds = floor(microtime(true) * 1000) + 600000; // set verification expiry
        // Check email
        $user = Merchant_Employee::where('email', strtolower(trim($fields['email'])))->first();

        // Check user
        if (!$user) {
            return response([
                'message' => 'no user attarched to the email'
            ], 401);
        }

        $user->update([
            'token' =>  $this->generateOtp(), // get random token
            'token_exp' => $milliseconds
        ]);

        //send a mail
        //Mail::to(strtolower(trim($fields['email'])->send(new ForgotPassword());
        return response([
            'message' => 'email sent to the user'
        ], 201);
    }


    /**
     * private function to generate otp
     */
    private function generateOtp()
    {
        $randomNumber = 0000;

        do {
            $randomNumber = random_int(1000, 9999);
            $merchant = Merchant_Employee::where('token', $randomNumber)->first();
            $bank = Bank_Employee::where('token', $randomNumber)->first();
        } while ($merchant || $bank);

        return $randomNumber;
    }
}
