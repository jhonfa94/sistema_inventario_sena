<?php


class HelperController
{

    /**
     * LIMIPIA LA CACHE DEL FORMULARIO CUANDO SE ENVIA POST
     */
    public static function clearDataFormJs(){
        echo "
            <script>
                if(window.history.replaceState){
                    window.history.replaceState(null, null, window.location.href);
                }
            </script>
        ";
    }

    /**
     * LIMIPIA LA CACHE DEL FORMULARIO CUANDO SE ENVIA POST
     */
    public static function reloadPage($time = 3000){
        echo "
            <script>
                setTimeout(() => {
                    window.location.reload();
                },$time)
            </script>
        ";
    }



}
