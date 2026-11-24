<?php
unset($_SESSION['user_login']);
setFlash('success', 'Kamu berhasil logout.');
redirect('login');