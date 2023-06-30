<?php
require "classes/contact.php";
require "classes/deal.php";

//Создание объекта контакта и сделки
$contact = new Contact($_REQUEST['name'],$_REQUEST['email'],$_REQUEST['phone']);
$deal = new Deal($contact,  (int)$_REQUEST['price']);


// Параметры авторизации OAuth 2.0
$client_id = ''; //ID интеграции
$client_secret = ''; //Секретный ключ
$redirect_uri = ''; //URL перенаправления
$authorization_code = ''; //Код авторизации
$subDomain = ''; //Домен вашего аккаунта

// Авторизация OAuth 2.0
$auth_url = 'https://'.$subDomain.'.amocrm.ru/oauth2/access_token';
$post_data = [
    'client_id' => $client_id,
    'client_secret' => $client_secret,
    'grant_type' => 'authorization_code',
    'code' => $authorization_code,
    'redirect_uri' => $redirect_uri,
];

$curl = curl_init($auth_url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);
$response = curl_exec($curl);
curl_close($curl);

$access_token = json_decode($response, true)['access_token'];


// Создание контакта
$contact_url = 'https://'.$subDomain.'.amocrm.ru/api/v4/contacts';
$post_data = [
    'post_data' => [
        'name' => $contact->getName(),
        'custom_fields_values' => [
            [
                'field_id' => 913553, // Идентификатор поля "Email"
                'values' => [
                    [
                        'value' => $contact->getEmail()
                 
                    ],
                ],
            ],
            [
                'field_id' => 913555, // Идентификатор поля "Телефон"
                'values' => [
                    [
                        'value' => $contact->getPhone()
                
                    ],
                ],
            ],
          
        ],
    ],
    
];

$curl = curl_init($contact_url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($post_data));
curl_setopt($curl, CURLOPT_HTTPHEADER, [
    'Authorization: Bearer ' . $access_token,
    'Content-Type: application/json',
]);

$response = curl_exec($curl);
curl_close($curl);

if ($response) {
    $response_data = json_decode($response, true);
    $contact_id = $response_data['_embedded']['contacts'][0]['id'];
    $contact_link = $response_data['_embedded']['contacts'][0]['_links']['self']['href'];
} else {
    echo 'Ошибка при создании контакта.';
}



// Создание сделки

$deal_url = 'https://ilya754.amocrm.ru/api/v4/leads';
$post_data = [
    'post_data' => [
        // Если потребуются манипуляции с названием сделки
        // 'name' => 'Название сделки',
        'price' =>$deal->getPrice(),
       
    ],
];

$curl = curl_init($deal_url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($post_data));
curl_setopt($curl, CURLOPT_HTTPHEADER, [
    'Authorization: Bearer ' . $access_token,
    'Content-Type: application/json',
]);

$response = curl_exec($curl);
curl_close($curl);

// Обработка ответа
if ($response) {
    $response_data = json_decode($response, true);
    $lead_id = $response_data['_embedded']['leads'][0]['id'];
    $lead_link = $response_data['_embedded']['leads'][0]['_links']['self']['href'];
} else {
    echo 'Ошибка при создании сделки.';
}



// Прикрепление контакта к сделке

$dealId = $lead_id; // ID сделки, к которой вы хотите добавить контакт
$contactId = $contact_id; // ID контакта, который вы хотите добавить

$apiUrl = 'https://ilya754.amocrm.ru/api/v4/leads/' . $dealId . '/link';

$data = [
    'post_data' => [
    'to_entity_id' => $contactId,
    'to_entity_type' => 'contacts',
    ],
];

$curl = curl_init();
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_URL, $apiUrl);
curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($curl, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Authorization: Bearer ' . $access_token,
]);

$responseAddContact = curl_exec($curl);
curl_close($curl);

// Обработка ответа
$result = json_decode($response, true);
if ($response) {
} else {
    echo 'Произошла ошибка при добавлении контакта к сделке.';
}


header('Content-Type: application/json');
echo json_encode($response);

?>