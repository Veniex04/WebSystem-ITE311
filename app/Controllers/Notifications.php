namespace App\Controllers;
use App\Models\NotificationModel;

class Notifications extends BaseController
{
    protected $notificationModel;

    public function __construct()
    {
        $this->notificationModel = new NotificationModel();
    }

    public function get()
    {
        $userId = session()->get('user_id');
        $notifications = $this->notificationModel->getNotificationsForUser($userId);
        $unreadCount = $this->notificationModel->getUnreadCount($userId);

        return $this->response->setJSON([
            'count' => $unreadCount,
            'notifications' => $notifications
        ]);
    }

    public function mark_as_read($id)
    {
        $this->notificationModel->markAsRead($id);
        return $this->response->setJSON(['success' => true]);
    }
}
