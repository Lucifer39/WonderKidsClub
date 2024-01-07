<?php
function getSessionData ($session_name = 'PHPSESSID', $session_save_handler = 'files') {
    $session_data = array();
    # did we get told what the old session id was? we can't continue it without that info
    if (array_key_exists($session_name, $_COOKIE)) {
        # save current session id
        $session_id = $_COOKIE[$session_name];
        $old_session_id = session_id();
       
        # write and close current session
        session_write_close();
       
        # grab old save handler, and switch to files
        $old_session_save_handler = ini_get('session.save_handler');
        ini_set('session.save_handler', $session_save_handler);
       
        # now we can switch the session over, capturing the old session name
        $old_session_name = session_name($session_name);
        session_id($session_id);
        session_start();
        //'same_site' => "lax"
       
        # get the desired session data
        $session_data = $_SESSION;
       
        # close this session, switch back to the original handler, then restart the old session
        session_write_close();
        ini_set('session.save_handler', $old_session_save_handler);
        session_name($old_session_name);
        session_id($old_session_id);
        session_start();
    }
   
    # now return the data we just retrieved
    return $session_data;
}
?>