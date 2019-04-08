<?php

namespace Dr\Hc\Build;

use Dr\Hc\Build\Adapter\BitBucket;
use Dr\Hc\Build\Adapter\GitHub;

class Info
{
    public function git($checks)
    {
        $git = new GitHub;

        if ($checks->git->driver == "bitbucket") {
            $git = new BitBucket;
        }

        $git->setUri($checks->git->uri);
        $git->setApikey($checks->git->apikey);
        $git->setProject($checks->git->project_slug);
        $git->setRepository($checks->git->repository_name);
        $git->setEnvironment($checks->environment);

        $response = $git->get($checks);
        $response['environment'] = $git->getEnvironment();

        return $response;
    }
}
