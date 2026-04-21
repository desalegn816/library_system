<?php
require_once 'BaseController.php';
require_once 'app/models/MatchModel.php';

class MatchController extends BaseController {
    private $matchModel;

    public function __construct() {
        parent::__construct();
        $this->matchModel = new MatchModel();
    }

    public function index() {
        if (!isLoggedIn()) {
            $this->redirect('index.php?page=auth');
        }
        $matches = $this->matchModel->getMatches(getCurrentUser());
        $this->render('match/index', ['matches' => $matches]);
    }

    public function swipe() {
        if (!isLoggedIn()) {
            $this->redirect('index.php?page=auth');
        }
        $potentials = $this->matchModel->getPotentialMatches(getCurrentUser());
        $this->render('match/swipe', ['potentials' => $potentials]);
    }

    public function like() {
        if (!isLoggedIn()) {
            $this->jsonResponse(['error' => 'Not logged in']);
        }
        $to = (int)$_POST['to_user'];
        $type = $_POST['type']; // like or dislike
        $this->matchModel->addLike(getCurrentUser(), $to, $type);
        $this->jsonResponse(['success' => true]);
    }
}
?>