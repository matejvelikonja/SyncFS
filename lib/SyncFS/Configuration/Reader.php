<?php

namespace SyncFS\Configuration;

use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\Yaml\Parser;

/**
 * Class Reader
 *
 * @package SyncFS\Configuration
 * @author  Matej Velikonja <matej@velikonja.si>
 */
class Reader
{
    /**
     * @var \Symfony\Component\Config\Definition\ConfigurationInterface
     */
    private $configuration;

    /**
     * @var \Symfony\Component\Yaml\Parser
     */
    private $parser;

    /**
     * @var \Symfony\Component\Config\Definition\Processor
     */
    private $processor;

    /**
     * @param ConfigurationInterface $configuration
     * @param Parser                 $parser
     * @param Processor              $processor
     */
    public function __construct(ConfigurationInterface $configuration, $parser = null, $processor = null)
    {
        if (! $parser) {
            $parser = new Parser();
        }

        if (! $processor) {
            $processor = new Processor();
        }

        $this->configuration = $configuration;
        $this->parser        = $parser;
        $this->processor     = $processor;
    }

    /**
     * @param string $configPath
     *
     * @throws ReaderException
     *
     * @return array
     */
    public function read($configPath)
    {
        if (!is_readable($configPath)) {
            throw new ReaderException(sprintf('Configuration file `%s` cannot be read.', $configPath));
        }

        $content = file_get_contents($configPath);
        $data    = $this->parser->parse($content);

        if (! is_array($data)) {
            throw new ReaderException('Parsing error.');
        }

        try {
            $config  = $this->processor->processConfiguration(
                $this->configuration,
                $data
            );
        } catch (InvalidConfigurationException $e) {
            throw new ReaderException($e->getMessage());
        }

        return $config;
    }
}
