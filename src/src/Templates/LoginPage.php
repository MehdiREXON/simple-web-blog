<?php
namespace App\Templates;

use App\Models\User;
use App\Classes\Auth;
class LoginPage extends Template
{
    private $errors = [];
    public function __construct()
    {
        parent::__construct();
        #Auth::logoutUser();
        if(Auth::isAuthenicated())
            redirect('panel.php',['action' => 'posts']);
        $this->title  = $this->setting->getTitle()  . ' - login to system';
        if($this->request->isPostMethod())       
        {
            $data = $this->validator->validate([
                'email'=>['required','email'],
                'password'=>['required','min:6'] 
            ]);
            if(!$data->hasError())
            {
                $userModel = new User();
                $user = $userModel->authenticationUser($this->request->email,$this->request->password);
                if($user)
                {
                    Auth::loginUser($user);
                    redirect('panel.php',['action'=>'posts']);
                }
                else
                {
                    $this->errors[] = 'Authentication failed';
                }
                    
            }
            else
            {
                $this->errors = $data->getErrors();
            }
        }
    }


    private function showErrors()
    {
        if(count($this->errors))
        {
            ?>
                <div class="errors">
                    <ul>
                        <?php foreach($this->errors as $error): ?>
                            <li><?= $error;count($this->errors) ?></li>
                        <?php endforeach; ?>
                    </ul>   
                </div>
            <?php
        }

            
        
    }

    public function renderPage()
    {
        ?>
            <!DOCTYPE html>
            <html lang="en">
            <?php $this->getLoginHead()?>
            <script>
                function togglePasswordVisibility() {
                var passwordInput = document.getElementById("password");
                var toggleButton = document.getElementById("toggle-password");
                
                if (passwordInput.type === "password") {
                    passwordInput.type = "text";
                    toggleButton.textContent = "Hide Password";
                } else {
                    passwordInput.type = "password";
                    toggleButton.textContent = "Show Password";
                }
                }
            </script>
            <body class="body-class">
                <div class="container">
                    <div class="login">
                        <div class="login-form">
                            <?php $this->showErrors()?>
                            <div class="login-logo">
                                <img src="<?= assets('logo.png')?>" alt="logo">
                            </div>
                            <form method='POST' action="<?= url('index.php',['action'=>'login'])?>">
                                <div class="form-control"> 
                                    <label for="email">Email</label>
                                    <input id="email" type="text" name="email" placeholder="enter your email">
                                </div>
                                <div class="form-control">

                                <label for="password">Password</label>
                                <input id="password" type="password" placeholder="enter your password"name="password">
                                <button type="button" id="toggle-password" onclick="togglePasswordVisibility()">Show Password</button>
                                </div>
                                <button class="btn" value="login" type="submit">login</button>
                            </form>
                        </div>
                        <div class="login-img">
                            <img src="<?= assets('image.png')?>" alt="login image">
                        </div>
                        <div class="clear-both"></div>
                    </div>
                </div>

            </body>
            </html>
        <?php
    }
    //the old one
/*
    
    <html>
        <?php $this->getAdminHead()?>
        <body>
            <main>
                <form method='POST' action="<?= url('index.php',['action'=>'login'])?>">
                    <div class='login'>
                        <h3>Login to system</h3>
                        <?php $this->showErrors()?>
                        <div>
                            <label for="email">Email:</label>
                            <input type="text" id="email" name="email">
                        </div>
                        <div>
                            <label for="password">Password:</label>
                            <input type="password" id="password" name="password">
                        </div>
                        <div>
                            <input type="submit" value="Login">
                        </div>
                    </div>
                </form>
            </main>
        </body>
    </html>
    <?php
    }*/
}