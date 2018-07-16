<?php


namespace App\Utils;


use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class ClientHost implements ClientHostInterface
{
    private $host;

    public function __construct(ParameterBagInterface $bag)
    {
        $this->host = $bag->get('client_host');
    }

    public function getHost(): string
    {
        return $this->host;
    }
}