<?
    header('Content-Type: text/event-stream');
    header('Cache-Control: no-cache');

    include_once('./engine/classes/simpleSHM.class.php');

    session_start();
    $uName = $_SESSION['username']; 
    session_write_close();

    $SHM = new Block('99999');
    $arrID = json_decode($SHM->read(), true);

    if(empty($arrID[$uName]))
    {
        sendEvent('1');
    }

    $SHM = new Block($arrID[$uName]);
    $arrSTAT = json_decode($SHM->read(), true);
    sendEvent($arrSTAT[$uName]);
    ob_flush();
    flush();

    function sendEvent($status) 
    {
        echo "retry: 20000\n\n";
        echo "data: {$status}\n\n";
    }
?>