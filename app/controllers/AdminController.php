<?php
require_once 'BaseController.php';
require_once 'app/models/UserModel.php';
require_once 'app/models/ReportModel.php';
require_once 'app/models/AdminLogModel.php';

class AdminController extends BaseController {
    private $userModel;
    private $reportModel;
    private $logModel;

    public function __construct() {
        parent::__construct();
        $this->userModel = new UserModel();
        $this->reportModel = new ReportModel();
        $this->logModel = new AdminLogModel();
    }

    public function index() {
        if (!isLoggedIn() || $_SESSION['role'] !== 'admin') {
            $this->redirect('index.php?page=auth');
        }
        $users = $this->userModel->findAll();
        $reports = $this->reportModel->getPendingReports();
        $this->render('admin/dashboard', ['users' => $users, 'reports' => $reports]);
    }

    public function ban() {
        if (!isLoggedIn() || $_SESSION['role'] !== 'admin') {
            $this->jsonResponse(['error' => 'Unauthorized']);
        }
        $userId = (int)$_POST['user_id'];
        // Simple ban: delete user
        $this->userModel->delete($userId);
        $this->logModel->logAction(getCurrentUser(), 'ban_user', "Banned user $userId");
        $this->jsonResponse(['success' => true]);
    }

    public function resolveReport() {
        if (!isLoggedIn() || $_SESSION['role'] !== 'admin') {
            $this->jsonResponse(['error' => 'Unauthorized']);
        }
        $reportId = (int)$_POST['report_id'];
        $stmt = $this->pdo->prepare("UPDATE reports SET status = 'resolved' WHERE id = ?");
        $stmt->execute([$reportId]);
        $this->logModel->logAction(getCurrentUser(), 'resolve_report', "Resolved report $reportId");
        $this->jsonResponse(['success' => true]);
    }
}
?>