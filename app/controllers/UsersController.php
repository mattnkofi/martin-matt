<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

/**
 * Controller: UsersController
 * 
 * Automatically generated via CLI.
 */

    class UsersController extends Controller {
        public function __construct()
        {
            parent::__construct();
        }
        public function index()
{
    $this->call->model('Usersmodel');

    // Check kung may naka-login
    if (!isset($_SESSION['user'])) {
        redirect('/auth/login');
        exit;
    }

    // Kunin info ng naka-login na user
    $logged_in_user = $_SESSION['user']; 
    $data['logged_in_user'] = $logged_in_user;

    // Current page
         $page = 1;
        if(isset($_GET['page']) && ! empty($_GET['page'])) {
            $page = $this->io->get('page');
        }

        $q = '';
        if(isset($_GET['q']) && ! empty($_GET['q'])) {
            $q = trim($this->io->get('q'));
        }

        $records_per_page = 5;

    // Get paginated users
    $users = $this->Usersmodel->page($q, $records_per_page, $page);

    $data['users'] = $users['records'];   // ✅ only rows
    $total_rows = $users['total_rows'];

    // Pagination setup
    $this->pagination->set_options([
        'first_link'     => '⏮ First',
        'last_link'      => 'Last ⏭',
        'next_link'      => 'Next →',
        'prev_link'      => '← Prev',
        'page_delimiter' => '&page='
    ]);
    $this->pagination->set_theme('custom');
    $this->pagination->initialize($total_rows, $records_per_page, $page, 'users?q='.$q);
    $data['page'] = $this->pagination->paginate();

    // ✅ Pass only cleaned data to view
    $this->call->view('users/index', $data);
}


public function create()
{
    if ($this->io->method() === 'post') {
        $username         = trim($this->io->post('username'));
        $email            = trim($this->io->post('email'));
        $password         = $this->io->post('password');
        $confirm_password = $this->io->post('confirm_password');
        $role             = $this->io->post('role') ?? 'user'; // default role

        // ✅ Check confirm password
        if ($password !== $confirm_password) {
            $this->call->view('users/create', [
                'error'    => 'Passwords do not match!',
                'username' => $username,
                'email'    => $email
            ]);
            return;
        }

        // ✅ Check if username already exists
        $existing_user = $this->Usersmodel->get_user_by_username($username);
        if (!empty($existing_user)) {
            $this->call->view('users/create', [
                'error'    => 'Username already exists. Please choose another.',
                'username' => $username,
                'email'    => $email
            ]);
            return;
        }

        // ✅ Insert new user
        $data = [
            'username'   => $username,
            'email'      => $email,
            'password'   => password_hash($password, PASSWORD_BCRYPT),
            'role'       => $role,
            'created_at' => date('Y-m-d H:i:s')
        ];

        if ($this->Usersmodel->insert($data)) {
            redirect('/users'); // go back to users list
        } else {
            $this->call->view('users/create', [
                'error'    => 'Failed to create user. Please try again.',
                'username' => $username,
                'email'    => $email
            ]);
        }
    } else {
        $this->call->view('users/create');
    }
}




public function update($id)
{
    $this->call->model('Usersmodel');

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    $logged_in_user = $_SESSION['user'] ?? null;

    if (!$logged_in_user) {
        redirect('/auth/login');
        exit;
    }

    // If not admin, force $id to logged-in user's id
    if ($logged_in_user['role'] !== 'admin') {
        $id = $logged_in_user['id'];
    }

    $user = $this->Usersmodel->get_user_by_id($id);
    if (!$user) {
        echo "User not found.";
        return;
    }

    if ($this->io->method() === 'post') {
        $username = trim($this->io->post('username'));
        $email = trim($this->io->post('email'));
        $password = trim($this->io->post('password'));

        $data = [
            'username' => $username,
            'email' => $email
        ];

        // Handle password update if filled
        if (!empty($password)) {
            $data['password'] = password_hash($password, PASSWORD_BCRYPT);
        }

        // Admins can also update role
        if ($logged_in_user['role'] === 'admin') {
            $role = $this->io->post('role');
            $data['role'] = $role;
        }

        // Prevent duplicate username/email
        $existing_user = $this->Usersmodel->get_user_by_username($username);
        if ($existing_user && $existing_user['id'] != $id) {
            $error = "Username already taken!";
            $this->call->view('users/update', ['user'=>$user,'logged_in_user'=>$logged_in_user,'error'=>$error]);
            return;
        }

        if ($this->Usersmodel->update($id, $data)) {
            // Update session if user updated their own username
            if ($id == $logged_in_user['id']) {
                $_SESSION['user']['username'] = $username;
            }
            redirect('/users'); // or dashboard
        } else {
            $error = "Failed to update user.";
            $this->call->view('users/update', ['user'=>$user,'logged_in_user'=>$logged_in_user,'error'=>$error]);
        }

    } else {
        $this->call->view('users/update', ['user'=>$user,'logged_in_user'=>$logged_in_user]);
    }
}




    public function delete($id) {
    $this->call->model('Usersmodel');

    // Get logged-in user
    $logged_in_user = $_SESSION['user'] ?? null;

    if ($this->Usersmodel->delete($id)) {

        // Check if the deleted user is the same as the logged-in user
        if ($logged_in_user && $logged_in_user['id'] == $id) {
            // Destroy session and redirect to login
            session_destroy();
            redirect('auth/login');
        } else {
            // Redirect to users list for other deletions
            redirect('/users');
        }

    } else {
        echo 'Failed to delete user.';
    }
}


public function register()
{
    $this->call->model('Usersmodel'); // load model

    if ($this->io->method() == 'post') {
        $username          = trim($this->io->post('username'));
        $email             = trim($this->io->post('email'));
        $password          = $this->io->post('password');
        $confirm_password  = $this->io->post('confirm_password');
        $role              = $this->io->post('role') ?? 'user'; // default user if none

        // ✅ Check if passwords match
        if ($password !== $confirm_password) {
            $error = "Passwords do not match!";
            $this->call->view('/auth/register', [
                'error'    => $error,
                'username' => $username,
                'email'    => $email
            ]);
            return;
        }

        if ($this->Usersmodel->get_user_by_username($username)) {
            $error = "Username already taken!";
            $this->call->view('/auth/register', [
                'error'    => $error,
                'username' => $username,
                'email'    => $email
            ]);
            return;
        }

        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        $data = [
            'username'   => $username,
            'email'      => $email,
            'password'   => $hashed_password,
            'role'       => $role,
            'created_at' => date('Y-m-d H:i:s')
        ];

        if ($this->Usersmodel->insert($data)) {
            // success → go to login
            redirect('/auth/login');
        } else {
            $error = "Failed to register user.";
            $this->call->view('/auth/register', [
                'error'    => $error,
                'username' => $username,
                'email'    => $email
            ]);
        }
    } else {
        $this->call->view('/auth/register');
    }
}




        public function login()
        {
            $this->call->library('auth');

            $error = null; // prepare error variable

            if ($this->io->method() == 'post') {
                $username = $this->io->post('username');
                $password = $this->io->post('password');

                $this->call->model('Usersmodel');
                $user = $this->Usersmodel->get_user_by_username($username);

                if ($user) {
                    if ($this->auth->login($username, $password)) {
                        // Set session
                        $_SESSION['user'] = [
                            'id'       => $user['id'],
                            'username' => $user['username'],
                            'role'     => $user['role']
                        ];

                        if ($user['role'] == 'admin') {
                            redirect('/users');
                        } else {
                            redirect('/users');
                        }
                    } else {
                        $error = "Incorrect password!";
                    }
                } else {
                    $error = "Username not found!";
                }
            }

            // Pass error to view
            $this->call->view('auth/login', ['error' => $error]);
        }



    public function dashboard()
    {
        $this->call->model('Usersmodel');
        $data['user'] = $this->Usersmodel->get_all_users(); // fetch all users

        $this->call->model('Usersmodel');

        $page = 1;
        if(isset($_GET['page']) && ! empty($_GET['page'])) {
            $page = $this->io->get('page');
        }

        $q = '';
        if(isset($_GET['q']) && ! empty($_GET['q'])) {
            $q = trim($this->io->get('q'));
        }

        $records_per_page = 10;

        $user = $this->Usersmodel->page($q, $records_per_page, $page);
        $data['user'] = $user['records'];
        $total_rows = $user['total_rows'];

        $this->pagination->set_options([
            'first_link'     => '<span class="px-3 py-1 bg-emerald-600 text-green rounded hover:bg-emerald-700">⏮ First</span>',
            'last_link'      => '<span class="px-3 py-1 bg-emerald-600 text-green rounded hover:bg-emerald-700">Last ⏭</span>',
            'next_link'      => '<span class="px-3 py-1 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">Next →</span>',
            'prev_link'      => '<span class="px-3 py-1 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">← Prev</span>',
            'cur_tag_open'   => '<span class="px-3 py-1 bg-emerald-600 text-white rounded">',
            'cur_tag_close'  => '</span>',
            'num_tag_open'   => '<span>',
            'num_tag_close'  => '</span>',
            'page_delimiter' => '&page='
        ]);

        $this->pagination->initialize($total_rows, $records_per_page, $page, 'users?q='.$q);
        $data['page'] = $this->pagination->paginate();

        $this->call->view('users/dashboard', $data);
    }


    public function logout()
    {
        $this->call->library('auth');
        $this->auth->logout();
        redirect('auth/login');
    }

}
