<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php
    class Email
    {
        private $emisor;
        private $receptor;
        private $asunto;
        private $fecha;
        private static $importantes;
        public function __construct($emisor, $receptor, $asunto, $fecha)
        {
            $this->emisor = $emisor;
            $this->receptor = $receptor;
            $this->asunto = $asunto;
            $this->fecha = $fecha;
            if (strtolower($this->emisor) == strtolower($this->receptor)) {
                $this->receptor .= "_bis";
            }
            if (str_starts_with(strtoupper("IMPORTANTE"), $this->asunto)) {

                Email::$importantes++;
            }

        }
        public function getEmisor()
        {
            return $this->emisor;
        }
        public function getReceptor()
        {
            return $this->receptor;
        }
        public function getAsunto()
        {
            return $this->asunto;
        }
        public function getFecha()
        {
            return $this->fecha;
        }
        public function destacarAsunto()
        {
            if (!str_starts_with(trim(strtoupper($this->asunto)), trim(strtoupper("importante")))) {
                $this->asunto = "IMPORTANTE " . $this->asunto;
            }

        }
        public function comprobarImportante()
        {
            if (str_starts_with(trim(strtoupper($this->asunto)), trim(strtoupper("importante")))) {
                return true;
            } else {
                return false;
            }
        }
        public function retrasarEnvio()
        {

            $this->fecha = date("d-m-Y", strtotime($this->fecha . " +1 day"));

        }
        public static function getImportantes()
        {
            return Email::$importantes;
        }



    }
    ?>
</body>

</html>