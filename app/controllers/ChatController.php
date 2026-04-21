<?php
require_once 'BaseController.php';
require_once 'app/models/MessageModel.php';

class ChatController extends BaseController {
    private $messageModel;

    public function __construct() {
        parent::__construct();
        $this->messageModel = new MessageModel();
    }

    public function index() {
        if (!isLoggedIn()) {
            $this->redirect('index.php?page=auth');
        }
        $matches = (new MatchModel())->getMatches(getCurrentUser());
        $this->render('chat/index', ['matches' => $matches]);
    }

    public function conversation() {
        if (!isLoggedIn()) {
            $this->jsonResponse(['error' => 'Not logged in']);
        }
        $with = (int)$_GET['with'];
        $messages = $this->messageModel->getConversation(getCurrentUser(), $with);
        $this->jsonResponse($messages);
    }

    public function send() {
        if (!isLoggedIn()) {
            $this->jsonResponse(['error' => 'Not logged in']);
        }
        $to = (int)$_POST['to'];
        $message = sanitize($_POST['message']);
        $this->messageModel->sendMessage(getCurrentUser(), $to, $message);
        $this->jsonResponse(['success' => true]);
    }

    public function unread() {
        if (!isLoggedIn()) {
            $this->jsonResponse(['error' => 'Not logged in']);
        }
        $count = $this->messageModel->getUnreadCount(getCurrentUser());
        $this->jsonResponse(['count' => $count]);
    }
}
?>