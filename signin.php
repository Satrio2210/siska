<!doctype html>
<?php include "conf/config.php";?>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="Sistem Informasi Klinik Pratama">
<title>Sistem Informasi Klinik Pratama</title>
<link rel="shortcut icon" href="img/icon.png">
<style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: #f5f5f5;
            background-image: url(http://192.168.10.150/wallpaper/wall-yemima8a.jpg);
            background-size: cover;
        }

        .login-container {
            background-color: #fff;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
            width: 400px;
            max-width: 100%;
            text-align: center;
        }

        .login-header {
            background-color: #46da00;
            padding: 20px;
            color: #fff;
            font-size: 24px;
            font-weight: bold;
        }

        .login-form {
            padding: 20px;
            box-sizing: border-box;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            text-align: left;
            font-size: 16px;
            margin-bottom: 8px;
            color: #555;
        }

        .form-group input {
            width: 100%;
            padding: 10px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }

        .form-group button {
            background-color: #2ecc71;
            color: #fff;
            padding: 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        .form-group button:hover {
            background-color: #27ae60;
        }

        .form-group .register-link {
            margin-top: 10px;
            font-size: 14px;
            color: #3498db;
            text-decoration: none;
            display: inline-block;
        }

        .form-group .label-msg {
            margin-top: 10px;
            font-size: 14px;
            color: #fc0303;
            text-decoration: none;
            display: inline-block;
        }

        .form-group .register-link:hover {
            color: #2574a9;
        }
    </style>
<script src="js/signx.js"></script>
</head>
<!-- test -->
<div class="login-container">
        <div class="login-header">Login</div>
        <form class="login-form" method="post" name="formlogin" action="signxx.php">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="userid" name="userid" maxlength="5" required
                  onkeyup="
                    var start = this.selectionStart;
                    var end = this.selectionEnd;
                    this.setSelectionRange(start, end);
                    "
                  onkeydown="javascript:if (event.keyCode == 13) 
                    { 
                      document.getElementById('labelmessage').style.visibility = 'hidden';
                      document.formlogin.pass.focus();
                    }"/>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="pass" name="pass" required 
                  onkeydown="javascript:if (event.keyCode == 13) 
                    { 
                      periksaid(document.getElementById('userid').value,document.getElementById('pass').value);
                    }"/>
            </div>
            <div class="form-group">
                <input type="button" 
                    onclick="javascript: periksaid(document.getElementById('userid').value,document.getElementById('pass').value)"
                    value="Login">
            </div>
            
            <div id="labelmessage" class="form-group" style="visibility: hidden;">
                <a class="label-msg">Username atau Password Salah!!</a>
            </div>
            
            <div class="form-group">
                <a href="#" class="register-link">Don't have an account? Register here.</a>
            </div>
        </form>
    </div>