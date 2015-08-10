<?php

namespace AllanSimon\TestHelpers;

trait IsLoggedControllerTestTrait
{
    use IsControllerTestTrait;

    protected function getClient() {
        return $this->makeClient(true);
    }

    protected abstract function makeClient($authentication = false, array $params = []);
}
