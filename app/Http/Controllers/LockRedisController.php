<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;

class LockRedisController extends Controller
{
    const TIMES = 10000;
    protected int $expired = 100;
    protected int $blockTime = 50;

    protected int $filePutContentMode = LOCK_EX;
    public function noLockInTwoProcess()
    {
        $key = "noLockInTwoProcess.txt";
        $this->putContent($key, 0, $this->filePutContentMode);
        if ('0' !== $this->getContent($key)) {
            throw new \Exception("init data fail");
        }
        // 初始化计数器
        $this->initCount($key);
        if ('0' !== $this->getCount($key)) {
            throw new \Exception("init count fail");
        }
        Redis::close();
        $pid = pcntl_fork();
        if ($pid) {
            for ($i = 0; $i < self::TIMES ; $i++) {
                $content = (int)$this->getContent($key);
                $this->putContent($key, ($content + 1), $this->filePutContentMode);
                $this->incCount($key);
            }
            pcntl_waitpid($pid, $status);
        } else {
            for ($i = 0; $i < self::TIMES ; $i++) {
                $content = (int)$this->getContent($key);
                $this->putContent($key, ($content + 1), $this->filePutContentMode);
                $this->incCount($key);
            }
            $loop = 100;
            do {
                $count = $this->getCount($key);
                usleep(10000);
                if (!$loop--) {
                    throw new \Exception("msg:timesOut, res:" . $count);
                }
            } while ($count < self::TIMES * 2);
        }
        return $this->getContent($key);
    }

    public function lockInTwoProcess()
    {
        $key = "lockInTwoProcess.txt";
        $this->putContent($key, 0, $this->filePutContentMode);
        Redis::close();
        $pid = pcntl_fork();
        if ($pid) {
            for ($i = 0; $i < self::TIMES ; $i++) {
                $lock = Cache::lock($key, $this->expired);
                if ($lock->get()) {
                    $content = (int)$this->getContent($key);
                    $this->putContent($key, ($content + 1), $this->filePutContentMode);
                    $lock->release();
                }
            }
        } else {
            for ($i = 0; $i < self::TIMES ; $i++) {
                $lock = Cache::lock($key, $this->expired);
                if ($lock->get()) {
                    $content = (int)$this->getContent($key);
                    $this->putContent($key, ($content + 1), $this->filePutContentMode);
                    $lock->release();
                }
            }
        }
        pcntl_waitpid($pid, $status);
        return $this->getContent($key);
    }


    public function lockInTwoProcess1()
    {
        $ppid = posix_getpid();
        $key = "lockInTwoProcess1.txt";
        $this->putContent($key, 0, $this->filePutContentMode);
        $this->putContent($key, 0, $this->filePutContentMode);
        if ('0' !== $this->getContent($key)) {
            throw new \Exception("init data fail");
        }
        // 初始化计数器
        $this->initCount($key);
        if ('0' !== $this->getCount($key)) {
            throw new \Exception("init count fail");
        }
        Redis::close();
        $pid = pcntl_fork();
//        /* debug pid
//        if ($pid) {
//            $b = $pid;
//            $curPid1 = posix_getpid();
//            sleep(1);
//            pcntl_waitpid($pid, $status);
//            file_put_contents('111111111111111.txt', json_encode(['curPid' => $curPid1, 'pid' => $pid]));
//        } else {
//            $a = $pid;
//            $curPid = posix_getpid();
////            sleep(1);
//
////            pcntl_waitpid($ppid, $status);
//            file_put_contents('222222222222222.txt', json_encode(['curPid' => $curPid, 'pid' => $pid]));
//        }
//        return ['pid' => $pid, 'ppid' => $ppid];
        if ($pid) {
            for ($i = 0; $i < self::TIMES ; $i++) {
                $lock = Cache::lock($key, $this->expired);
                try {
                    $lock->block($this->blockTime);
                    $content = (int)$this->getContent($key);
                    $this->putContent($key, ($content + 1), $this->filePutContentMode);
                } catch (\Exception $e) {
                    throw new \Exception($e->getMessage());
                } finally {
                    $lock->release();
                }
                $this->incCount($key);
            }
            pcntl_waitpid($pid, $status);
        } else {
            for ($i = 0; $i < self::TIMES ; $i++) {
                $lock = Cache::lock($key, $this->expired);
                try {
                    $lock->block($this->blockTime);
                    $content = (int)$this->getContent($key);
                    $this->putContent($key, ($content + 1), $this->filePutContentMode);
                } catch (\Exception $e) {
                    throw new \Exception($e->getMessage());
                } finally {
                    $lock->release();
                }
                $this->incCount($key);
            }
            $loop = 100;
            do {
                $count = $this->getCount($key);
                usleep(10000);
                if (!$loop--) {
                    throw new \Exception("msg:timesOut, res:" . $count);
                }
            } while ($count < self::TIMES * 2);
//            return '123';
        }
        $res = $this->getContent = $this->getContent($key);
        return $res;
    }
    public function lock()
    {
        $key = "lock.txt";
        $this->putContent($key, 0, $this->filePutContentMode);
        for ($i = 0; $i < self::TIMES ; $i++) {
            $lock = Cache::lock($key, $this->expired);
            if ($lock->get()) {
                $content = (int)$this->getContent($key);
                $this->putContent($key, ($content + 1), $this->filePutContentMode);
                $lock->release();
            }
        }
        return $this->getContent($key);
    }

    public function noLock()
    {
        $key = "noLock.txt";
        $this->putContent($key, 0, $this->filePutContentMode);
        for ($i = 0; $i < self::TIMES ; $i++) {
            $content = (int)$this->getContent($key);
            $this->putContent($key, ($content + 1), $this->filePutContentMode);
        }
        return $this->getContent($key);
    }

    /**
     * @throws \Exception
     */
    protected function putContent($key, $content, $mode)
    {
         return Redis::set($key, $content);
    }
    protected function getContent($key)
    {
        return Redis::get($key);
    }
    protected function initCount($key) {
        return Redis::set($key . '_count', 0);
    }
    protected function getCount($key) {
        return Redis::get($key . '_count');
    }
    protected function incCount($key) {
        return Redis::incr($key . '_count', 1);
    }
}
