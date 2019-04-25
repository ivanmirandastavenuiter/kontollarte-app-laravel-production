<?php

namespace App\Http\Controllers;

use App\Http\Controllers\SessionController;
use Illuminate\Http\Request;
use App\Receiver;
use App\Message;
use App\Paint;
use URL;
use DateTime;
use Autoload;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class MessagesController extends Controller
{
    private $session;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
       $this->middleware('session.manager');
    }

    public function display(Request $request)
    {
        $this->session = SessionController::getInstance($request);
        $currentUser = $this->session->getUserLogged();
        $currentUser->refresh();

        $userMessagesList = $currentUser->messages()
                                        ->with('receivers')
                                        ->get();
        $galleriesUserList = $currentUser->galleries;

        return view('sections.messages')
                    ->with([
                        'view' => 'messages',
                        'userMessagesList' => $userMessagesList,
                        'galleriesUserList' => $galleriesUserList
                    ]);

    }

    public function handleMessageRequest(Request $request) 
    {
        $this->session = SessionController::getInstance($request);
        $currentUser = $this->session->getUserLogged()
                                     ->refresh();

        $galleriesIds = $request->input('galleriesList') ?: null;
        $messageBody = $request->input('messageBody') ?: null;

        if ($galleriesIds !== null && $messageBody !== null) {

            $galleriesSelected = $currentUser->galleries()->find($galleriesIds);
            $paintingsList = $currentUser->paints;

            $response = [
                'result' => true,
                'messageBody' => $messageBody,
                'receivers' => $galleriesSelected,
                'paintings' => $paintingsList
            ];

            echo json_encode($response);

        } else {

            $response['result'] = false;
            echo json_encode($response);

        }

    }

    public function executeMessageRequest(Request $request) {

        $this->session = SessionController::getInstance($request);
        $currentUser = $this->session->getUserLogged()
                                     ->refresh();

        $messageBody = $request->input('message-content');
        $receiversList = json_decode($request->input('receivers')[0]); // Sent through JSON to receive the stdObject
        $paintingsList = json_decode($request->input('pictures')[0]);
        $receiversListCollection = collect();
        $paintingsListCollection = collect();

        foreach($paintingsList as $currentPaint) {
            $paintToStore = new Paint ([
                'paintName' => $currentPaint->paintName,
                'paintDate' => $currentPaint->paintDate,
                'paintDescription' => $currentPaint->paintDescription,
                'paintImage' => $currentPaint->paintImage,
                'userId' => $currentUser->userId
            ]);
            $paintingsListCollection->push($paintToStore);
        }

        foreach($receiversList as $currentGallery) {
            $receiverToStore = new Receiver ([
                'receiverId' => $currentGallery->galleryId,
                'receiverEmail' => $currentGallery->galleryEmail,
                'receiverName' => $currentGallery->galleryName
            ]);
            $receiversListCollection->push($receiverToStore);
        }

        $messageToStore = new Message ([
            'messageBody' => $messageBody,
            'messageDate' => new DateTime(), 
            'userId' => $currentUser->userId
        ]);

        $newReceiversList = $receiversListCollection->reject(function($value) {
            return Receiver::all()
                            ->pluck('receiverEmail')
                            ->contains($value->receiverEmail);
        });
        
        $currentUser->messages()
                        ->save($messageToStore)
                        ->receivers()
                        ->saveMany($newReceiversList);

        $details = [
            'paintings' => $paintingsListCollection,
            'message' => $messageBody
        ];

        foreach ($receiversListCollection as $currentReceiver) {
            $this->sendEmailThroughSMTP($details, $currentReceiver);
        }

        return redirect()->route('messages.display')
                            ->with('success', 'Your message has been successfully sent');

    }
    
    private function sendEmailThroughSMTP($details, $receiver) {

        $email = 'ivanmist90@gmail.com'; // Supposed to be $receiver->receiverEmail;
        $name = $receiver->receiverName;
        $body = $details['message'];

        $mail = new PHPMailer;
        $mail->isSMTP();
        $mail->SMTPDebug = 0;
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = 587;
        $mail->SMTPSecure = 'tls';
        $mail->SMTPAuth = true;

        $mail->Username = "junkholebin@gmail.com"; // Your email 
        $mail->Password = "20122012Rr.";

        $mail->setFrom('junkholebin@gmail.com', "Hello $name");
        $mail->addReplyTo('junkholebin@gmail.com', "Hello $name");
        $mail->addAddress($email, $name);
        $mail->Subject = 'Purpose of contact';
        $this->writeHTMLMessage($body);
        $mail->msgHTML(file_get_contents('html/contents.html'), __DIR__);
        $mail->AltBody = 'This is a plain-text message body';

        $paintsSelected = $details['paintings'];

        if (!empty($paintsSelected)) {
            foreach($paintsSelected as $currentPaint) {
                $mail->addAttachment($currentPaint->paintImage);
            }
        }

        $mail->send();

        /*
        if (!$mail->send()) {
            echo "Mailer Error: " . $mail->ErrorInfo;
        } else {
            echo "Message sent!";
        }
        */
    }

    private function writeHTMLMessage($messageBody) {

        $path = 'html/contents.html';
        $HTMLCode = '';
        $HTMLCode.= 

<<<EX
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Content</title>
    </head>
    <body>
        <p>{$messageBody}</p>
    </body>
    </html>
EX;
    
        file_put_contents($path, $HTMLCode);
    }

    public function getUrlHashToken(Request $request) {
        return $request->has('parameters') ? 
                        URL::signedRoute($request->input('route'), 
                                            [
                                                'messageBody' => $request->input('parameters')['messageBody'],
                                                'galleriesList' => $request->input('parameters')['galleriesList']
                                            ]) :
                        URL::signedRoute($request->input('route'));
    }
}
