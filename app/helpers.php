<?php

if (!function_exists("user_role")) {
    function user_role()
    {
        $user = session("user", null);
        if ($user) {
            return $user['role'];
        } else {
            return null;
        }
    }
}

function userInfo()
{
    return session('user', null);
}

function userIsAdmin()
{
    return user_role() == 'admin';
}

function userIsSuperAdmin()
{
    return user_role() == 'superadmin';
}
