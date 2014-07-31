<?php

namespace SyncFS;

use Symfony\Component\Finder\Finder;

/**
 * Class AutoLoader
 *
 * @author Matej Velikonja <matej@velikonja.si>
 */
class AutoLoader
{
    /**
     * @var string
     */
    private $libDir;

    /**
     * @param string $libDir | Directory to lib folder
     */
    public function __construct($libDir)
    {
        $this->libDir = $libDir;
    }

    /**
     * Returns an array of initialized commands.
     *
     * @return array
     */
    public function getCommands()
    {
        $finder = new Finder();
        $finder
            ->files()
            ->in($this->libDir . '/Command')
            ->name('/(\w+)Command.php/');

        $commands = array();
        /** @var \SplFileInfo $file */
        foreach ($finder as $file) {
            $className  = str_replace('.php', '', $file->getFilename());
            $className  = '\\SyncFS\\Command\\' . $className;
            $commands[] = new $className();
        }

        return $commands;
    }
}
