<?php
require_once 'BaseController.php';
require_once 'app/models/ProfileModel.php';

class ProfileController extends BaseController {
    private $profileModel;

    public function __construct() {
        parent::__construct();
        $this->profileModel = new ProfileModel();
    }

    public function index() {
        if (!isLoggedIn()) {
            $this->redirect('index.php?page=auth');
        }
        $profile = $this->profileModel->findByUserId(getCurrentUser());
        $this->render('profile/index', ['profile' => $profile]);
    }

    public function edit() {
        if (!isLoggedIn()) {
            $this->redirect('index.php?page=auth');
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => sanitize($_POST['name']),
                'age' => (int)$_POST['age'],
                'gender' => $_POST['gender'],
                'department' => sanitize($_POST['department']),
                'interests' => explode(',', sanitize($_POST['interests'])),
                'visibility' => $_POST['visibility']
            ];
            // Handle image upload
            if (isset($_FILES['profile_image'])) {
                $image = $_FILES['profile_image'];
                if ($image['error'] == 0) {
                    $ext = pathinfo($image['name'], PATHINFO_EXTENSION);
                    $filename = uniqid() . '.' . $ext;
                    move_uploaded_file($image['tmp_name'], 'public/images/' . $filename);
                    $data['profile_image'] = $filename;
                }
            }
            $this->profileModel->updateProfile(getCurrentUser(), $data);
            $this->profileModel->calculateCompletion(getCurrentUser());
            $this->redirect('index.php?page=profile');
        } else {
            $profile = $this->profileModel->findByUserId(getCurrentUser());
            $this->render('profile/edit', ['profile' => $profile]);
        }
    }
}
?>