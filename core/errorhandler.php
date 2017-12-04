<?php
function exceptionHandler($exception) {
    render($exception);
}

function errorHandler() {

    $error = error_get_last();

    if( $error !== NULL) {

        render(new Exception($error['message']));

    }
}

function render($exception){
    include("headers.php");
    echo "<div class='exception-page'>";

    echo "<div class='exception-header'>";
    echo '<h1><span class="exception-type">'.get_class($exception).'</span><span class="exception-message"> - '.$exception->getFile()."</span></h1>";
    echo '<span class="exception-body">'.$exception->getMessage().'</span>';
    echo "</div>";

    echo "<div class='exception-body'>";
    $i = 1;
    foreach($exception->getTrace() as $trace){
        $lines = file($trace['file']);

        echo "<div class='exception-block'>";
            echo "<div class='exception-stack'>";
            echo "<span class='exception-file-name'>#".$i." in ".$trace['file']."</span><span class='exception-line'>at line ".$trace['line']."</span>";
            echo "</div>";
            echo "<div class='exception-file-line'>";
            echo $lines[$trace['line'] - 1];
            echo "</div>";
        echo "</div>";

        ++$i;
    }
    echo "</div>";

    echo "</div>";
}

set_exception_handler('exceptionHandler');
register_shutdown_function('errorHandler');
ini_set('display_errors', false);