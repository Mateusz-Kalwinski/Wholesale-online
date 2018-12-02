<?php
session_name('admin');
session_save_path(realpath(dirname($_SERVER['DOCUMENT_ROOT']) . '/../sessions'));
ini_set('session.gc_probability', 1);
ini_set('session.gc_divisor', 100);
ini_set('session.gc_maxlifetime', 259200);
session_set_cookie_params(259200);
session_start();
session_destroy();