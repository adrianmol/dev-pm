<?php

namespace DevPM\Application\Project\Business;


use DevPM\Application\Project\Business\Reader\ProjectReader;
use DevPM\Application\Project\Business\Writer\ProjectWriter;
use DevPM\Application\Project\Persistence\Repository\ProjectRepository;

class ProjectBusinessFactory
{
    public function createProjectWriter(): ProjectWriter
    {
        return new ProjectWriter(
            $this->createProjectRepository(),
        );
    }

    public function createProjectReader(): ProjectReader
    {
        return new ProjectReader(
            $this->createProjectRepository(),
        );
    }

    protected function createProjectRepository(): ProjectRepository
    {
        return new ProjectRepository;
    }
}
