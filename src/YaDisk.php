<?
class YaDisk {

    private $token = 'xxxxx';
    private $file;
   
    public function __construct($file) {
        $this->file = $file;
    }

    public function authorize() {
        // Идентификатор приложения
        $client_id = 'yyyyyy'; 
        // Пароль приложения
        $client_secret = 'zzzzzzz';

        // Если скрипт был вызван с указанием параметра "code" в URL,
        // то выполняется запрос на получение токена
        if (isset($_GET['code']))
        {
            // Формирование параметров (тела) POST-запроса с указанием кода подтверждения
            $query = array(
            'grant_type' => 'authorization_code',
            'code' => $_GET['code'],
            'client_id' => $client_id,
            'client_secret' => $client_secret
            );
            $query = http_build_query($query);

            // Формирование заголовков POST-запроса
            $header = "Content-type: application/x-www-form-urlencoded";

            // Выполнение POST-запроса и вывод результата
            $opts = array('http' =>
            array(
            'method'  => 'POST',
            'header'  => $header,
            'content' => $query
            ) 
            );
            $context = stream_context_create($opts);
            $result = file_get_contents('https://oauth.yandex.ru/token', false, $context);
            $result = json_decode($result);

            // Токен необходимо сохранить для использования в запросах к API Директа
            echo $result->access_token;
        }
    }


    public function uploadToYaDisk($folder) {
        // Папка на Яндекс Диске (уже должна быть создана).
        $path = $folder;
        

       
        // $this->file = __DIR__ . '/plan.png';
        print_r($this->file);
        // Запрашиваем URL для загрузки.
        $ch = curl_init('https://cloud-api.yandex.net/v1/disk/resources/upload?path=' . urlencode($path . basename($this->file)));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: OAuth ' . $this->token));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HEADER, false);
        $res = curl_exec($ch);
        curl_close($ch);
        
        $res = json_decode($res, true);
        print_r($res);
        if (empty($res['error'])) {
            // Если ошибки нет, то отправляем файл на полученный URL.
            $fp = fopen($this->file, 'r'); 
        
            $ch = curl_init($res['href']);
            curl_setopt($ch, CURLOPT_PUT, true);
            curl_setopt($ch, CURLOPT_UPLOAD, true);
            curl_setopt($ch, CURLOPT_INFILESIZE, filesize($this->file));
            curl_setopt($ch, CURLOPT_INFILE, $fp);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_HEADER, false);
            curl_exec($ch);
            $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
        
            if ($http_code == 201) {
                echo 'Файл успешно загружен.';
            }
        } 
    }
    
    public function getAuthLink() {
     
        session_start();

         $clientId     = 'xxx';
         $clientSecret = 'xxxx';
         $redirectUri  = 'http://xxxxx/_dev/xxxx.php'; // callback url

         // Формируем ссылку для авторизации
         $params = array(
             'client_id'     => $clientId,
             'redirect_uri'  => $redirectUri,
             'response_type' => 'code',
             'scope'         => 'cloud_api:disk.app_folder cloud_api:disk.read cloud_api:disk.write cloud_api:disk.info',
         );

         $requestPath = "https://oauth.yandex.ru/authorize?" . http_build_query( $params ) ;
         //echo  $requestPath;
         $response = file_get_contents($requestPath);
         return $response;
    }
}
