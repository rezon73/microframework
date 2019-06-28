<?php

class TaskLocker
{
    private $lockFileDescriptor;
    private $lockFilename;

    public function __construct($lockFilename) {
        $this->lockFilename = $lockFilename;

        if (!file_exists($lockFilename)) {
            touch($lockFilename);
        }
    }

    /**
     * @return bool
     */
    public function isLocked() {
        $this->lockFileDescriptor = fopen($this->lockFilename, 'w+');

        if (
            !$this->lockFileDescriptor
            || !flock($this->lockFileDescriptor, LOCK_EX | LOCK_NB)
        ) {
            fclose($this->lockFileDescriptor);

            return true;
        }

        return false;
    }

    public function unlock() {
        if (!$this->lockFileDescriptor) {
            return;
        }

        flock($this->lockFileDescriptor, LOCK_UN);
        fclose($this->lockFileDescriptor);

        if (file_exists($this->lockFilename)) {
            unlink($this->lockFilename);
        }
    }
}