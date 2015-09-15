<?
        header('Content-Type: text/event-stream');
        header('Cache-Control: no-cache');

        include_once('./engine/classes/simpleSHM.class.php');

        session_start();
        $uName = $_SESSION['username']; 
        session_write_close();

        $SHM = new Block('99999');
        $arrID = json_decode($SHM->read());

        $SHM = new Block($arrID[$uName]);
        $arrSTAT = json_decode($SHM->read());
        sendEvent($arrSTAT[$uName]);
        ob_flush();
        flush();
/*

        $SHM = new Block('777');
        $obj = $SHM->read();
        sendEvent($obj);

        ob_flush();
        flush();
*/


/*
        $SHM = new Block('777');
        $obj = $SHM->read();
        sendEvent($obj);

*/

    function sendEvent($status) 
    {
        echo "retry: 20000\n\n";
        echo "data: {$status}\n\n";
    }




/*
$shm_id = shmop_open($shm_key, "a", 0644, 100);
$shm_id = shmop_open($shm_key, "a", 0, 0);
shmop_size($shm_id);
shmop_write($shm_id, $my_string, 0);
shmop_read($shm_id, 0, 50);
shmop_delete($shm_id);
shmop_close($shm_id);
*/


?>