<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class LockController extends Controller
{
    const TIMES = 10000;
    protected int $expired = 100;
    protected int $blockTime = 50;

    protected int $filePutContentMode = LOCK_EX;
    public function noLockInTwoProcess()
    {
        $file = storage_path() . "/logs/noLockInTwoProcess.txt";
        $this->putContent($file, 0, $this->filePutContentMode);
        $pid = pcntl_fork();
        if ($pid) {
            for ($i = 0; $i < self::TIMES ; $i++) {
                $content = (int)file_get_contents($file);
                $this->putContent($file, ($content + 1), $this->filePutContentMode);
            }
        } else {
            for ($i = 0; $i < self::TIMES ; $i++) {
                $content = (int)file_get_contents($file);
                $this->putContent($file, ($content + 1), $this->filePutContentMode);
            }
        }
        return file_get_contents($file);
    }

    public function lockInTwoProcess()
    {
        $file = storage_path() . "/logs/lockInTwoProcess.txt";
        $this->putContent($file, 0, $this->filePutContentMode);
        $pid = pcntl_fork();
        if ($pid) {
            for ($i = 0; $i < self::TIMES ; $i++) {
                $lock = Cache::lock($file, $this->expired);
                if ($lock->get()) {
                    $content = (int)file_get_contents($file);
                    $this->putContent($file, ($content + 1), $this->filePutContentMode);
                    $lock->release();
                }
            }
        } else {
            for ($i = 0; $i < self::TIMES ; $i++) {
                $lock = Cache::lock($file, $this->expired);
                if ($lock->get()) {
                    $content = (int)file_get_contents($file);
                    $this->putContent($file, ($content + 1), $this->filePutContentMode);
                    $lock->release();
                }
            }
        }
        pcntl_waitpid($pid, $status);
        return file_get_contents($file);
    }


    public function lockInTwoProcess1()
    {
        $file = storage_path() . "/logs/lockInTwoProcess1.txt";
        $this->putContent($file, 0, $this->filePutContentMode);
        $pid = pcntl_fork();
        if ($pid) {
            for ($i = 0; $i < self::TIMES ; $i++) {
                $lock = Cache::lock($file, $this->expired);
                try {
                    $lock->block($this->blockTime);
                    $content = (int)file_get_contents($file);
                    $this->putContent($file, ($content + 1), $this->filePutContentMode);
                } catch (\Exception $e) {
                    throw new \Exception($e->getMessage());
                } finally {
                    $lock->release();
                }
            }
//            pcntl_waitpid($pid, $status);
//            return file_get_contents($file);
        } else {
            for ($i = 0; $i < self::TIMES ; $i++) {
                $lock = Cache::lock($file, $this->expired);
                try {
                    $lock->block($this->blockTime);
                    $content = (int)file_get_contents($file);
                    $this->putContent($file, ($content + 1), $this->filePutContentMode);
                } catch (\Exception $e) {
                    throw new \Exception($e->getMessage());
                } finally {
                    $lock->release();
                }
            }
//            return '123';
        }
        $res = Cache::lock($file, $this->expired)->block($this->blockTime, function () use ($file) {
            return file_get_contents($file);
        });
        $file_get_contents = file_get_contents($file);
        return $res;
    }
    public function lock()
    {
        $file = storage_path() . "/logs/lock.txt";
        $this->putContent($file, 0, $this->filePutContentMode);
        for ($i = 0; $i < self::TIMES ; $i++) {
            $lock = Cache::lock($file, $this->expired);
            if ($lock->get()) {
                $content = (int)file_get_contents($file);
                $this->putContent($file, ($content + 1), $this->filePutContentMode);
                $lock->release();
            }
        }
        return file_get_contents($file);
    }

    public function noLock()
    {
        $file = storage_path() . "/logs/noLock.txt";
        $this->putContent($file, 0, $this->filePutContentMode);
        for ($i = 0; $i < self::TIMES ; $i++) {
            $content = (int)file_get_contents($file);
            $this->putContent($file, ($content + 1), $this->filePutContentMode);
        }
        return file_get_contents($file);
    }

    /**
     * @throws \Exception
     */
    protected function putContent($file, $content, $mode): void
    {
        $res = file_put_contents($file, $content, $mode);
        if (false === $res) {
            throw new \Exception("file_put_content fail");
        }
    }
}
