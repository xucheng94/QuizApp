<?php

require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../core/Auth.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Category.php';
require_once __DIR__ . '/../models/Subject.php';

class AuthController extends Controller
{
    /* ===============================
       SHOW LOGIN PAGE (GET)
       =============================== */
    public function showLoginPage()
    {

        
        $this->view('login', [
            'pageTitle' => 'Log In',
            'pageCSS'   => '/quiz_app/assets/css/login.css',
            'pageJS'    => '/quiz_app/assets/js/login.js'
        ]);
    }


    /* ===============================
       HANDLE LOGIN (POST)
       =============================== */
    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('login');
        }

        $email    = trim($_POST['email'] ?? '');
        $password = trim($_POST['password'] ?? '');

        if (empty($email) || empty($password)) {
            $_SESSION['error'] = "Please enter both email and password.";
            $this->redirect('login');
        }

        $userModel = $this->model('User');
        $user      = $userModel->findByEmail($email);

        $categoryModel = new Category();

        if (!$user || !password_verify($password, $user['password_hash'])) {
            $_SESSION['error'] = "Invalid login credentials.";
            $this->redirect('login');
        }

        // LOGIN SUCCESS
        $_SESSION['user_id']    = $user['id'];
        $_SESSION['username']   = $user['username'];
        $_SESSION['full_name']  = $user['first_name'] . ' ' . $user['last_name'];
        $_SESSION['is_admin']   = (int) $user['is_admin'];

        // Redirect based on privilege
        if ($user['is_admin'] == 1) {
            $this->redirect('manage');  // teacher/admin panel
        } else {
            $this->redirect('home'); // student dashboard
        }
    }


    /* ===============================
       SHOW REGISTER PAGE (GET)
       =============================== */
    public function showRegisterPage()
    {
        $this->view('register', [
            'pageTitle' => 'Sign Up',
            'pageCSS'   => '/quiz_app/assets/css/register.css',
            'pageJS'    => '/quiz_app/assets/js/register.js'
        ]);
    }


    /* ===============================
       HANDLE REGISTER (POST)
       =============================== */
    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('register');
        }

        $firstName = trim($_POST['first_name'] ?? '');
        $lastName  = trim($_POST['last_name'] ?? '');
        $username  = trim($_POST['username'] ?? '');
        $email     = trim($_POST['email'] ?? '');
        $password  = trim($_POST['password'] ?? '');

        // Validation
        if (
            empty($firstName) ||
            empty($lastName) ||
            empty($username) ||
            empty($email) ||
            empty($password)
        ) {
            $_SESSION['error'] = "All fields are required.";
            $this->redirect('register');
        }

        // Load model
        $userModel = $this->model('User');

        // Prevent duplicates
        if ($userModel->findByEmail($email)) {
            $_SESSION['error'] = "Email already exists.";
            $this->redirect('register');
        }

        if ($userModel->findByUsername($username)) {
            $_SESSION['error'] = "Username already taken.";
            $this->redirect('register');
        }

        // Hash password
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        // Create student (is_admin = 0)
        $userModel->createUser([
            'email'         => $email,
            'first_name'    => $firstName,
            'last_name'     => $lastName,
            'username'      => $username,
            'password_hash' => $passwordHash,
            'is_admin'      => 0
        ]);

        $_SESSION['success'] = "Registration successful! Please log in.";
        $this->redirect('login');
    }


    /* ===============================
       LOGOUT
       =============================== */
    public function logout()
    {
        session_destroy();
        $this->redirect('home');
    }
}