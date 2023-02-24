<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use League\OAuth2\Client\Provider\Google;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\OAuth;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


class MailController extends Controller
{
    private $email;
    private $name;
    private $client_id;
    private $client_secret;
    private $token;
    private $provider;

    public function __construct()
    {


        $this->client_id        = env('GOOGLE_API_CLIENT_ID');
        $this->client_secret    = env('GOOGLE_API_CLIENT_SECRET');
        $this->provider         = new Google(
            [
                'clientId'      => $this->client_id,
                'clientSecret'  => $this->client_secret
            ]
        );
    }

    public function sendcredentials(Request $request)
    {
        $receiver = $request->email;
        $name = $request->name;
        $pass = $request->password;
        $this->token = '1//0e35DqS4PoQcQCgYIARAAGA4SNwF-L9IrNMkS7-eOy0BfmD7vJGfEokDDLgKRbJemH82uz6P9_k6EbfhBVvFi4YW0-KcB85_hKew';
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->SMTPDebug = SMTP::DEBUG_OFF;
            $mail->Host = 'smtp.gmail.com';
            $mail->Port = 465;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->SMTPAuth = true;
            $mail->AuthType = 'XOAUTH2';
            $mail->setOAuth(
                new OAuth(
                    [
                        'provider'          => $this->provider,
                        'clientId'          => $this->client_id,
                        'clientSecret'      => $this->client_secret,
                        'refreshToken'      => '1//0eQlzhf8lbEVwCgYIARAAGA4SNwF-L9IrNAwCKnS3Cf5kmvkA0EncdXj5LWrzKaFCgy-CsCTnIodGG8GwLM6-vOY_fFubhO8ZEbE',
                        'userName'          => 'dplmhsyearbook@gmail.com'
                    ]
                )
            );

            $mail->setFrom('dplmhsyearbook@gmail.com', 'NoReply@Ed-detection');
            $mail->addAddress('reenjie17@gmail.com', 'Reenjay');
            $mail->Subject = 'ONE TIME PIN';
            $mail->CharSet = PHPMailer::CHARSET_UTF8;
            $body = '<!DOCTYPE html>
           <html lang="en">
           
           <head>
               <meta charset="UTF-8">
               <meta name="viewport" content="width=device-width, initial-scale=1.0">
               <meta http-equiv="X-UA-Compatible" content="ie=edge">
               <title></title>
           </head>
           
           <body >
           
           
                   <h4>Your one-Time-pin is</h4>
           
           
                       
                        <h1>462123</h1>
                
                   <br>
                   <h5>
                       Do not share this to anyone.
                       <br>
           
                       All rights Reserved &middot; 2022
           
                   </h5>
                   <p><br><br><br></p>
           
           </body>
           
           </html>
           
           ';
            $mail->msgHTML($body);
            $mail->AltBody = 'This is a plain text message body';
            if ($mail->send()) {
                echo 'send';
            } else {
                echo 'not send';
                //  return redirect()->back()->with('error', 'Unable to send email.');
            }
        } catch (Exception $e) {
            return $e;
            //   return redirect()->back()->with('error', 'Exception: ' . $e->getMessage());
        }
    }

    public function verify()
    {
        // 

        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->SMTPDebug = SMTP::DEBUG_OFF;
            $mail->Host = 'smtp.gmail.com';
            $mail->Port = 465;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->SMTPAuth = true;
            $mail->AuthType = 'XOAUTH2';
            $mail->setOAuth(
                new OAuth(
                    [
                        'provider'          => $this->provider,
                        'clientId'          => $this->client_id,
                        'clientSecret'      => $this->client_secret,
                        'refreshToken'      => '1//0eQlzhf8lbEVwCgYIARAAGA4SNwF-L9IrNAwCKnS3Cf5kmvkA0EncdXj5LWrzKaFCgy-CsCTnIodGG8GwLM6-vOY_fFubhO8ZEbE',
                        'userName'          => 'dplmhsyearbook@gmail.com'
                    ]
                )
            );

            $mail->setFrom('dplmhsyearbook@gmail.com', 'DPLMHS-Noreply');
            $mail->addAddress(Auth::user()->email, Auth::user()->Firstname . ' ' . Auth::user()->Lastname);
            $mail->Subject = 'ONE TIME PIN';
            $mail->CharSet = PHPMailer::CHARSET_UTF8;
            $body = '<!DOCTYPE html>
            <html lang="en">
            
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <meta http-equiv="X-UA-Compatible" content="ie=edge">
                <title></title>
            </head>
            
            <body >
            
            
                    <h4>Your one-Time-pin is</h4>
            
            
                        
                         <h1>' . session()->get('vcode') . '</h1>
                 
                    <br>
                    <h5>
                        Do not share this to anyone.
                        <br>
            
                        All rights Reserved &middot; 2022
            
                    </h5>
                    <p><br><br><br></p>
            
            </body>
            
            </html>
            
            ';
            $mail->msgHTML($body);
            $mail->AltBody = 'This is a plain text message body';
            if ($mail->send()) {
                session(['verifying' => 1]);
                return redirect()->back();
            } else {
                echo 'not send';
                //  return redirect()->back()->with('error', 'Unable to send email.');
            }
        } catch (Exception $e) {
            return $e;
            //   return redirect()->back()->with('error', 'Exception: ' . $e->getMessage());
        }

        // ;
    }

    public function checkverify(Request $request)
    {
        $code = $request->code;
        $current = session()->get('vcode');

        if ($code == $current) {

            User::where('id', Auth::user()->id)->update([
                'vrfy' => 1,
            ]);
            return redirect()->Back()->with('VerifiedSuccessfully', '1');
        } else {
            return redirect()->Back()->with('codenotmatch', '1');
        }
    }


    public function sendresetlink(Request $request)
    {
        $email = $request->email;
        $link  = $request->url;


        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->SMTPDebug = SMTP::DEBUG_OFF;
            $mail->Host = 'smtp.gmail.com';
            $mail->Port = 465;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->SMTPAuth = true;
            $mail->AuthType = 'XOAUTH2';
            $mail->setOAuth(
                new OAuth(
                    [
                        'provider'          => $this->provider,
                        'clientId'          => $this->client_id,
                        'clientSecret'      => $this->client_secret,
                        'refreshToken'      => '1//0eQlzhf8lbEVwCgYIARAAGA4SNwF-L9IrNAwCKnS3Cf5kmvkA0EncdXj5LWrzKaFCgy-CsCTnIodGG8GwLM6-vOY_fFubhO8ZEbE',
                        'userName'          => 'dplmhsyearbook@gmail.com'
                    ]
                )
            );

            $mail->setFrom('dplmhsyearbook@gmail.com', 'DPLMHS-Noreply');
            $mail->addAddress($email, $email);
            $mail->Subject = 'RESET LINK';
            $mail->CharSet = PHPMailer::CHARSET_UTF8;
            $body = '<!DOCTYPE html>
            <html lang="en">
            
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <meta http-equiv="X-UA-Compatible" content="ie=edge">
                <title></title>
            </head>
            
            <body >
            
            
                    <h4>Click the link Below to Reset Your Password.</h4>
            
            
                        
                        <a href=' . $link . '> <h1>' . $link . '</h1> </a>
                 
                    <br>
                    <h5>
                        Do not share this to anyone.
                        <br>
            
                        All rights Reserved &middot; 2022
            
                    </h5>
                    <p><br><br><br></p>
            
            </body>
            
            </html>
            
            ';
            $mail->msgHTML($body);
            $mail->AltBody = 'This is a plain text message body';
            if ($mail->send()) {

                session(['reset' => $email]);
                return redirect()->back();
            } else {
                echo 'not send';
                //  return redirect()->back()->with('error', 'Unable to send email.');
            }
        } catch (Exception $e) {
            return $e;
            //   return redirect()->back()->with('error', 'Exception: ' . $e->getMessage());
        }
    }

    public function notifyready(Request $request)
    {
        $user = $request->user;
        $name = $user['Name'];
        $email = $user['Email'];


        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->SMTPDebug = SMTP::DEBUG_OFF;
            $mail->Host = 'smtp.gmail.com';
            $mail->Port = 465;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->SMTPAuth = true;
            $mail->AuthType = 'XOAUTH2';
            $mail->setOAuth(
                new OAuth(
                    [
                        'provider'          => $this->provider,
                        'clientId'          => $this->client_id,
                        'clientSecret'      => $this->client_secret,
                        'refreshToken'      => '1//0eQlzhf8lbEVwCgYIARAAGA4SNwF-L9IrNAwCKnS3Cf5kmvkA0EncdXj5LWrzKaFCgy-CsCTnIodGG8GwLM6-vOY_fFubhO8ZEbE',
                        'userName'          => 'dplmhsyearbook@gmail.com'
                    ]
                )
            );

            $mail->setFrom('dplmhsyearbook@gmail.com', 'DPLMHS-Noreply');
            $mail->addAddress($email, $name);
            $mail->Subject = 'OFFICIAL RECEIPT | Yearbook Copy';
            $mail->CharSet = PHPMailer::CHARSET_UTF8;
            $body = '<!DOCTYPE html>
            <html lang="en">
            
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <meta http-equiv="X-UA-Compatible" content="ie=edge">
                <title></title>
            </head>
            
            <body >
            
            
                 
            
                        
                         <h1 style="color:blue">OFFICIAL RECEIPT 
                         <br/>
                        
                         </h1>
                         <h2>For ' . $name . ' 
                         <br/>
                         Confirm#:   <span style="color:red">' . date('Ymd') . '</span>
                      
                         </h2>
                         <h3>
                            This is to inform you that your copy of yearbook is now ready.
                            <br/>
                            Please bring and show this Email notification when claiming thank you...
                         </h3>
                 
                    <br>
                    <h5>
                        Do not share this to anyone.
                        <br>
            
                        All rights Reserved &middot; Yearbook Website;
            
                    </h5>
                    <p><br><br><br></p>
            
            </body>
            
            </html>
            
            ';
            $mail->msgHTML($body);
            $mail->AltBody = 'This is a plain text message body';
            if ($mail->send()) {

                return redirect()->back();
            } else {
                echo 'not send';
                //  return redirect()->back()->with('error', 'Unable to send email.');
            }
        } catch (Exception $e) {
            return $e;
            //   return redirect()->back()->with('error', 'Exception: ' . $e->getMessage());
        }

        // ;
    }
}
