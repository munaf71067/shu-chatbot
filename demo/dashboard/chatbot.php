<?php

class ChatbotHelper{
    protected $accessToken='fb645a8c-c3f0-4773-ad0c-0c76e895bf28' . ':' . 'cbfd3011-779e-42b6-a66d-1cf3badcd0bf';
    //f1a8f85f-3dc9-4d89-b71e-a9d6e9ee5a95
    //protected $accessToken='f1a8f85f-3dc9-4d89-b71e-a9d6e9ee5a95' . ':' . 'fbff5d3a-27d8-45f8-8192-9a166a03669f';
    
    //protected $accessToken='fbff5d3a-27d8-45f8-8192-9a166a03669f' . ':' . 'f1a8f85f-3dc9-4d89-b71e-a9d6e9ee5a95';
    
    public function send_message($data)
    {
        $url = 'https://apiv2.unificationengine.com/v2/message/send';
        $data_main = $data;
        $this->curl_to_data($data_main, $url);
       
    }
  
    public function wa_text_Array($message = '', $number = '', $name = 'name')
    {
        $size = strlen($message);
        $array = array(
            'message' =>
            array(
                'receivers' => 
                array(
                    0 =>
                    array(
                        'name' => 'name',
                        'address' => $number,
                        'Connector' => $number,
                        'type' => 'individual',
                    ),
                ),
                'parts' => 
                array(
                    0 =>
                    array(
                        'id' => '1',
                        'contentType' => 'text/plain',
                        'data' => $message,
                        'size' => $size,
                        'type' => 'body',
                        'sort' => 0,
                    ),
                ),
            ),
        );
        return $array;
    }

    public function validateDate($date, $format = 'd-m-Y')
    {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) === $date;
    }
    public function text_main($real_data)
    {
        $text = $real_data->text->body;
        $this->read_status($real_data->connectionname, $real_data->id);
        return $text;
    }
    public function image_main($real_data)
    {
        $connectionname = $real_data->connectionname;
        $image_id = $real_data->image->id;
        $image_type = $real_data->image->mime_type;
        $image_sha = $real_data->image->sha256;
        //retreive image from curl
        $image_data = '{"uri":"unified://' . $connectionname . '?messageId=' . $real_data->id . '&mediaId=' . $image_id . '"}';
        $result = $this->curl_to_data($image_data);
        $ret_img = json_decode($result);
        $base64_image = $ret_img->messages->$connectionname[0]->parts[0]->data;
        $ext = $this->mime2ext($image_type);
        $filename = $ret_img->messages->$connectionname[0]->parts[0]->name . "." . $ext;
        $this->base64_to_jpeg($base64_image, getcwd() . "/uploads/" . $filename . "");
        $this->read_status($real_data->connectionname, $real_data->id);
        $file['filename'] = $filename;
        $file['mime_type'] = $image_type;
        return $file;
    }
    public function document_main($real_data)
    {
        $connectionname = $real_data['connectionname'];
        $document_id = $real_data['main']->id;
        $document_type = $real_data['main']->mime_type;
        $document_sha = $real_data['main']->sha256;
        $document_filename = $real_data['main']->filename;
        //retreive image from curl
        $document_data = '{"uri":"unified://' . $connectionname . '?messageId=' . $real_data['id'] . '&mediaId=' . $document_id . '"}';
        $result = $this->curl_to_data($document_data);
        $ret_doc = json_decode($result);
        $base64_doc = $ret_doc->messages->$connectionname[0]->parts[0]->data;
        $ext = $this->mime2ext($document_type);
        $filename = $ret_doc->messages->$connectionname[0]->parts[0]->name . "." . $ext;
        $this->base64_to_jpeg($base64_doc, getcwd() . "/uploads/" . $filename . "");
        $this->read_status($real_data['connectionname'], $real_data['id']);
        $file['filename'] = $filename;
        $file['mime_type'] = $document_type;
        return $file;
    }
    public function video_main($real_data)
    {
        $connectionname = $real_data['connectionname'];
        $video_id = $real_data['main']->id;
        $video_type = $real_data['main']->mime_type;
        $video_sha = $real_data['main']->sha256;
        //retreive image from curl
        $video_data = '{"uri":"unified://' . $connectionname . '?messageId=' . $real_data['id'] . '&mediaId=' . $video_id . '"}';
        $result = $this->curl_to_data($video_data);
        $ret_video = json_decode($result);
        $base64_video = $ret_video->messages->$connectionname[0]->parts[0]->data;
        $ext = $this->mime2ext($video_type);
        $filename = $ret_video->messages->$connectionname[0]->parts[0]->name . "." . $ext;
        $this->base64_to_jpeg($base64_video, getcwd() . "/uploads/" . $filename . "");
        $this->read_status($real_data['connectionname'], $real_data['id']);
        $file['filename'] = $filename;
        $file['mime_type'] = $video_type;
        return $file;
    }
    public function audio_main($real_data)
    {
        $connectionname = $real_data['connectionname'];
        $video_id = $real_data['main']->id;
        $video_type = $real_data['main']->mime_type;
        $video_sha = $real_data['main']->sha256;
        //retreive image from curl
        $video_data = '{"uri":"unified://' . $connectionname . '?messageId=' . $real_data['id'] . '&mediaId=' . $video_id . '"}';
        $result = $this->curl_to_data($video_data);
        $ret_video = json_decode($result);
        $base64_video = $ret_video->messages->$connectionname[0]->parts[0]->data;
        $ext = $this->mime2ext($video_type);
        $filename = $ret_video->messages->$connectionname[0]->parts[0]->name . "." . $ext;
        $this->base64_to_jpeg($base64_video, getcwd() . "/uploads/" . $filename . "");
        $this->read_status($real_data['connectionname'], $real_data['id']);
        $file['filename'] = $filename;
        $file['mime_type'] = $video_type;
        return $file;
    }
    public function location_main($real_data)
    {
        $lat = $real_data['main']->latitude;
        $long = $real_data['main']->longitude;
    }
    public function read_status($connectionname, $message_id)
    {

        $msg_data = '{"message":[{"uri":"unified://' . $connectionname . '?messageId=' . $message_id . '","status":"read"}]}';
        $url = 'https://apiv2.unificationengine.com/v2/message/status';
        $this->curl_to_data($msg_data, $url);
    }
    public function base64_to_jpeg($base64_string, $output_file)
    {
        // open the output file for writing
        $ifp = fopen($output_file, 'wb');
        fwrite($ifp, base64_decode($base64_string));
        fclose($ifp);
        return $output_file;
    }
    public function curl_to_data($post_data, $url = 'https://apiv2.unificationengine.com/v2/message/retrieve')
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_USERPWD, $this->accessToken);

        $headers = array();
        $headers[] = 'Content-Type: application/x-www-form-urlencoded';
        $headers[] = 'Authorization: Basic ZmI2NDVhOGMtYzNmMC00NzczLWFkMGMtMGM3NmU4OTViZjI4OmNiZmQzMDExLTc3OWUtNDJiNi1hNjZkLTFjZjNiYWRjZDBiZg==';//. base64_encode($this->accessToken);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        
        //global
// $dbhost = 'localhost';
// $dbuser = 'kodevg_chatbotnew';
// $dbpass = 'B@?hs]{iP0g9';
// $dbname = 'kodevg_chatbotnew';
//global
$dbhost = 'localhost';
$dbuser = 'kodevg_ziahuddin_chat';
$dbpass = '!@#$prince123';
$dbname = 'kodevg_ziahuddin_chatbot';

$db = new Database($dbhost, $dbuser, $dbpass, $dbname);
$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

$db->query('INSERT INTO logs (message) VALUES (?)', $result.'--'.$url);

        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);
        return $result;
    }
    public function curl_set_connection($name, $url = 'https://apiv2.unificationengine.com/v2/connection/add')
    {
        // Generated by curl-to-PHP: http://incarnate.github.io/curl-to-php/
        
        $ch = curl_init();
curl_setopt_array($ch, array(
  CURLOPT_URL => 'https://apiv2.unificationengine.com/v2/connection/add',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>'{ "uri": "whatsappofficial://' . $name . '@whatsapp.com", "name": "' . $name . '"}',
  CURLOPT_HTTPHEADER => array(
    'accept: application/json',
    'Content-Type: application/json',
    'Authorization: Basic ZmI2NDVhOGMtYzNmMC00NzczLWFkMGMtMGM3NmU4OTViZjI4OmNiZmQzMDExLTc3OWUtNDJiNi1hNjZkLTFjZjNiYWRjZDBiZg=='
  ),
));
$result = curl_exec($ch);


        /*$ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, '{"uri":"whatsappcloud://' . $name . '@whatsapp.com", "name":"' . $name . '"}');
        curl_setopt($ch, CURLOPT_USERPWD, $this->accessToken);

        $headers = array();
        $headers[] = 'Content-Type: application/x-www-form-urlencoded';
        //$headers[] = 'Authorization: Basic ZjFhOGY4NWYtM2RjOS00ZDg5LWI3MWUtYTlkNmU5ZWU1YTk1OmZiZmY1ZDNhLTI3ZDgtNDVmOC04MTkyLTlhMTY2YTAzNjY5Zg==';//. base64_encode($this->accessToken);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);*/
        
            //global
// $dbhost = 'localhost';
// $dbuser = 'kodevg_chatbotnew';
// $dbpass = 'B@?hs]{iP0g9';
// $dbname = 'kodevg_chatbotnew';
//global
$dbhost = 'localhost';
$dbuser = 'kodevg_ziahuddin_chat';
$dbpass = '!@#$prince123';
$dbname = 'kodevg_ziahuddin_chatbot';

$db = new Database($dbhost, $dbuser, $dbpass, $dbname);
$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
 
$db->query('INSERT INTO logs (message) VALUES (?)', $result.'--'.$url.'---'.$name);

        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);
    }
    public function wa_attach_Array($message = '', $number = '', $name = 'name', $link = '', $mime = 'application/pdf', $filename = '', $type = 'image_link')
    {
        //$mobile_number='923162732897';
        $size = strlen($link);
        $size_text = strlen($message);
        $array = array(
            'message' =>
            array(
                'receivers' =>
                array(
                    0 =>
                    array(
                        'name' => 'name',
                        'address' => $number,
                        'Connector' => $number,
                        'type' => 'individual',
                    ),
                ),
                'parts' =>
                array(
                    0 =>
                    array(
                        'id' => '0',
                        'contentType' => $mime,
                        'size' => $size,
                        'type' => $type,
                        'name' => $filename,
                        'data' => $link,
                        'sort' => 1,
                    ),
                    1 =>
                    array(
                        'id' => '1',
                        'contentType' => 'text/plain',
                        'data' => $message,
                        'size' => $size_text,
                        'type' => 'body',
                        'sort' => 0,
                    ),
                ),
            ),
        );
        return $array;
    }
    public function mime2ext($mime)
    {
        $mime_map = [
            'video/3gpp2'                                                               => '3g2',
            'video/3gp'                                                                 => '3gp',
            'video/3gpp'                                                                => '3gp',
            'application/x-compressed'                                                  => '7zip',
            'audio/x-acc'                                                               => 'aac',
            'audio/ac3'                                                                 => 'ac3',
            'application/postscript'                                                    => 'ai',
            'audio/x-aiff'                                                              => 'aif',
            'audio/aiff'                                                                => 'aif',
            'audio/x-au'                                                                => 'au',
            'video/x-msvideo'                                                           => 'avi',
            'video/msvideo'                                                             => 'avi',
            'video/avi'                                                                 => 'avi',
            'application/x-troff-msvideo'                                               => 'avi',
            'application/macbinary'                                                     => 'bin',
            'application/mac-binary'                                                    => 'bin',
            'application/x-binary'                                                      => 'bin',
            'application/x-macbinary'                                                   => 'bin',
            'image/bmp'                                                                 => 'bmp',
            'image/x-bmp'                                                               => 'bmp',
            'image/x-bitmap'                                                            => 'bmp',
            'image/x-xbitmap'                                                           => 'bmp',
            'image/x-win-bitmap'                                                        => 'bmp',
            'image/x-windows-bmp'                                                       => 'bmp',
            'image/ms-bmp'                                                              => 'bmp',
            'image/x-ms-bmp'                                                            => 'bmp',
            'application/bmp'                                                           => 'bmp',
            'application/x-bmp'                                                         => 'bmp',
            'application/x-win-bitmap'                                                  => 'bmp',
            'application/cdr'                                                           => 'cdr',
            'application/coreldraw'                                                     => 'cdr',
            'application/x-cdr'                                                         => 'cdr',
            'application/x-coreldraw'                                                   => 'cdr',
            'image/cdr'                                                                 => 'cdr',
            'image/x-cdr'                                                               => 'cdr',
            'zz-application/zz-winassoc-cdr'                                            => 'cdr',
            'application/mac-compactpro'                                                => 'cpt',
            'application/pkix-crl'                                                      => 'crl',
            'application/pkcs-crl'                                                      => 'crl',
            'application/x-x509-ca-cert'                                                => 'crt',
            'application/pkix-cert'                                                     => 'crt',
            'text/css'                                                                  => 'css',
            'text/x-comma-separated-values'                                             => 'csv',
            'text/comma-separated-values'                                               => 'csv',
            'application/vnd.msexcel'                                                   => 'csv',
            'application/x-director'                                                    => 'dcr',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document'   => 'docx',
            'application/x-dvi'                                                         => 'dvi',
            'message/rfc822'                                                            => 'eml',
            'application/x-msdownload'                                                  => 'exe',
            'video/x-f4v'                                                               => 'f4v',
            'audio/x-flac'                                                              => 'flac',
            'video/x-flv'                                                               => 'flv',
            'image/gif'                                                                 => 'gif',
            'application/gpg-keys'                                                      => 'gpg',
            'application/x-gtar'                                                        => 'gtar',
            'application/x-gzip'                                                        => 'gzip',
            'application/mac-binhex40'                                                  => 'hqx',
            'application/mac-binhex'                                                    => 'hqx',
            'application/x-binhex40'                                                    => 'hqx',
            'application/x-mac-binhex40'                                                => 'hqx',
            'text/html'                                                                 => 'html',
            'image/x-icon'                                                              => 'ico',
            'image/x-ico'                                                               => 'ico',
            'image/vnd.microsoft.icon'                                                  => 'ico',
            'text/calendar'                                                             => 'ics',
            'application/java-archive'                                                  => 'jar',
            'application/x-java-application'                                            => 'jar',
            'application/x-jar'                                                         => 'jar',
            'image/jp2'                                                                 => 'jp2',
            'video/mj2'                                                                 => 'jp2',
            'image/jpx'                                                                 => 'jp2',
            'image/jpm'                                                                 => 'jp2',
            'image/jpeg'                                                                => 'jpeg',
            'image/pjpeg'                                                               => 'jpeg',
            'application/x-javascript'                                                  => 'js',
            'application/json'                                                          => 'json',
            'text/json'                                                                 => 'json',
            'application/vnd.google-earth.kml+xml'                                      => 'kml',
            'application/vnd.google-earth.kmz'                                          => 'kmz',
            'text/x-log'                                                                => 'log',
            'audio/x-m4a'                                                               => 'm4a',
            'audio/mp4'                                                                 => 'm4a',
            'application/vnd.mpegurl'                                                   => 'm4u',
            'audio/midi'                                                                => 'mid',
            'application/vnd.mif'                                                       => 'mif',
            'video/quicktime'                                                           => 'mov',
            'video/x-sgi-movie'                                                         => 'movie',
            'audio/mpeg'                                                                => 'mp3',
            'audio/mpg'                                                                 => 'mp3',
            'audio/mpeg3'                                                               => 'mp3',
            'audio/mp3'                                                                 => 'mp3',
            'video/mp4'                                                                 => 'mp4',
            'video/mpeg'                                                                => 'mpeg',
            'application/oda'                                                           => 'oda',
            'audio/ogg'                                                                 => 'ogg',
            'video/ogg'                                                                 => 'ogg',
            'application/ogg'                                                           => 'ogg',
            'font/otf'                                                                  => 'otf',
            'application/x-pkcs10'                                                      => 'p10',
            'application/pkcs10'                                                        => 'p10',
            'application/x-pkcs12'                                                      => 'p12',
            'application/x-pkcs7-signature'                                             => 'p7a',
            'application/pkcs7-mime'                                                    => 'p7c',
            'application/x-pkcs7-mime'                                                  => 'p7c',
            'application/x-pkcs7-certreqresp'                                           => 'p7r',
            'application/pkcs7-signature'                                               => 'p7s',
            'application/pdf'                                                           => 'pdf',
            'application/octet-stream'                                                  => 'pdf',
            'application/x-x509-user-cert'                                              => 'pem',
            'application/x-pem-file'                                                    => 'pem',
            'application/pgp'                                                           => 'pgp',
            'application/x-httpd-php'                                                   => 'php',
            'application/php'                                                           => 'php',
            'application/x-php'                                                         => 'php',
            'text/php'                                                                  => 'php',
            'text/x-php'                                                                => 'php',
            'application/x-httpd-php-source'                                            => 'php',
            'image/png'                                                                 => 'png',
            'image/x-png'                                                               => 'png',
            'application/powerpoint'                                                    => 'ppt',
            'application/vnd.ms-powerpoint'                                             => 'ppt',
            'application/vnd.ms-office'                                                 => 'ppt',
            'application/msword'                                                        => 'doc',
            'application/vnd.openxmlformats-officedocument.presentationml.presentation' => 'pptx',
            'application/x-photoshop'                                                   => 'psd',
            'image/vnd.adobe.photoshop'                                                 => 'psd',
            'audio/x-realaudio'                                                         => 'ra',
            'audio/x-pn-realaudio'                                                      => 'ram',
            'application/x-rar'                                                         => 'rar',
            'application/rar'                                                           => 'rar',
            'application/x-rar-compressed'                                              => 'rar',
            'audio/x-pn-realaudio-plugin'                                               => 'rpm',
            'application/x-pkcs7'                                                       => 'rsa',
            'text/rtf'                                                                  => 'rtf',
            'text/richtext'                                                             => 'rtx',
            'video/vnd.rn-realvideo'                                                    => 'rv',
            'application/x-stuffit'                                                     => 'sit',
            'application/smil'                                                          => 'smil',
            'text/srt'                                                                  => 'srt',
            'image/svg+xml'                                                             => 'svg',
            'application/x-shockwave-flash'                                             => 'swf',
            'application/x-tar'                                                         => 'tar',
            'application/x-gzip-compressed'                                             => 'tgz',
            'image/tiff'                                                                => 'tiff',
            'font/ttf'                                                                  => 'ttf',
            'text/plain'                                                                => 'txt',
            'text/x-vcard'                                                              => 'vcf',
            'application/videolan'                                                      => 'vlc',
            'text/vtt'                                                                  => 'vtt',
            'audio/x-wav'                                                               => 'wav',
            'audio/wave'                                                                => 'wav',
            'audio/wav'                                                                 => 'wav',
            'application/wbxml'                                                         => 'wbxml',
            'video/webm'                                                                => 'webm',
            'image/webp'                                                                => 'webp',
            'audio/x-ms-wma'                                                            => 'wma',
            'application/wmlc'                                                          => 'wmlc',
            'video/x-ms-wmv'                                                            => 'wmv',
            'video/x-ms-asf'                                                            => 'wmv',
            'font/woff'                                                                 => 'woff',
            'font/woff2'                                                                => 'woff2',
            'application/xhtml+xml'                                                     => 'xhtml',
            'application/excel'                                                         => 'xl',
            'application/msexcel'                                                       => 'xls',
            'application/x-msexcel'                                                     => 'xls',
            'application/x-ms-excel'                                                    => 'xls',
            'application/x-excel'                                                       => 'xls',
            'application/x-dos_ms_excel'                                                => 'xls',
            'application/xls'                                                           => 'xls',
            'application/x-xls'                                                         => 'xls',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'         => 'xlsx',
            'application/vnd.ms-excel'                                                  => 'xlsx',
            'application/xml'                                                           => 'xml',
            'text/xml'                                                                  => 'xml',
            'text/xsl'                                                                  => 'xsl',
            'application/xspf+xml'                                                      => 'xspf',
            'application/x-compress'                                                    => 'z',
            'application/x-zip'                                                         => 'zip',
            'application/zip'                                                           => 'zip',
            'application/x-zip-compressed'                                              => 'zip',
            'application/s-compressed'                                                  => 'zip',
            'multipart/x-zip'                                                           => 'zip',
            'text/x-scriptzsh'                                                          => 'zsh',
            'audio/ogg; codecs=opus'                                                     => 'ogg',
            'audio/aac' => 'acc',
        ];

        return isset($mime_map[$mime]) ? $mime_map[$mime] : false;
    }
}
?>