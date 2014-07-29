<?php

namespace SyncFS\Test;

/**
 * Class TestCase
 *
 * @package SyncFS\Test
 * @author  Matej Velikonja <matej@velikonja.si>
 */
class TestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * Returns folder where data for test is saved.
     *
     * @return string
     */
    protected function getTestDataDir()
    {
        return $this->getRealPath(
            TEST_DIR . '/SyncFS/Test/Resources/data/'
        );
    }

    /**
     * Returns path to config.example.yml file.
     *
     * @return string
     */
    protected function getConfigExampleFilePath()
    {
        return $this->getRealPath(
            $this->getTestDataDir() . '/config.example.yml'
        );
    }

    /**
     * Returns path to temporary folder.
     *
     * @return string
     */
    protected function getTmpDir()
    {
        // appends tmp after real path call, because it does not exists always
        return $this->getRealPath(TEST_DIR . '/../') . '/tmp';
    }

    /**
     * @param string $path
     *
     * @throws \Exception
     *
     * @return string
     */
    private function getRealPath($path)
    {
        if ($realPath = realpath($path)) {
            return $realPath;
        }

        throw new \Exception(sprintf('Path `%s` can not be found.', $path));
    }
}
