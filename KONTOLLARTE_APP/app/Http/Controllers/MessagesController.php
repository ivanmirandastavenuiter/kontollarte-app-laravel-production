<?php

namespace App\Http\Controllers;

use App\Http\Controllers\SessionController;
use Illuminate\Http\Request;
use App\Receiver;
use App\Message;
use App\Paint;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use App\Http\Services\Interfaces\IHasher;
use DB;
use URL;
use DateTime;
use Autoload;

class MessagesController extends Controller implements IHasher
{
    /**
     * A session instance for the controller.
     * 
     */
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

    /**
     * Display the main page view.
     *
     * @param  \Illuminate\Http\Request $request
     * @return Illuminate\View\View
     */
    public function display(Request $request)
    {
        $this->session = SessionController::getInstance($request);
        $currentUser = $this->session->getUserLogged();
        $currentUser->refresh();

        // Eager loading. Bring the model with related ones in one call
        $userMessagesList = $currentUser->messages()
                                        ->with('receivers')
                                        ->get();
        $galleriesUserList = $currentUser->galleries;
        $paintsUserList = $currentUser->paints;

        return view('sections.messages')
                ->with([
                    'view' => 'messages',
                    'userMessagesList' => $userMessagesList,
                    'galleriesUserList' => $galleriesUserList,
                    'paintsUserList' => $paintsUserList
                ]);

    }

    /**
     * Prepare the message request at first.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
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

    /**
     * Executes message sending operation after data is provided
     *
     * @param  \Illuminate\Http\Request $request
     * @return void
     */
    public function executeMessageRequest(Request $request) {

        $this->session = SessionController::getInstance($request);
        $currentUser = $this->session->getUserLogged()
                                     ->refresh();

        $messageBody = $request->input('message-content');

        // $receiversList and $paintingsList are sent dinamically through jQuery
        // Data is passed through json to make possible data transfer
        $receiversList = json_decode($request->input('receivers')[0]); 
        $paintingsList = json_decode($request->input('pictures')[0]);

        // Use of collection laravel object
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

        /** 
        * Insert operation follows this logic:
        *
        * One message can be for one or several receivers
        * The message is always new and original
        * Galleries could be stored before, then logic acts taking that detail in count
        */

        // First, message is inserted
        DB::table('messages')
                    ->insert([
                        'messageBody' => $messageBody,
                        'messageDate' => new DateTime(), 
                        'userId' => $currentUser->userId,
                        'created_at' => new DateTime(),
                        'updated_at' => new DateTime()  
                    ]);

        // Second step: get the message id of the instance just inserted
        $messageId = DB::table('messages')
                                ->latest()
                                ->first()
                                ->messageId;

        $receiversNames = collect();

        foreach($receiversList as $currentGallery) {

            if (!Receiver::all()
                        ->pluck('receiverEmail') // Pluck permits returning only one column of database
                        ->contains($currentGallery->galleryEmail)) {

                    // If gallery not saved on database yet
                    DB::table('receivers')
                                ->insert([
                                    'receiverName' => $currentGallery->galleryName,
                                    'receiverEmail' => $currentGallery->galleryEmail,
                                    'created_at' => new DateTime(),
                                    'updated_at' => new DateTime()  
                                ]);
            } 

            // Remain the receivers
            $receiversNames->push($currentGallery->galleryName);
        } 

        foreach ($receiversNames as $currentName) {

            $receiverId = DB::table('receivers')
                                    ->where('receiverName', $currentName)
                                    ->value('receiverId');

            // Third step: saving on intermediate table
            DB::table('messages_receivers')
                                ->insert([
                                    'messageId' => $messageId,
                                    'receiverId' => $receiverId
                                ]);

        }

        $details = [
            'paintings' => $paintingsListCollection,
            'message' => $messageBody
        ];

        // Email sending with PHPMailer
        foreach ($receiversList as $currentReceiver) {
            $this->sendEmailThroughSMTP($details, $currentReceiver);
        }

        return redirect()->route('messages.display')
                            ->with('success', 'Your message has been successfully sent');

    }
    
    /**
     * Send email with PHPMailer
     *
     * @param  array $details
     * @param \App\Receiver $receiver
     * @return void
     */
    private function sendEmailThroughSMTP($details, $receiver) {

        $email = ''; // Supposed to be $receiver->receiverEmail;
        $name = $receiver->galleryName;
        $body = $details['message'];

        $mail = new PHPMailer;
        $mail->isSMTP();
        $mail->SMTPDebug = 0;
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = 587;
        $mail->SMTPSecure = 'tls';
        $mail->SMTPAuth = true;

        $mail->Username = ""; // Your email 
        $mail->Password = "";

        $mail->setFrom('', "Hello $name");
        $mail->addReplyTo('', "Hello $name");
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

        if (!$mail->send()) {
            echo "Mailer Error: " . $mail->ErrorInfo;
        } else {
            echo "Message sent!";
        }
    }

    /**
     * Store the message content.
     *
     * @param string @messageBody
     * @return void
     */
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

    /**
     * Convert normal route to a signed route.
     *
     * @param  \Illuminate\Http\Request $request
     * @return string
     */
    public function getUrlHashToken(Request $request) {

        // Depending on the case, it asks for a certain url format
        return $request->has('parameters') ? 
                        URL::signedRoute($request->input('route'), 
                                            [
                                                'messageBody' => $request->input('parameters')['messageBody'],
                                                'galleriesList' => $request->input('parameters')['galleriesList']
                                            ]) :
                        URL::signedRoute($request->input('route'));
    }
}
