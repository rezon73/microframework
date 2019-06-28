<?php

require_once dirname(__FILE__) . '/../lib/functions.php';

class ConsoleApp extends Singleton implements IApp
{
    /**
     * @var array
     */
    protected $args;

    /**
     * @return array
     */
    public function getArgs(): array
    {
        return $this->args;
    }

    /**
     * @param array $args
     * @return $this
     */
    public function setArgs(array $args)
    {
        $this->args = $args;

        return $this;
    }

    public function start()
    {
        $args = $this->getArgs();

        if (empty($args[1])) {
            echo PHP_EOL . 'ERROR: you have to set command name from directory "application/commands/*"' . PHP_EOL;
            exit(0);
        }

        $commandName = ucfirst($args[1]) . 'Command';

        if (!class_exists($commandName)) {
            echo PHP_EOL . 'ERROR: Command ' . $commandName . ' not found. Use command from directory "application/commands/*"' . PHP_EOL;
            exit(0);
        }

        unset($args[0], $args[1]);

        $taskLocker = new TaskLocker(Config::me()->get('lockFileDir') . '/' . $commandName . '_' . md5(implode(':', $args)) . '.lock');
        if ($taskLocker->isLocked()) {
            exit(0);
        }

        try {
            /** @var ICommand $command */
            $command = new $commandName;
            $command->execute(array_values($args));
        }
        catch (Exception $e) {
            echo PHP_EOL . ' EXCEPTION: ' . $e->getMessage();
        }
        finally {
            $taskLocker->unlock();
        }
    }
}