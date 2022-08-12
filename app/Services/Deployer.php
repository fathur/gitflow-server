<?php

namespace App\Services;

class Deployer
{
    public function __construct()
    {
        
    }

    public function createDNSDomain($domain)
    {
        return $this;
    }

    public function deleteDNSDomain($domain)
    {
        return $this;
    }

    public function cloneRepoInBranch($branch)
    {
        return $this;
    }

    public function deleteRepoInBranch($branch)
    {
        return $this;
    }

    public function createNginxVirtualHost()
    {
        return $this;
    }

    public function deleteNginxVirtualHost()
    {
        return $this;
    }

    public function restartNginx()
    {
        return $this;
    }
}