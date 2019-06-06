<?php

namespace App\Communications\Api;

use App\Communications\JsonRpcInterface;

class OnsetDetector implements OnsetDetectorInterface
{
    /** @var JsonRpcInterface */
    private $rpc;

    public function __construct(JsonRpcInterface $rpc)
    {
        $this->rpc = $rpc;
    }

    public function getData(string $filename): Onset
    {
        $data = $this->rpc->send('serialize', [
            'name' => './'.$filename
        ]);

        if ($data->hasError()) {
            throw new \Exception($data->getError());
        }

        $data = json_decode($data->getResult());

        return new Onset($data[0], $data[1]);
    }
}
