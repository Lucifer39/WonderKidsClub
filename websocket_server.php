<?php
// websocket_server.php

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;

require 'vendor/autoload.php';

class WebSocketServer implements MessageComponentInterface
{
    protected $clients;
    protected $rooms;

    public function __construct()
    {
        $this->clients = new \SplObjectStorage();
        $this->rooms = [];
    }

    public function onOpen(ConnectionInterface $conn)
    {
        // Handle query parameters to get the room name from the client
        $query = $conn->httpRequest->getUri()->getQuery();
        parse_str($query, $queryParams);
        $roomName = isset($queryParams['room']) ? $queryParams['room'] : 'default';
        
        // Attach the connection to the room
        $this->clients->attach($conn, $roomName);

        if (!isset($this->rooms[$roomName])) {
            $this->rooms[$roomName] = new \SplObjectStorage();
        }

        $this->rooms[$roomName]->attach($conn);

        // Print the connection URL
        echo "New connection! ({$conn->resourceId}) Room: $roomName\n";
        echo "Connection URL: wss://{$conn->httpRequest->getHeader('host')[0]}/?room=$roomName\n";
    }

    public function onMessage(ConnectionInterface $from, $msg)
    {
        $roomName = $this->clients[$from];

        foreach ($this->rooms[$roomName] as $client) {
            // Only broadcast the message to clients in the same room
            if ($client !== $from) {
                $client->send($msg);
            }
        }
    }

    public function onClose(ConnectionInterface $conn)
    {
        $roomName = $this->clients[$conn];

        $this->clients->detach($conn);
        $this->rooms[$roomName]->detach($conn);

        echo "Connection {$conn->resourceId} has disconnected from Room: $roomName\n";

        // Check if the room is empty
        if ($this->rooms[$roomName]->count() === 0) {
            unset($this->rooms[$roomName]);
            echo "Room $roomName is now empty and has been removed\n";
        }
    }

    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        echo "An error occurred: {$e->getMessage()}\n";
        $conn->close();
    }
}

// Set the path to your SSL/TLS certificate and private key
$sslContext = stream_context_create([
    'ssl' => [
        'local_cert' => '/etc/ssl/virtualmin/170361134019761/certificate.pem',
        'local_pk'   => '/etc/ssl/virtualmin/170361134019761/pvt_key.pem',
        'protocols'  => 'TLSv1.2', // Adjust as needed
    ],
]);

$server = IoServer::factory(
    new HttpServer(
        new WsServer(
            new WebSocketServer()
        )
    ),
    8888,
    '0.0.0.0',
    $sslContext  // Include the SSL context
);

$server->run();
?>
