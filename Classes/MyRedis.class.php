<?php

/**
 * This file is part of YouTube API project.
 * © 2018 byvlad
 */

/**
 * Class MyRedis
 */
class MyRedis
{
    private const REDIS_SERVER       = '195.201.84.100';
    private const REDIS_SCHEME   = 'tcp';
    private const REDIS_PORT     = 6379;
    private const REDIS_PASSWORD = 'zako@1996';
    private const REDIS_EXPIRE   = 3600;

    /**
     * @var Client $redis
     */
    private $redis;
    // private $redisS2;

    /**
     * MyRedis constructor.
     */
    public function __construct()
    {

        try {
            $this->redis = new Redis();
            $this->redis->connect(self::REDIS_SERVER, self::REDIS_PORT);
            $this->redis->auth(self::REDIS_PASSWORD);

        } catch(RedisException $e) {
            // exit('Connect error');
            die('Connect error: '.$e->getMessage());
        } 
        // try {
        //     $this->redisS1 = new Client([ 'password' => self::REDIS_PASSWORD]);
            // $this->redisS1 = new Client([
            //     'scheme'   => self::REDIS_SCHEME,
            //     'host'     => self::REDIS_S1,
            //     'port'     => self::REDIS_PORT,
            //     'password' => self::REDIS_PASSWORD,
            // ]);
        // } catch (Exception $exception) {
        //      die($e->getMessage());
        //     // die(self::REDIS_S1.': '.$exception->getMessage());
        // }

        // try {
        //     $this->redisS2 = new Client([
        //         'scheme'   => self::REDIS_SCHEME,
        //         'host'     => self::REDIS_S2,
        //         'port'     => self::REDIS_PORT,
        //         'password' => self::REDIS_PASSWORD,
        //     ]);
        // } catch (Exception $exception) {
        //     die(self::REDIS_S2.': '.$exception->getMessage());
        // }
    }
    public function ttl(string $key){
         return $this->redis->ttl($key);
    }

    /**
     * @param string $key
     * @return string
     */
    public function get(string $key)
    { 
        return $this->redis->get($key);
        // return unserialize($this->getServer($key)->get($this->encodeKey($key)));
    }

    /**
     * @param string $key
     * @param $data
     * @param int $expire
     * @return mixed
     */
    public function set(string $key, $data, int $expire = self::REDIS_EXPIRE)
    {
        // $encodedKey = $this->encodeKey($key);
        // return $redis->set($encodedKey, serialize($data), 'EX', $expire);
         $this->redis->set($key, serialize($data));
         $this->redis->expire($encodedKey, $expire);

         return '';
    }

     public function expire(string $key, int $expire = self::REDIS_EXPIRE){
        $encodedKey = $this->encodeKey($key);
         $redis      = $this->getServer($key);
        return $redis->expire($encodedKey, $expire);
    }


    /**
     * @param string $key
     * @return int
     */
    public function exists(string $key)
    {
        return $this->getServer($key)->exists($this->encodeKey($key));
    }

    /**
     * @param string $key
     * @return Client
     */
    // private function getServer(string $key): Client
    // {
    //     $encodedKey = $this->encodeKey($key);
    //     // $redis      = in_array($encodedKey{0}, range('a', 'k')) ? $this->redisS1 : $this->redisS2;
    //     $redis = $this->redisS1;
    //     return $redis;
    // }

    /**
     * @param string $key
     * @return string
     */
    private function encodeKey(string $key): string
    {
        return strtolower(sha1($key));
    }
}