<?php


namespace App\Utils;
class Notifications {

/**
   * Notificación: SendNotification
   * Método final que realiza el envío de la notificación a partir de la generación de un mensaje y la selección
   * de tokens a los que se realizará el envío.
   * @param $tokens
   * @param $message
   * @param $type
   * @return mixed
   */
  public static function sendNotification($tokens, $message, $type){
      $url = "https://fcm.googleapis.com/fcm/send";
      $fields = array(
          'registration_ids' => $tokens,
          $type => $message,
          'priority' => 'high',
          'content_available' => true, );
      //Se configura la llave de Firebase.
      $headers = array(
          'Authorization:key = AIzaSyC0v170Q5osiLb9SSDmn0l0avVrrzrQHOE ',
          'Content-Type:application/json'
      );
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_POST, true);
      curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
      curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
      $result = curl_exec($ch);
      if($result === FALSE){
          die('Curl failed ' . curl_error($ch));
      }
      curl_close($ch);
      return $result;
  }

}
