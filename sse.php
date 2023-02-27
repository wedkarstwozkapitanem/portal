<?php

// Ustawiamy nagłówki dla SSE
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');

// Tablica, która będzie przechowywała wiadomości w pamięci
$messages = [];

// Funkcja pomocnicza do wysyłania SSE
function sendSSE($data) {
    echo "data: " . $data . "\n\n";
    ob_flush();
    flush();
}

// Pętla nieskończona, która co sekundę sprawdza, czy pojawiły się nowe wiadomości
while (true) {
    $newMessages = [];
    foreach ($messages as $message) {
        // Jeśli wiadomość ma timestamp większy niż wartość 'lastEventId' w nagłówku SSE,
        // oznacza to, że jest to nowa wiadomość, którą należy wysłać
        if ($message['timestamp'] > $_SERVER['HTTP_LAST_EVENT_ID']) {
            $newMessages[] = $message;
        }
    }
    if (!empty($newMessages)) {
        // Łączymy wiadomości w jeden ciąg znaków, oddzielając je znakami nowej linii
        $messageString = implode("\n", $newMessages);
        sendSSE($messageString);
    }
    sleep(1);
}

// W tym miejscu należy dodać kod obsługujący wysyłanie nowych wiadomości
// Funkcja powinna dodawać nowe wiadomości do tablicy $messages w pamięci
// wraz z aktualnym timestampem
// Następnie można przesłać te wiadomości przez SSE, wysyłając je jako jeden ciąg znaków
// oddzielonych znakami nowej linii za pomocą funkcji sendSSE()
